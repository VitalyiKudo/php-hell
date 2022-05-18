<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0"-->
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta -->
    @yield('meta')
    <link rel="apple-touch-icon" sizes="57x57" href="/images/meta/apple-icon-57x57.webp">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/meta/apple-icon-60x60.webp">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/meta/apple-icon-72x72.webp">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/meta/apple-icon-76x76.webp">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/meta/apple-icon-114x114.webp">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/meta/apple-icon-120x120.webp">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/meta/apple-icon-144x144.webp">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/meta/apple-icon-152x152.webp">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/meta/apple-icon-180x180.webp">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/meta/android-icon-192x192.webp">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/meta/favicon-32x32.webp">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/meta/favicon-96x96.webp">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/meta/favicon-16x16.webp">
    <link rel="manifest" href="/images/meta/manifest.json">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/meta/ms-icon-144x144.webp">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    <!-- script src="https://kit.fontawesome.com/cb8c197ec4.js"></script -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-209752116-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-209752116-1');
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700&display=swap" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css.map" type="text/css">

    <!-- Styles -->
    {{--<link href="{{ mix('css/app.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--<link href="{{-- asset('css/custom.css') --}}" rel="stylesheet">-->

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTI9h361xswcSvVdM2kDtpiwcslXmjUYU&callback=initMap&libraries=&v=weekly" defer></script>-->

    <!--<link href="/css/app_1.css" rel="stylesheet">-->

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel custom-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!--{{ config('app.name', 'Laravel') }}-->
                    @if(View::hasSection('book_page'))
                        <img src="{{ asset('images/svg/logo_white.svg') }}" loading="lazy" class="logo-img" alt="JetOnset">
                    @else
                        <img src="{{ asset('images/svg/logo.svg') }}" loading="lazy" class="logo-img" alt="JetOnset">
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbar-style @yield('book_page')" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        @guest()
                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">{{ __('Book a flight') }}</a>
                            </li>

                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('empty-leg') ? 'active' : '' }}" href="{{ url('empty-leg') }}">{{ __('Empty Legs') }}</a>
                            </li>

                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ url('services') }}">{{ __('Services') }}</a>
                            </li>

                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('aircraft') ? 'active' : '' }}" href="{{ url('aircraft') }}">{{ __('Aircraft') }}</a>
                            </li>
                            <!--
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('mobile-app') ? 'active' : '' }}" href="/mobile-app">{{ __('Mobile App') }}</a>
                            </li>
                            -->
                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ url('about') }}">{{ __('About') }}</a>
                            </li>
                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('blog') ? 'active' : '' }}" href="https://blog.jetonset.com/">{{ __('Blog') }}</a>
                            </li>
                        @else
                            <li class="nav-item item-position auth-navbar">
                                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">{{ __('Book a flight') }}</a>
                            </li>

                            <li class="nav-item item-position auth-navbar">
                                <a class="nav-link {{ Request::is('empty-leg') ? 'active' : '' }}" href="{{ url('empty-leg') }}">{{ __('Empty Legs') }}</a>
                            </li>

                            <li class="nav-item item-position auth-navbar">
                                <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ route('client.profile') }}">{{ __('Profile') }}</a>
                            </li>

                            <li class="nav-item item-position auth-navbar">
                                <a class="nav-link {{ Request::is('requests') ? 'active' : '' }}" href="{{ route('client.requests.index') }}">{{ __('Requests') }}</a>
                            </li>

                            <li class="nav-item item-position auth-navbar">
                                <a class="nav-link {{ Request::is('orders') ? 'active' : '' }}" href="{{ route('client.orders.index') }}">{{ __('Orders') }}</a>
                            </li>

                            <li class="nav-item item-position auth-navbar">
                                <a class="nav-link {{ Request::is('support') ? 'active' : '' }}" href="{{ url('support') }}">{{ __('Support') }}</a>
                            </li>

                        @endguest

                        @guest()

                                <li class="nav-item item-position">
                                    <a class="nav-link {{ Request::is('support') ? 'active' : '' }}" href="{{ url('support') }}">{{ __('Support') }}</a>
                                </li>

                                <li class="nav-item item-position border-lg-right margin-lg-left ">
                                <a class="nav-link nav-item-custom-color" href="{{ route('client.register') }}">

                                    <img src="/images/sg.svg" loading="lazy" class="icon-img mr-1 sg-icon" alt="..."></span>

                                    {{ __('Sign Up') }}

                                </a>

                            </li>
                            <li class="nav-item">
                                <svg width="2px" height="100%" preserveAspectRatio="none" viewBox="0 0 1 1" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <line opacity="0.1" x1="0.5" x2="0.5" y2="68" stroke="#2B4060"/>
                                </svg>
                            </li>
                            <li class="nav-item item-position">

                                <a class="nav-link" href="{{ route('client.login') }}">

                                    <img src="/images/key.svg" loading="lazy" class="icon-img mr-1 sg-icon" alt="...">
                                    {{ __('Log In') }}</a>
                            </li>
                        @else
                            <li class="nav-item item-position auth-navbar">
                                <a class="nav-link" href="{{ route('client.logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('client.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-lg-2 mb-3 mb-lg-0">
                        <h5 class="column-title text-uppercase">Navigation</h5>
                        <ul class="footer-list list-unstyled">
                            <li><a href="{{ url('about') }}">About Us</a></li>
                            <li><a href="{{ url('/#how-it-works') }}">How It Works</a></li>
                            <li><a href="{{ url('services') }}">Services</a></li>
                            <li><a href="{{ url('support/#contact') }}">Contact</a></li>
                            <li><a href="{{ url('support') }}">Support</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-lg-2 mb-3 mb-lg-0">
                        <h5 class="column-title text-uppercase">Useful</h5>
                        <ul class="footer-list list-unstyled">
                            <li><a href="#">Destinations & All Routes</a></li>
                            <li><a href="{{ url('support/#faqs') }}">FAQs</a></li>
                            <li><a href="{{ url('about/#reviews') }}">Reviews</a></li>
                            <li><a href="https://blog.jetonset.com/" target="_blank">Blog</a></li>
                            <li><a href="{{ url('aircraft') }}">Aircraft</a></li>
                        </ul>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0 text-justify">
                        <h5 class="column-title text-uppercase">Contact</h5>
                        <p class="mb-3">If you have any questions or concerns, don't hesitate to reach out to us today! We'are happy to help!</p>
                        <a href="mailto:info@jetonset.com"><p class="mb-3">
                                <i class="fas fa-envelope mr-3"><img loading="lazy" src="/images/jetonset-envelope.svg" alt="" width="12" height="12"></i>
                                info@jetonset.com</p></a>
                        <p class="mb-3">JetOnset does not own or operate aircraft. All flights are operated by FAA Certified Part 135 air carriers. Carriers providing service for JetOnset clients must meet both FAA requirements and additional JetOnset standards.</p>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-5">
                        <h5 class="column-title text-uppercase">Join our newsletter</h5>
                        <p class="mb-3">Receive the latest reviews, offers and more</p>
                        <subscribe></subscribe>


                            <div class="logo-app mt-5">
                                <div class="logo-ios">
                                    <img src="/images/iOS-logo.webp" loading="lazy" alt="...">
                                    <!--p class="download-text">Download Now for iOS</p-->
                                </div>
                                <div class="logo-android">
                                    <img src="/images/Android-logo.webp" loading="lazy" alt="...">
                                    <!--p class="download-text">Download Now for Android</p-->
                                </div>
                            </div>


                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-12 col-lg-4 order-3 mb-lg-3">
                        <p class="footer-copyright-text mb-0">Copyright © 2022 JetOnset Co.. All rights reserved.</p>
                    </div>

                    <div class="col-12 col-lg-4 order-1 mb-3">
                        <div class="row mb-0 justify-content-center">
                            <div class="col-auto">
                                <a href="https://www.facebook.com/JetOnset-107938548410959" target="_blank"><img src="/images/facebook-icon.webp" loading="lazy" class="social-ico" alt="..."></a>
                            </div>
                            <div class="col-auto">
                                <a href="https://www.instagram.com/jetonset/" target="_blank"><img src="/images/instagram-icon.webp" loading="lazy" class="social-ico" alt="..."></a>
                            </div>
                            <div class="col-auto">
                                <a href="https://twitter.com/jetonset1" target="_blank"><img src="/images/twitter-icon.webp" loading="lazy" class="social-ico" alt="..."></a>
                            </div>
                            <div class="col-auto">
                                <a href="https://www.pinterest.com/4jetonset/" target="_blank"><img src="/images/pinest-icon.webp" loading="lazy" class="social-ico" alt="..."></a>
                            </div>
                            <div class="col-auto">
                                <a href="https://jetonset.tumblr.com/" target="_blank"><img src="/images/tumblr-icon.webp" loading="lazy" class="social-ico" alt="..."></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 order-2 mb-3">
                        <div class="row privacy-terms mb-0">
                            <a href="/privacy-policy" class="footer-privacy-text mb-0">Privacy Policy</a>
                            <a href="/terms-conditions" class="footer-privacy-text mb-0">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<script src="{{ mix('js/app.min.js') }}"></script>--}}
    <script src="{{ asset('js/app.js') }}"></script>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js.map" type="application/octet-stream"></script>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    @stack('scripts')
</body>
</html>
