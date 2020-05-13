<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta -->
    @yield('meta')
    <link rel="apple-touch-icon" sizes="57x57" href="/images/meta/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/meta/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/meta/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/meta/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/meta/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/meta/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/meta/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/meta/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/meta/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/meta/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/meta/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/meta/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/meta/favicon-16x16.png">
    <link rel="manifest" href="/images/meta/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/meta/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/cb8c197ec4.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700&display=swap" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css.map" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel custom-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!--{{ config('app.name', 'Laravel') }}-->
                    <img src="/images/svg/logo.svg" class="logo-img" alt="JetOnset">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbar-style" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">{{ __('Management') }}</a>
                        </li> --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item item-position">
                            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">{{ __('Book a flight') }}</a>
                        </li>

                        @guest()
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
                            <li class="nav-item ">
                                <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ route('client.profile') }}">{{ __('Profile') }}</a>
                            </li>

                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('requests') ? 'active' : '' }}" href="{{ route('client.requests.index') }}">{{ __('Requests') }}</a>
                            </li>

                            <li class="nav-item item-position">
                                <a class="nav-link {{ Request::is('orders') ? 'active' : '' }}" href="{{ route('client.orders.index') }}">{{ __('Orders') }}</a>
                            </li>
                        @endguest

                        <li class="nav-item item-position">
                            <a class="nav-link {{ Request::is('support') ? 'active' : '' }}" href="{{ url('support') }}">{{ __('Support') }}</a>
                        </li>

                        @guest()
                            <li class="nav-item item-position border-lg-right margin-lg-left ">
                                <a class="nav-link nav-item-custom-color" href="{{ route('client.register') }}">
                                
                                    <img src="/images/sg.svg" class="icon-img mr-1 sg-icon" alt="..."></span>
                                
                                    {{ __('Sign Up') }}
                                    
                                </a>
                                  
                            </li>
                            <li class="nav-item">
                                <svg width="1" height="50" viewBox="0 0 1 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <line opacity="0.1" x1="0.5" x2="0.5" y2="68" stroke="#2B4060"/>
                                </svg>
                            </li>
                            <li class="nav-item item-position">
                            
                                <a class="nav-link" href="{{ route('client.login') }}">
                                    
                                    <img src="/images/key.svg" class="icon-img mr-1 sg-icon" alt="...">
                                    {{ __('Log In') }}</a>
                            </li>
                        @else
                            <li class="nav-item item-position">
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

                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <h5 class="column-title text-uppercase">Contact</h5>
                        <p class="mb-3">If you have any questions or concerns, don't hesitate to reach out to us today! We'are happy to help!</p>
                        <a href="mailto:info@jetonset.com"><p class="mb-3"><i class="fas fa-envelope mr-3"></i>info@jetonset.com</p></a>        
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 mb-5">
                        <h5 class="column-title text-uppercase">Join our newsletter</h5>
                        <p class="mb-3">Receive the latest reviews, offers and more</p>
                        <subscribe></subscribe>
                        <div class="row">
                            <div class="col">
                                <img src="/images/iOS-logo.png" class="card-img-top" alt="...">
                            </div>
                            <div class="col">
                                <img src="/images/Android-logo.png" class="card-img-top" alt="...">
                            </div> 
                        </div>       
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-12 col-lg-4 order-3 mb-lg-3">
                        <p class="footer-copyright-text mb-0">Copyright © 2019 JetOnset Co.. All rights reserved.</p>
                    </div>

                    <div class="col-12 col-lg-4 order-1 mb-3">
                        <div class="row mb-0 justify-content-center">
                            <div class="col-auto">
                                <a href="https://www.facebook.com/jet.onset" target="_blank"><img src="/images/facebook-icon.png" class="social-ico" alt="..."></a>
                            </div>
                            <div class="col-auto">
                                <a href="https://www.instagram.com/jetonset/" target="_blank"><img src="/images/instagram-icon.png" class="social-ico" alt="..."></a>
                            </div>
                            <div class="col-auto">
                                <a href="https://twitter.com/jetonset1" target="_blank"><img src="/images/twitter-icon.png" class="social-ico" alt="..."></a>
                            </div>
                            <div class="col-auto">
                                <a href="https://www.pinterest.com/4jetonset/" target="_blank"><img src="/images/pinest-icon.png" class="social-ico" alt="..."></a>
                            </div> 
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 order-2 mb-3">
                        <div class="row privacy-terms mb-0">                       
                            <a href="#" class="footer-privacy-text mb-0">Privacy Policy</a>
                            <a href="/terms-conditions" class="footer-privacy-text mb-0">Terms & Conditions</a>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js.map"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    @stack('scripts')
</body>
</html>
