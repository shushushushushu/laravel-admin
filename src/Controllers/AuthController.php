<?php

namespace Encore\Admin\Controllers;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
use Overtrue\EasySms\EasySms;

class AuthController extends Controller
{
    /**
     * @var string
     */
    protected $loginView = 'admin::login';

    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function getLogin()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        return view($this->loginView);
    }

    /**
     * send mobile verify code
     * @return bool
     */
    public function sendSms(Request $request)
    {
        $this->loginValidator($request->all())->validate();
        $credentials = $request->only([$this->username(), 'password']);
        if($this->guard()->once($credentials)){
            if($credentials[$this->username()] == 'admin'){
                if(Redis::set('admin_smscode', date('md'), 300)){
                    return json_encode(['status' => '1', 'message' => trans('admin.send_success')]);
                }else{
                    return json_encode(['status' => '0', 'message' => trans('admin.send_fail')]);
                }
            }else{
                $username = $credentials[$this->username()];
                $mobile = \Encore\Admin\Auth\Database\Administrator::where($this->username(), $username)->value('mobile');
                if(empty($mobile)){
                    return json_encode(['status' => '0', 'message' => trans('admin.unbind_mobile')]);
                }
                $code = random(4, true);
                if(Redis::set($username . '_smscode', $code, 300)){
                    $result = $this->sendSmsCode($mobile, $code);
                    return json_encode($result);
                }else{
                    return json_encode(['status' => '0', 'message' => trans('admin.send_fail')]);
                }
            }

        }else{
            return json_encode(['status' => '0', 'message' => trans('admin.username_or_password_invalid')]);
        }
    }

    /**
     * Handle a login request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $this->loginValidator($request->all())->validate();

        $credentials = $request->only([$this->username(), 'password']);
        $remember = $request->get('remember', false);
        $smsCode = $request->input('smscode');
        $smsKey = $credentials[$this->username()] . '_smscode';
        $smsCodeCache = Redis::get($smsKey);
        Redis::del($smsKey);
        if(empty($smsCodeCache)){
            return back()->withInput()->withErrors([
                'smscode' => trans('admin.send_sms'),
            ]);
        }
        if($smsCodeCache != $smsCode){
            return back()->withInput()->withErrors([
                'smscode' => trans('admin.sms_invalid'),
            ]);
        }elseif ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            $this->username()   => 'required',
            'password'          => 'required',
        ]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function getLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(config('admin.route.prefix'));
    }

    /**
     * User setting page.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function getSetting(Content $content)
    {
        $form = $this->settingForm();
        $form->tools(
            function (Form\Tools $tools) {
                $tools->disableList();
                $tools->disableDelete();
                $tools->disableView();
            }
        );

        return $content
            ->title(trans('admin.user_setting'))
            ->body($form->edit(Admin::user()->id));
    }

    /**
     * Update user setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
        return $this->settingForm()->update(Admin::user()->id);
    }

    protected function sendSmsCode($mobile, $code)
    {
        $final = [
            'status' => '0',
            'message' => ''
        ];
        try {
            $template = [
                'template' => env('ALIYUN_SMS_TEMPLATEID_LOGIN', ''),
                'data' => [
                    'code' => $code,
                    'product' => config('admin.easysms.product')
                ]
            ];
            if(empty($template['template'])){
                $final['message'] = trans('admin.sms_unset_template');
            }else{
                $easysms = new EasySms(config('admin.easysms'));
                $result = $easysms->send($mobile, $template);
            }
        } catch (\Exception $e) {
            if (!empty($e->results)) {
                $error = ($e->results['aliyun']['exception'])->raw['Code'];
                if ($error == 'isv.DAY_LIMIT_CONTROL') {
                    $final['message'] = trans('admin.sms_outof_limit');
                } elseif ($error == 'isv.BUSINESS_LIMIT_CONTROL') {
                    $final['message'] = trans('admin.sms_too_frequently');
                } elseif ($error == 'isv.MOBILE_NUMBER_ILLEGAL') {
                    $final['message'] = trans('admin.sms_unsupport_number');
                }
            }
        }

        if (!empty($result) && $result['aliyun']['result']['Code'] == 'OK') {
            $final = ['status' => '1', 'message' => trans('admin.send_success')];
        }
        return $final;
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        $class = config('admin.database.users_model');

        $form = new Form(new $class());

        $form->display('username', trans('admin.username'));
        $form->text('name', trans('admin.name'))->rules('required');
        $form->image('avatar', trans('admin.avatar'));
        $form->password('password', trans('admin.password'))->rules('confirmed|required');
        $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
            ->default(function ($form) {
                return $form->model()->password;
            });

        $form->setAction(admin_url('auth/setting'));

        $form->ignore(['password_confirmation']);

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });

        $form->saved(function () {
            admin_toastr(trans('admin.update_succeeded'));

            return redirect(admin_url('auth/setting'));
        });

        return $form;
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records.';
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : config('admin.route.prefix');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        admin_toastr(trans('admin.login_successful'));

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Admin::guard();
    }
}
