<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        @if(app()->getLocale() == 'ar')
            {!! Html::style('css/app.rtl.css?v='.$version) !!}
        @else
            {!! Html::style('css/app.css?v='.$version) !!}
        @endif
        {!! global_settings('head_code') !!}
    </head>
    <body>
        <div id="app" ng-app="App" ng-controller="myApp" ng-cloak>
            <header class="black-bg {{ Route::currentRouteName() == 'home' ? 'header-container' : 'normal-menu'}}">
                <nav class="px-5 container-fluid navbar navbar-expand-lg navbar-sm justify-content-between">
                    <div class="hstack gap-2">
                        <a class="navbar-brand logo" href="{{ url('/') }}">
                            <img class="header-logo" src="{{ $site_logo }}" alt="{{ $site_name }}">
                        </a>
                    </div>
                    <div class="main-menu collapse navbar-collapse flex-grow-0" id="navbarNav">
                        <ul class="nav navbar-nav align-items-center ms-auto main-menu">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center language" href="javascript:;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="globe-icon d-flex align-items-center">
                                        <i class="bi bi-globe me-2"></i>
                                        {{ session('language_name') }}
                                    </div>
                                </a>
                                <ul class="dropdown-menu overflow-auto" aria-labelledby="navbarDropdown">
                                    @foreach($translatable_languages as $key => $value)
                                    @if(session('language') != $key)
                                    <li class="dropdown-item">
                                        <a class="{{ session('language') == $key ? 'selected' : '' }}" href="#" class="dropdown-link" ng-click="userLanguage='{{ $key }}';updateUserDefault('language');"> {{ $value }} </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            @guest
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active fw-bold' : '' }}" href="{{ route('home') }}"> @lang('messages.home') </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'login' ? 'active fw-bold' : '' }}" href="{{ route('login') }}"> @lang('messages.sign_in') </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary text-white px-3 py-2" href="{{ route('register') }}"> @lang('messages.register') </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}"> @lang('messages.dashboard') </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'previous_guesses' ? 'active fw-bold' : '' }}" href="{{ route('previous_guesses') }}"> @lang('messages.previous_guess') </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'edit_profile' ? 'active fw-bold' : '' }}" href="{{ route('edit_profile') }}"> @lang('messages.edit_profile') </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.fifa.com/worldcup/teams" target="_blank"> @lang('messages.teams') </a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteName() == 'groups' ? 'active' : '' }}">
                                <a class="nav-link {{ Route::currentRouteName() == 'groups' ? 'active fw-bold' : '' }}" href="{{ route('groups') }}"> @lang('messages.groups') </a>
                            </li>
                            @endif
                            @auth
                            <li class="nav-item">
                                <a href="{{ route('logout') }}"> @lang('messages.logout') </a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                    <nav class="navbar bg-light fixed-top px-2 d-block d-lg-none">
                        <div class="container-fluid">
                            <a class="navbar-brand logo" href="{{ url('/') }}">
                                <img src="{{ $site_logo }}" alt="{{ $site_name }}">
                            </a>
                            <div class="nav-item dropdown ms-auto">
                                <a class="nav-link d-flex align-items-center language me-2" href="javascript:;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="globe-icon">
                                        <i class="bi bi-globe me-2"></i>
                                        {{ session('language_name') }}
                                    </div>
                                </a>
                                 <ul class="dropdown-menu dropdown-menu-end overflow-auto" aria-labelledby="navbarDropdown">
                                    @foreach($translatable_languages as $key => $value)
                                    @if(session('language') != $key)
                                    <li class="dropdown-item">
                                        <a class="{{ session('language') == $key ? 'selected' : '' }}" href="#" class="dropdown-link" ng-click="userLanguage='{{ $key }}';updateUserDefault('language');"> {{ $value }} </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            <button class="border-0 square p-0 rounded-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                                <div class="burgerwrap">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 {{ Auth::check() ? 'flex-column' : '' }}">
                                        @guest
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('home') }}"> @lang('messages.home') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}"> @lang('messages.sign_in') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}"> @lang('messages.register') </a>
                                        </li>
                                        @else
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('dashboard') }}"> @lang('messages.dashboard') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('previous_guesses') }}"> @lang('messages.previous_guess') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('edit_profile') }}"> @lang('messages.edit_profile') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="http://www.fifa.com/worldcup/teams" target="_blank"> @lang('messages.teams') </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="http://www.fifa.com/worldcup/groups" target="_blank"> @lang('messages.groups') </a>
                                        </li>
                                        @endif
                                        @auth
                                        <li class="nav-item">
                                            <a href="{{ route('logout') }}"> @lang('messages.logout') </a>
                                        </li>
                                        @endauth
                                    </ul>                        
                                </div>
                            </div>
                        </div>
                    </nav>
                </nav>
            </header>
            
            @yield('main')
            <footer id="footer" class="footer">
                <div class="container">
                    <div class="row justify-content-end align-items-center">
                        <div class="col-md-4 footer-links">
                            <div class="d-flex align-items-bottom">
                                <div class="img">
                                    <img src="{{ asset('images/sport_ball.png') }}" class="img" style="height: 50px;">
                                </div>
                                <div class="info ms-3">
                                    <a href="{{ global_settings('copyright_link') }}" class=""> {{ global_settings('copyright_link') }} </a>
                                    <h5> {{ global_settings('copyright_text') }} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 footer-social-link">
                            <div class="static-links d-flex mb-2 mt-2">
                                @foreach(resolve("StaticPage")->where('in_footer','1') as $page)
                                    <a href="{{ $page->url }}" class="me-3"> {{ $page->name }} </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 footer-social-link">
                            <div class="social-links d-flex mt-4">
                                @foreach(resolve("SocialMediaLink")->where('value','!=','') as $media)
                                <a href="{{ $media->value }}" class="{{ $media->name }}">
                                    <img src="{{ asset('images/social_media_icons/icon_'.$media->name.'.png') }}" class="img social-icon" data-icon="{{ $media->name }}" alt="{{ ucfirst($media->name) }}" height="30" width="30">
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script type="text/javascript">
            const APP_URL = {!! json_encode(url('/')) !!};
            const SITE_NAME = '{!! $site_name !!}';
            const USER_ID = '{!! Auth::check() ? Auth::id() : 0 !!}';
            const flatpickrFormat = "Y-m-d";
            const userLanguage = "{!! session('language') !!}";
            const currentRouteName = "{!! Route::currentRouteName() !!}";
            const routeList = {!!
                json_encode([
                    'update_user_default' => route('update_user_default'),
                    'update_favourite_team' => route('update_favourite_team'),
                    'get_matches' => route('get_matches'),
                    'predict_match' => route('predict_match'),
                    'get_previous_guesses' => route('get_previous_guesses'),
                ]);
            !!}
        </script>
        
        <!-- Include JS files -->
        {!! Html::script('js/app.js?v='.$version) !!}
        {!! Html::script('js/common.js?v='.$version) !!}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.37/moment-timezone-with-data.js"></script>
        
        @if(Session::has('message'))
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded',function() {
                let state = "{!! Session::get('state') !!}";
                let content = {
                    title : "{!! Session::get('title') !!}",
                    message : "{!! Session::get('message') !!}",
                };
                flashMessage(content,state);
            });
        </script>
        @endif

        @stack('scripts')
        {!! global_settings('foot_code') !!}
    </body>
</html>