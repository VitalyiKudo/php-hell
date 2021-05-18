@extends('client.layouts.app')

@section('content')
<div class="container header-page-image"></div>

<div class="container profile-page">
    <div class="row">
        <div class="col-md-4">
            <h2 class="right-profile-title mb-4">@yield('profile-title')</h2>
            
            <ul class="nav nav-pills flex-column right-profile-nav">
                <li class="nav-item">
                    <a class="nav-link{{ Request::is('profile') ? ' active' : '' }}" href="{{ route('client.profile') }}">Personal information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ Request::is('profile/account*') ? ' active' : '' }}" href="{{ route('client.profile.account.index') }}">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ Request::is('profile/payment*') ? ' active' : '' }}" href="{{ route('client.profile.payment.index') }}">Payment method</a>
                </li>
                {{--
                <li class="nav-item">
                    <a class="nav-link{{ Request::is('profile/companions*') ? ' active' : '' }}" href="{{ route('client.profile.companions.list') }}">Companions</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link{{ Request::is('profile/quote*') ? ' active' : '' }} nav-link-last" href="{{ route('client.profile.quote.index') }}">Quotes</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link{{ Request::is('profile/orders') ? ' active' : '' }}" href="{{ route('client.profile.orders.index') }}">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Searches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Payment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ Request::is('profile/settings') ? ' active' : '' }}" href="{{ route('client.profile.settings.index') }}">Settings</a>
                </li> 
                --}}
            </ul>
        </div>

        <div class="col-md-7 offset-md-1 left-profile">
            <h2 class="mb-5">Welcome <span class="text-primary">{{ Auth::user()->first_name }}</span></h2>

            @if (session('status'))
                <div class="alert alert-{{ session('status-type', 'success') }}" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @section('body')
                This is profile dashboard.
            @show
        </div>
    </div>
</div>
@endsection
