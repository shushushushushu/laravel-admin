<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  @if(!is_null($favicon = Admin::favicon()))
  <link rel="shortcut icon" href="{{$favicon}}">
  @endif

  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css") }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page" @if(config('admin.login_background_image'))style="background: url({{config('admin.login_background_image')}}) no-repeat;background-size: cover;"@endif>
<div class="login-box">
  <div class="login-logo">
    <a href="{{ admin_url('/') }}"><b>{{config('admin.name')}}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">{{ trans('admin.login') }}</p>

    <form action="{{ admin_url('auth/login') }}" method="post">
      <div class="form-group has-feedback {!! !$errors->has('username') ?: 'has-error' !!}">

        @if($errors->has('username'))
          @foreach($errors->get('username') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
          @endforeach
        @endif

        <input type="text" class="form-control" placeholder="{{ trans('admin.username') }}" name="username" value="{{ old('username') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback {!! !$errors->has('password') ?: 'has-error' !!}">

        @if($errors->has('password'))
          @foreach($errors->get('password') as $message)
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
          @endforeach
        @endif

        <input type="password" class="form-control" placeholder="{{ trans('admin.password') }}" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback {!! !$errors->has('smscode') ?: 'has-error' !!}">

          @if($errors->has('smscode'))
              @foreach($errors->get('smscode') as $message)
                  <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
              @endforeach
          @endif

          <input name="smscode" type="text" class="form-control" placeholder="{{ trans('admin.smscode') }}" style="width:60%; float:left;">
          <div class="pull-right">
              <button class="btn btn-primary btn-block" type="button" id="smscode">发送验证码</button>
          </div>
          <div style="clear:both;"></div>
      </div>

      <div class="row">
        <div class="col-xs-8">
          @if(config('admin.auth.remember'))
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" value="1" {{ (!old('username') || old('remember')) ? 'checked' : '' }}>
              {{ trans('admin.remember_me') }}
            </label>
          </div>
          @endif
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('admin.login') }}</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    $('form').on('submit', function(){
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();
        var smscode = $("input[name='smscode']").val();
        if(username.trim() == ''){
            Swal.fire({
                icon: 'error',
                title: '用户名不能为空',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }else if(password == ''){
            Swal.fire({
                icon: 'error',
                title: '密码不能为空',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }else if(smscode == ''){
            Swal.fire({
                icon: 'error',
                title: '验证码不能为空',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }
    });
  });

  //点击发送短信验证码
  $('#smscode').click(function(){
      var username = $("input[name='username']").val();
      var password = $("input[name='password']").val();
      var token = $("input[name='_token']").val();
      $.post("{{url('admin/auth/sendsms')}}", {'username':username, 'password':password, '_token': token}, function(data){
          console.log(data);
          var data = JSON.parse(data);
          if(data.status == 1)
          {
              Swal.fire({
                  icon: 'success',
                  title: '发送成功',
                  showConfirmButton: false,
                  timer: 1500
              });
              settime(60);
          }
          else
          {
              Swal.fire({
                  icon: 'error',
                  title: '发送失败',
                  text: data.message,
                  showConfirmButton: false,
                  timer: 2000
              });
          }
      });
      return false;
  });
  /*document.getElementById('smscode').onclick = function () {
      var username = document.getElementById('username').value;
      var password = document.getElementById('password').value;
      $.post("{php echo url('utility/sms')}", {'verify':'smsCode', 'username':username, 'password':password}, function(data){
          var data = JSON.parse(data);
          if(data.status == 1)
          {
              settime(60);
          }
          else
          {
              util.message(data.message, '', 'error');
          }
      });
      return false;
  }*/

  //倒计时
  function settime(second) {
      var smscode = document.getElementById('smscode');
      if (second == 0) {
          smscode.removeAttribute("disabled");
          smscode.textContent = "发送验证码";
      } else {
          smscode.setAttribute("disabled", true);
          smscode.textContent = "重新发送(" + second + ")";
          second--;
          setTimeout(function() {
              settime(second)
          },1000)
      }
  }
</script>
</body>
</html>
