<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title', 'JetOnSet | admin')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- include css files --}}
        @include('admin.includes.css')

        {{-- include javascript files --}}
        @include('admin.includes.js')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
        @auth
            <!-- Navbar -->
            @include('admin.includes.nav')
            <!-- /.navbar -->

            {{-- include main sidebar container --}}
            @include('admin.includes.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header and breadcrumb -->
                @include('admin.partials.breadcrumb')
                <!-- /.content-header and breadcrumb -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            {{-- include footer --}}
            {{-- @include('admin.includes.footer') --}}

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
            @else
            <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        {{-- @yield('content') --}}
                        @include('admin.login')
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            @endauth

        </div>
        <!-- ./wrapper -->

        {{-- include javascript files --}}
        {{-- @include('admin.includes.js') --}}
    </body>
</html>
