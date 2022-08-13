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
        {!! Html::style('css/app.css?v='.$version) !!}
        {!! global_settings('head_code') !!}
    </head>
    <body>
        <div id="app" ng-app="App" ng-controller="myApp" ng-cloak>
            <header id="header" class="header d-flex align-items-center bg-primary">
                <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
                    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                        <img src="{{ $site_logo }}" alt="{{ $site_name }}">
                        <h1 class="d-none">{{ $site_name }}</h1>
                    </a>
                    <nav id="navbar" class="navbar">
                        <ul>
                            @guest
                            <li><a href="{{ route('home') }}"> @lang('messages.home') </a></li>
                            <li><a href="{{ route('login') }}"> @lang('messages.sign_in') </a></li>
                            <li><a href="{{ route('register') }}"> @lang('messages.register') </a></li>
                            @else
                            <li><a href="{{ route('dashboard') }}"> @lang('messages.dashboard') </a></li>
                            <li><a href="{{ route('previous_guesses') }}"> @lang('messages.previous_guess') </a></li>
                            <li><a href="http://www.fifa.com/worldcup/teams" target="_blank"> @lang('messages.teams') </a></li>
                            <li><a href="http://www.fifa.com/worldcup/groups" target="_blank"> @lang('messages.groups') </a></li>
                            @endif
                            <li><a href="#"> @lang('messages.about') </a></li>
                            <li><a href="#"> @lang('messages.contact') </a></li>
                            @auth
                            <li><a href="{{ route('logout') }}"> @lang('messages.logout') </a></li>
                            @endauth
                        </ul>
                    </nav>
                    <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
                    <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
                </div>
            </header>
            
            @yield('main')
            <footer id="footer" class="footer">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-md-4 footer-links">
                            <h4> {{ $site_name }} </h4>
                            <div class="d-flex align-items-bottom">
                                <div class="img">
                                    <img src="http://worldcup.indomie.com.sa/images/sport_ball.jpg" class="img" style="height: 50px;">
                                </div>
                                <div class="info {{ isRtl() ? 'me-3' : 'ms-3' }}">
                                    <a href="{{ global_settings('copyright_link') }}" class="text-white"> {{ global_settings('copyright_link') }} </a>
                                    <h5> {{ global_settings('copyright_text') }} </h5>
                                </div>
                            </div>
                            <div class="mt-3 w-md-50">
                                {!! Form::select('language',$translatable_languages, session('language'), ['id' => 'user-language','class' => 'form-select','ng-model' => 'userLanguage','ng-change' => "updateUserDefault('language')"]) !!}
                            </div>
                        </div>
                        <div class="offset-md-4 col-md-4 footer-social-link">
                            <div class="social-links d-flex mt-4">
                                @foreach(resolve("SocialMediaLink")->where('value','!=','') as $media)
                                <a href="{{ $media->value }}" class="{{ $media->name }}">
                                    <img src="{{ asset('images/email/logo_'.$media->name.'.png') }}" alt="{{ ucfirst($media->name) }}" height="40" width="40">
                                </a>
                                @endforeach
                            </div>
                            <div class="static-links d-flex mt-4">
                                @foreach(resolve("StaticPage")->where('in_footer','1') as $page)
                                    <a href="{{ $page->url }}" class="text-white me-3"> {{ $page->name }} </a>
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
                    'get_matches' => route('get_matches'),
                    'predict_match' => route('predict_match'),
                ]);
            !!}
        </script>
        
        <!-- Include JS files -->
        {!! Html::script('js/app.js?v='.$version) !!}
        {!! Html::script('js/common.js?v='.$version) !!}
        
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