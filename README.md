<p align="center">
<a href="https://laravel-admin.org/">
<img src="https://laravel-admin.org/images/logo002.png" alt="laravel-admin">
</a>

<p align="center">⛵<code>laravel-admin</code> is administrative interface builder for laravel which can help you build CRUD backends just with few lines of code.</p>

<p align="center">
<a href="https://laravel-admin.org/docs">Documentation</a> |
<a href="https://laravel-admin.org/docs/zh">中文文档</a> |
<a href="https://demo.laravel-admin.org">Demo</a> |
<a href="https://github.com/z-song/demo.laravel-admin.org">Demo source code</a> |
<a href="#extensions">Extensions</a>
</p>

<p align="center">
    Inspired by <a href="https://github.com/sleeping-owl/admin" target="_blank">SleepingOwlAdmin</a> and <a href="https://github.com/zofe/rapyd-laravel" target="_blank">rapyd-laravel</a>.
</p>

Sponsor
------------

<a href="https://ter.li/32ifxj">
<img src="https://user-images.githubusercontent.com/1479100/102449272-dc356880-406e-11eb-9079-169c8c2af81c.png" alt="laravel-admin" width="200px;">
</a>

###statement
This is a replica that clone from laravel-admin,and make some changes to meet product requirements.
                                                    


Requirements
------------
 - PHP >= 7.0.0
 - Laravel >= 5.5.0
 - Fileinfo PHP Extension

Installation
------------

> This package requires PHP 7+ and Laravel 5.5, for old versions please refer to [1.4](https://laravel-admin.org/docs/v1.4/#/)

First, install laravel 5.5, and make sure that the database connection settings are correct.

```
composer require shushushushushu/laravel-admin:^1.2.0
```

Then run these commands to publish assets and config：

```
php artisan vendor:publish --provider="shushushushushu\Admin\AdminServiceProvider"
```
After run command you can find config file in `config/admin.php`, in this file you can change the install directory,db connection or table names.

At last run following command to finish install.
```
php artisan admin:install
```

Open `http://localhost/admin/` in browser,use username `admin` and password `admin` to login.

Configurations
------------
The file `config/admin.php` contains an array of configurations, you can find the default configurations in there.

## Extensions

| Extension                                        | Description                              | laravel-admin                              |
| ------------------------------------------------ | ---------------------------------------- |---------------------------------------- |
| [helpers](https://github.com/laravel-admin-extensions/helpers)             | Several tools to help you in development | ~1.5 |
| [media-manager](https://github.com/laravel-admin-extensions/media-manager) | Provides a web interface to manage local files          | ~1.5 |
| [api-tester](https://github.com/laravel-admin-extensions/api-tester) | Help you to test the local laravel APIs          |~1.5 |
| [scheduling](https://github.com/laravel-admin-extensions/scheduling) | Scheduling task manager for laravel-admin          |~1.5 |
| [redis-manager](https://github.com/laravel-admin-extensions/redis-manager) | Redis manager for laravel-admin          |~1.5 |
| [backup](https://github.com/laravel-admin-extensions/backup) | An admin interface for managing backups          |~1.5 |
| [log-viewer](https://github.com/laravel-admin-extensions/log-viewer) | Log viewer for laravel           |~1.5 |
| [config](https://github.com/laravel-admin-extensions/config) | Config manager for laravel-admin          |~1.5 |
| [reporter](https://github.com/laravel-admin-extensions/reporter) | Provides a developer-friendly web interface to view the exception          |~1.5 |
| [wangEditor](https://github.com/laravel-admin-extensions/wangEditor) | A rich text editor based on [wangeditor](http://www.wangeditor.com/)         |~1.6 |
| [summernote](https://github.com/laravel-admin-extensions/summernote) | A rich text editor based on [summernote](https://summernote.org/)          |~1.6 |
| [china-distpicker](https://github.com/laravel-admin-extensions/china-distpicker) | 一个基于[distpicker](https://github.com/fengyuanchen/distpicker)的中国省市区选择器          |~1.6 |
| [simplemde](https://github.com/laravel-admin-extensions/simplemde) | A markdown editor based on [simplemde](https://github.com/sparksuite/simplemde-markdown-editor)          |~1.6 |
| [phpinfo](https://github.com/laravel-admin-extensions/phpinfo) | Integrate the `phpinfo` page into laravel-admin          |~1.6 |
| [php-editor](https://github.com/laravel-admin-extensions/php-editor) <br/> [python-editor](https://github.com/laravel-admin-extensions/python-editor) <br/> [js-editor](https://github.com/laravel-admin-extensions/js-editor)<br/> [css-editor](https://github.com/laravel-admin-extensions/css-editor)<br/> [clike-editor](https://github.com/laravel-admin-extensions/clike-editor)| Several programing language editor extensions based on code-mirror          |~1.6 |
| [star-rating](https://github.com/laravel-admin-extensions/star-rating) | Star Rating extension for laravel-admin          |~1.6 |
| [json-editor](https://github.com/laravel-admin-extensions/json-editor) | JSON Editor for Laravel-admin          |~1.6 |
| [grid-lightbox](https://github.com/laravel-admin-extensions/grid-lightbox) | Turn your grid into a lightbox & gallery          |~1.6 |
| [daterangepicker](https://github.com/laravel-admin-extensions/daterangepicker) | Integrates daterangepicker into laravel-admin          |~1.6 |
| [material-ui](https://github.com/laravel-admin-extensions/material-ui) | Material-UI extension for laravel-admin          |~1.6 |
| [sparkline](https://github.com/laravel-admin-extensions/sparkline) | Integrates jQuery sparkline into laravel-admin          |~1.6 |
| [chartjs](https://github.com/laravel-admin-extensions/chartjs) | Use Chartjs in laravel-admin          |~1.6 |
| [echarts](https://github.com/laravel-admin-extensions/echarts) | Use Echarts in laravel-admin          |~1.6 |
| [simditor](https://github.com/laravel-admin-extensions/simditor) | Integrates simditor full-rich editor into laravel-admin          |~1.6 |
| [cropper](https://github.com/laravel-admin-extensions/cropper) | A simple jQuery image cropping plugin.          |~1.6 |
| [composer-viewer](https://github.com/laravel-admin-extensions/composer-viewer) | A web interface of composer packages in laravel.          |~1.6 |
| [data-table](https://github.com/laravel-admin-extensions/data-table) | Advanced table widget for laravel-admin |~1.6 |
| [watermark](https://github.com/laravel-admin-extensions/watermark) | Text watermark for laravel-admin |~1.6 |
| [google-authenticator](https://github.com/ylic/laravel-admin-google-authenticator) | Google authenticator |~1.6 |



## Changes
 1.method sanitizeInput() in src\Form\Field.php change as:
```
protected function sanitizeInput($input, $column)
{
    if ($this instanceof Field\MultipleSelect) {
        $value = Arr::get($input, $column);
        Arr::set($input, $column, array_filter($value, function($val){
            return $val !== '' && $val !== null && $val !== false;
        }));
    }
    return $input;
}
```
    purpose: submit form can be access when checkbox select 0 and rule contains required
    
 2.reform component 'Select':
 
    ①method ajax() in src\Form\Field\Select.php
    change select2's delay time of ajax request from 250ms to 500ms
    
    ②change name of a hidden input and set value:
    <input type="hidden" name="{{$name}}"/>
    change as 
    <input type="hidden" name="{{$name}}_hide" value="{{old($column, $value)}}"/>
    that can get old value when select option list from ajax request,
    
 3.insert error tips into resources/views/form.blade.php line 12:
```
@foreach($errors->getBags() as $bags)
    <div class="alert alert-danger">{{$bags->first()}}</div>
@endforeach
```
    
 4.in order to use alioss and support full url with domain make some changes in src\Form\Field\Image.php -> prepare():
```
if(isset(config('filesystems.disks.' . config('filesystems.default'))['remote_url'])){
    $remoteUrl = config('filesystems.disks.' . config('filesystems.default'))['remote_url'];
    $path = rtrim($remoteUrl, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $path;
}//add domain before return path if config remote_url

return $path;
```
5.login page add smscode verify using easy-sms
    These changes occurs in the tag 1.2.0 and some configuration is needed to make sure it works properly.

①users table add a column：
```
$table->char('mobile', 11);
```
②fill configurations of redis and the normal operation of the redis.

③add configuration of easysms to admin.config:
first add 'auth/sendsms' to "auth['excepts']" ensure interface 'auth/sendsms' not need auth,
and second:
```
'login_use_sms' => true,

'easysms' => [
    'timeout' => 5.0,
    'length' => 4,
    'expire' => 300,
    'product' => '',
    'default' => [
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
        'gateways' => [
            'aliyun'
        ]
    ],
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            'access_key_id' => env('ALIYUN_ACCESS_KEY_ID', ''),
            'access_key_secret' => env('ALIYUN_SECRET_ACCESS_KEY', ''),
            'sign_name' => env('ALIYUN_SMS_SIGN_NAME', ''),
        ]
    ]
],
```
if set login_use_sms=false,sms will be disabled.

you need config some env in .env forexample 'access_key_id' and son on.
For details, please see easysms official website

6.src/Form.php:
```
public function inputAll()
{
    return $this->inputs;
}
```
 

License
------------
`laravel-admin` is licensed under [The MIT License (MIT)](LICENSE).
