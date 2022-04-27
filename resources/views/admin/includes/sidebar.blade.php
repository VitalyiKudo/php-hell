<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('/images/svg/logo_white.svg') }}" alt="Admin JetOnSet" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dashboard/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin Test</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('manage') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ __('Dashboard') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ Request::is('manage/orders*') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-info"></i>
                        <p>
                            {{ __('Orders') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.searches.index') }}" class="nav-link {{ Request::is('manage/searches*') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-search"></i>
                        <p>
                            {{ __('Searches') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ Request::is('manage/administrators*') || Request::is('manage/users*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('manage/administrators*') || Request::is('manage/users*') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            {{ __('Users') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.administrators.index') }}" class="nav-link {{ Request::is('manage/administrators*') ? 'active' : '' }}" style="color: indianred">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Administrators') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('manage/users*') ? 'active' : '' }}" style="color: indianred">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Users') }}
                                </p>
                            </a>
                        </li>
                    </ul>
                <li class="nav-item">
                    <a href="{{ route('admin.airports.index') }}" class="nav-link {{ Request::is('manage/airports*') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-plane-departure"></i>
                        <p>
                            {{ __('Airports') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.airlines.index') }}" class="nav-link {{ Request::is('manage/airlines*') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-plane"></i>
                        <p>
                            {{ __('Fleet') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.operators.index') }}" class="nav-link {{ Request::is('manage/operators*') ? 'active' : '' }}" style="color: green">
                        <i class="nav-icon fas fa-map-marker"></i>
                        <p>
                            {{ __('Operators') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pricing.index') }}" class="nav-link {{ Request::is('manage/pricing*') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            {{ __('Pricing') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.fees.index') }}" class="nav-link {{ Request::is('manage/fees*') ? 'active' : '' }}" style="color: indianred">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            {{ __('Additional Fees') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.emptyLegs.index') }}" class="nav-link {{ Request::is('manage/emptyLegs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fire"></i>
                        <p>
                            {{ __('Empty Legs') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.airportAreas.index') }}" class="nav-link {{ Request::is('manage/airportAreas*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            {{ __('Airport Areas') }}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
