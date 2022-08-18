<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('dashboard/favicon-16x16.webp')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome-free/css/all.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dashboard/dist/css/adminlte.css') }}">
<!-- Custom style -->
<link rel="stylesheet" href="{{ asset('dashboard/dist/css/custom.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/summernote/summernote-bs4.css') }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- dataTables -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link href="{{ (strtoupper(getenv('APP_ENV')) === 'LOCAL') ? asset('css/app.css') : mix('css/app.min.css') }}" rel="stylesheet">
@if(app()->getLocale() == "rtl")
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap_ltr.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/custom_ltr.css') }}">
@endif

