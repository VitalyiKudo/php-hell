<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!--script src="{{ mix('js/app.min.js') }}" defer></script -->
    <script src="{{ asset('admin/js/adminlte.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" type="text/javascript"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Styles -->
    <!--link type="text/css" href="{{ mix('css/admin.min.css') }}" rel="stylesheet"-->
    <link type="text/css" href="{{ asset('admin/css/AdminLTE.css') }}" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-209752116-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-209752116-1');
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth('admin')
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item {{ Request::is('manage/orders*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a>
                            </li>

                            <li class="nav-item {{ Request::is('manage/searches*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.searches.index') }}">{{ __('Searches') }}</a>
                            </li>
                            <!--
                            <li class="nav-item {{ Request::is('manage/services*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.services.index') }}">{{ __('Services') }}</a>
                            </li>
                            -->
                            <li class="nav-item {{ Request::is('manage/users*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
                            </li>

                            <li class="nav-item {{ Request::is('manage/administrators*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.administrators.index') }}">{{ __('Administrators') }}</a>
                            </li>

                            <li class="nav-item {{ Request::is('manage/airports*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.airports.index') }}">{{ __('Airports') }}</a>
                            </li>

                            <li class="nav-item {{ Request::is('manage/airlines*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.airlines.index') }}">{{ __('Fleet') }}</a>
                            </li>

                            <li class="nav-item {{ Request::is('manage/operators*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.operators.index') }}">{{ __('Operators') }}</a>
                            </li>

                            <li class="nav-item {{ Request::is('manage/pricing*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.pricing.index') }}">{{ __('Pricing') }}</a>
                            </li>

                            <li class="nav-item {{ Request::is('manage/fees*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.fees.index') }}">{{ __('Additional Fees') }}</a>
                            </li>

                        </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest('admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>