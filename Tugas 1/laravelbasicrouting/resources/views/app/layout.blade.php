<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PBKK (B)</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css?v=3.2.0') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item p-3">
                    <h3>TUGAS 1 - PBKK B</h3>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link">
                <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PBKK (B)</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Pertemuan 1
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('pertemuan1.ganjilgenap') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ganjil Genap</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pertemuan1.fibonacci') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Fibonacci</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pertemuan1.prima') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bilangan Prima</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Pertemuan 2
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Pertemuan 3
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            </ul>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <div class="content-header">
                @yield('header')
            </div>

            <section class="content">
                @yield('content')
                {!! @$content !!}
            </section>

        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>


    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/adminlte.js?v=3.2.0') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/pages/dashboard.js') }}"></script>

    <script>
        $(document).ready(function() {
            var url = window.location;
            var filter = $('ul.nav a').filter(function() {
                return this.href == url;
            });
            filter.addClass('active');
            filter.parents().each(function() {
                if (this.className == 'nav-item') {
                    this.className = 'nav-item menu-open';
                }
            });
        });
    </script>
</body>

</html>