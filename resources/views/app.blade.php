<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="resources/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="resources/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="resources/favicon/favicon-16x16.png">
        <link rel="mask-icon" href="resources/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <title> {{ $title ?? getMetaData('title') }} </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="keywords" content="{{ getMetaData('keywords') }}">
        <meta name="description" content="{{ getMetaData('description') }}">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="{!! global_settings('font_script_url') !!}" rel="stylesheet">

        <style type="text/css">
            :root {
                --font-family: {!! global_settings('font_family') !!};
            }
        </style>
        <!-- Include App Style Sheet -->
        {!! Html::style('css/app.css?v='.$version) !!}

        {!! global_settings('head_code') !!}
    </head>
    <body>
        <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ $site_name }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        {{ __('Logout') }}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('main')
        </main>
    </div>

        <script type="text/javascript">
            const APP_URL = {!! json_encode(url('/')) !!};
            const SITE_NAME = '{!! $site_name !!}';
            const USER_ID = '{!! Auth::check() ? Auth::id() : 0 !!}';
            const routeList = {!!
                json_encode([
                    'login' => route('login'),
                ]);
            !!}
        </script>

        <script src="vendors/jquery/jquery-3.6.0.min.js"></script>
        <script src="vendors/popper/popper.min.js"></script>
        <script src="vendors/bootstrap/bootstrap.min.js"></script>

        <script src="vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
        <script src="vendors/masonry/masonry.pkgd.min.js"></script>

        <script src="vendors/fabric-js/fabric.js"></script>

        <script src="vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
        <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>

        <script src="vendors/fontfaceobserver/fontfaceobserver.standalone.js"></script>

        <script src="js/initialization.js"></script>
        <script src="js/helpers.js"></script>
        @if(in_array(Route::currentRouteName(),['home','dashboard']))
        <script src="js/load-images.js"></script>
        @endif
        <script src="js/choice-image.js"></script>
        <script src="js/handlers.js"></script>
        <script src="js/common.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
