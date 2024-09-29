<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Apotek</title>
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link href="{{ asset('vendors/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('skydash/css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('skydash/images/favicon.png') }}" />

    <style>
        .fixed-end {
            margin-left: 240px;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo text-center" href="{{ url('/') }}"> Laravel Apotek</a>
                <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}"> LA</a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end sticky-top">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle fs-4" href="#" data-toggle="dropdown" id="profileDropdown">
                            <div class="d-flex align-items-center">
                                <span class="profile-text">
                                    @auth
                                    {{ Auth::user()->name }}
                                    @else
                                    Guest
                                    @endauth
                                </span>
                                <i class="fas fa-user-circle fs-3 ms-3"></i>
                            </div>
                        </a>

                        @auth
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                        </div>
                        @else
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{ route('login') }}">
                                <i class="ti-shift-left text-primary"></i>
                                Login
                            </a>
                            <a class="dropdown-item" href="{{ route('register') }}">
                                <i class="ti-agenda text-primary"></i>
                                Register
                            </a>
                        </div>
                        @endauth
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">Warna Sidebar</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Terang
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Gelap
                    </div>
                    <p class="settings-heading mt-2">Warna Header</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>

            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item @if(Route::is('home')) active @endif">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="mdi mdi-home menu-icon"></i>
                            <span class="menu-title">Home</span>
                        </a>
                    </li>
                    @guest
                    <li class="nav-item @if(Route::is('obat.*') && !Route::is('kategori_obat.*')) active @endif">
                        <a class="nav-link" href="{{ url('obat') }}">
                            <i class="mdi mdi-pill menu-icon"></i>
                            <span class="menu-title">Obat</span>
                        </a>
                    </li>
                    @else
                    @can('manage-obat')
                    <li class="nav-item @if(Route::is('kategori.*')) active @endif">
                        <a class="nav-link" href="{{ url('kategori') }}">
                            <i class="mdi mdi-package menu-icon"></i>
                            <span class="menu-title">Kategori Obat</span>
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item @if(Route::is('obat.*') && !Route::is('kategori_obat.*')) active @endif">
                        <a class="nav-link" href="{{ url('obat') }}">
                            <i class="mdi mdi-pill menu-icon"></i>
                            <span class="menu-title">Obat</span>
                        </a>
                    </li>
                    @can('manage-stok')
                    <li class="nav-item @if(Route::is('stok.*')) active @endif">
                        <a class="nav-link" href="{{ url('stok') }}">
                            <i class="mdi mdi-package-variant menu-icon"></i>
                            <span class="menu-title">Stok Obat</span>
                        </a>
                    </li>
                    @endcan
                    @can('show-laporan')
                    <li class="nav-item @if(Route::is('laporan_stok.*')) active @endif">
                        <a class="nav-link" href="{{ url('laporan_stok') }}">
                            <i class="mdi mdi-file-document menu-icon"></i>
                            <span class="menu-title">Laporan Stok Obat</span>
                        </a>
                    </li>
                    @endcan
                    @can('manage-transaksi')
                    <li class="nav-item @if(Route::is('transaksi.*')) active @endif">
                        <a class="nav-link" href="{{ url('transaksi') }}">
                            <i class="mdi mdi-cash-multiple menu-icon"></i>
                            <span class="menu-title">Transaksi</span>
                        </a>
                    </li>
                    @endcan
                    @can('penerimaan-obat')
                    <li class="nav-item @if(Route::is('penerimaan_obat.*')) active @endif">
                        <a class="nav-link" href="{{ url('penerimaan_obat') }}">
                            <i class="mdi mdi-package-down menu-icon"></i>
                            <span class="menu-title">Penerimaan Obat</span>
                        </a>
                    </li>
                    @endcan
                    @can('show-laporan')
                    <li class="nav-item @if(Route::is('laporan_penjualan.*')) active @endif">
                        <a class="nav-link" href="{{ url('laporan_penjualan') }}">
                            <i class="mdi mdi-file-document menu-icon"></i>
                            <span class="menu-title">Laporan Penjualan</span>
                        </a>
                    </li>
                    @endcan
                    @endauth
                    <li class="nav-item @if(URL::current() == url('/api/scheme')) active @endif">
                        <a class="nav-link" href="{{ url('/api/scheme') }}">
                            <i class="mdi mdi-code-tags menu-icon"></i>
                            <span class="menu-title">API Scheme</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="main-panel">
                @hasSection('error')
                @yield('error')
                @else
                <div class="content-wrapper">

                    @yield('content')

                </div>
                @endif
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda ingin keluar ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Klik Tombol Untuk Keluar</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    @stack('modals')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('skydash/js/off-canvas.js') }}"></script>
    <script src="{{ asset('skydash/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('skydash/js/template.js') }}"></script>
    <script src="{{ asset('skydash/js/settings.js') }}"></script>
    <script src="{{ asset('skydash/js/todolist.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    <script>
        $(document).ready(function() {
            // $('#dataTable').DataTable();
            $(document).on("click", ".browse", function() {
                var file = $(this).parents().find(".file");
                file.trigger("click");
            });
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $("#file").val(fileName);

                var reader = new FileReader();
                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("preview").src = e.target.result;
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            });
        });

        function convertToRupiah(angka) {
            var rupiah = "";
            var angkarev = angka.toString().split("").reverse().join("");
            for (var i = 0; i < angkarev.length; i++)
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
            return (
                rupiah
                .split("", rupiah.length - 1)
                .reverse()
                .join("")
            );
        }
    </script>

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: `{{ session('success') }}`,
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `{{ session('error') }}`,
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    @endif

    @stack('scripts')
</body>

</html>