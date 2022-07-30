<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> {{ $site_name }} - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ $favicon }}" type="image/png" sizes="14x26">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    {!! Html::style('admin_assets/css/admin_app.css?v='.$version) !!}
  </head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ route('admin.dashboard') }}" class="h1"> <b> {{ $site_name }} </b> </a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      {!! Form::open(['url' => route('admin.authenticate')]) !!}
        <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="User Name">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-text cursor-pointer show-password">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember_me" value="1" id="rememberMe" checked>
            <label class="form-check-label" for="rememberMe">
                Remember Me
            </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin_assets/js/adminlte.min.js') }}"></script>
<!-- bootstrap-notify -->
<script src="{{ asset('admin_assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<!-- Jquery Backstretch -->
<script src="{{ asset('admin_assets/plugins/backstretch/jquery.backstretch.min.js') }}"></script>
	@if(Session::has('message'))
	    <script type="text/javascript">
	        document.addEventListener('DOMContentLoaded',function() {
	            var content = {};
	            content.icon = 'fas fa-bell';
	            content.title = "{!! session('title') !!}";
	            content.message = "{!! session('message') !!}";
	            state = "{!! session('state') !!}";
	            $.notify(content, {
                    template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert"><button type="button" aria-hidden="true" class="btn-close float-end" data-notify="dismiss"></button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>',
	                type: state,
	                placement: {
	                    from: "top",
	                    align: "right"
	                },
	                z_index: 1035,
	                delay: 5000,
	            });
	        });
	    </script>
	@endif
    <script type="text/javascript">
        // Show Password
        function showPassword(button) {
            var inputPassword = $(button).parent().find('input');
            if (inputPassword.attr('type') === "password") {
                inputPassword.attr('type', 'text');
            } else {
                inputPassword.attr('type','password');
            }
        }

        $('.show-password').on('click', function(){
            showPassword(this);
        });

        $(document).ready(function() {
            var sliders = {!! $sliders !!};
            var slider_options = {duration: 3000, fade: 1000};
            $.backstretch(sliders, slider_options);
        });
    </script>
</body>
</html>
