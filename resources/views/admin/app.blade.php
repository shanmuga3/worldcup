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
  <body class="hold-transition sidebar-mini layout-fixed">
    <div id="app" ng-app="App" ng-controller="myApp" ng-cloak>
    <nav class="main-header navbar navbar-expand navbar-light">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar-full" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a href="{{ route('admin.logout') }}" class="nav-link"> Log out </a>
          </li>
        </ul>
      </nav>

      @include('admin.common.sidebar')

      @yield('content')

      <footer class="main-footer">
        <strong>Copyright &copy; {{ global_settings('starting_year') }} <a href="{{ global_settings('copyright_link') }}"> {{ global_settings('copyright_text') }} </a>.</strong>
      </footer>

      <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  {!! Form::open(['url' => '#', 'class' => 'form-horizontal','id'=>'confirmDeleteForm','method' => "DELETE"]) !!}
                  <div class="modal-header">
                      <h5 class="modal-title fw-bold"> @lang('admin_messages.errors.confirm_delete') </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      </button>
                  </div>
                  <div class="modal-body">
                      <p> @lang('admin_messages.errors.this_process_is_irreverible') </p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-link" data-bs-dismiss="modal">
                      @lang('admin_messages.common.cancel')
                      </button>
                      <button type="submit" class="btn btn-danger">
                      @lang('admin_messages.common.proceed')
                      </button>
                  </div>
                  {!! Form::close() !!}
              </div>
          </div>
      </div>
      <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('admin_assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
      <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('admin_assets/plugins/angularjs/angular.min.js') }}"></script>
      <script src="{{ asset('admin_assets/plugins/angularjs/angular-sanitize.min.js') }}"></script>
      <script src="{{ asset('admin_assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
      <!-- SummerNote Editor -->
      <script src="{{ asset('admin_assets/plugins/summernote/summernote-bs5.min.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
      <script src="{{ asset('admin_assets/js/adminlte.js') }}"></script>
      
      <script type="text/javascript">
        const app = angular.module('App', ['ngSanitize']);
        const APP_URL = {!! json_encode(url('/')) !!};
        const ADMIN_URL = {!! json_encode(route('admin.dashboard')) !!};
        const SITE_NAME = '{!! $site_name !!}';
        const userCurrency = '{!! session("currency") !!}';
        const userLanguage = '{!! session("language") !!}';
        const flatpickrFormat = "Y-m-d";
        const currentRouteName = "{!! Route::currentRouteName() !!}";

        function flashMessage(content, state = 'success') {
            content.icon = 'fa fa-bell';

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
        }
      </script>

      <script src="{{ asset('admin_assets/js/main.js?v='.$version) }}"></script>
      <script src="{{ asset('admin_assets/js/common.js?v='.$version) }}"></script>

      @if(Session::has('message'))
      <script type="text/javascript">
      document.addEventListener('DOMContentLoaded',function() {
        var content = {};
        content.title = "{!! Session::get('title') !!}";
        content.message = "{!! Session::get('message') !!}";;
        state = "{!! Session::get('state') !!}";
        flashMessage(content,state);
      });
      </script>
      @endif
      @stack('scripts')
    </div>
    </body>
  </html>