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
            <!-- ======= Header ======= -->
            <section id="topbar" class="topbar d-flex align-items-center">
                <div class="container d-flex justify-content-center justify-content-md-between">
                    <div class="contact-info d-flex align-items-center">
                        <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:{{ global_settings('support_email') }}" class="me-2"> {{ global_settings('support_email') }} </a></i>
                        <i class="bi bi-phone d-flex align-items-center ms-4"><a href="tel:{{ global_settings('support_number') }}" class="me-2"> {{ global_settings('support_number') }} </a></i>
                    </div>
                    <div class="social-links d-none d-md-flex align-items-center">
                        @foreach(resolve("SocialMediaLink")->where('value','!=','') as $link)
                        <a href="{{ $link->value }}" class="{{ $link->name }}"><i class="bi bi-{{ $link->name }}"></i></a>
                        @endforeach
                    </div>
                </div>
                </section>
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
                                <li><a href="{{ route('login') }}"> @lang('messages.login') </a></li>
                                <li><a href="{{ route('register') }}"> @lang('messages.register') </a></li>
                                @else
                                <li><a href="{{ route('dashboard') }}"> @lang('messages.dashboard') </a></li>
                                <li><a href="#"> @lang('messages.previous_guess') </a></li>
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
                      <div class="row gy-4">
                        <div class="col-lg-5 col-md-12 footer-info">
                          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                            <span> {{ $site_name }} </span>
                          </a>
                          <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
                          <div class="social-links d-flex mt-4">
                            @foreach(resolve("SocialMediaLink")->where('value','!=','') as $link)
                                <a href="{{ $link->value }}" class="{{ $link->name }}"><i class="bi bi-{{ $link->name }}"></i></a>
                            @endforeach
                          </div>
                        </div>

                        <div class="col-lg-2 col-6 footer-links">
                          {!! Form::select('language',['en' => 'English','ar' => 'عربي'], session('language'), ['id' => 'user-language','class' => 'form-select','ng-model' => 'userLanguage','ng-change' => "updateUserDefault('language')"]) !!}
                        </div>

                        <div class="col-lg-2 col-6 footer-links">
                          <h4> {{ $site_name }} </h4>
                          <ul>
                            <li><a href="#">Terms of service</a></li>
                            <li><a href="#">Privacy policy</a></li>
                          </ul>
                        </div>

                        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                          <h4> @lang('messages.contact_us') </h4>
                          <p>
                            <strong class="me-2">@lang('messages.phone'):</strong> {{ global_settings('support_number') }} <br>
                            <strong class="me-2">@lang('messages.email'):</strong> {{ global_settings('support_email') }} <br>
                          </p>
                        </div>
                      </div>
                    </div>

                    <div class="container mt-4">
                      <div class="copyright">
                        &copy; <a href="{{ global_settings('copyright_link') }}" class="text-white"> {{ global_settings('copyright_text') }} </a>
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
                const routeList = {!!
                json_encode([
                    'login' => route('login'),
                    'update_user_default' => route('update_user_default'),
                ]);
            !!}
            </script>
            
            <!-- Include JS files -->
            {!! Html::script('js/app.js?v='.$version) !!}
            {!! Html::script('js/common.js?v='.$version) !!}
        </body>
    </html>