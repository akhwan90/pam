<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('asset/') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('asset/') }}/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="sidebar-brand-text mx-3">LCLHST <sup>8000</sup></div>
                {{-- <div class="sidebar-brand-text mx-3">E-PAK <sup>Prakom</sup></div> --}}
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item @if($menuAktif=="dashboard") active @endif">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if (Auth::user()->level == "admin")
                <div class="sidebar-heading">
                    Menu Admin
                </div>
                <li class="nav-item @if($menuAktif=="user") active @endif">
                    <a class="nav-link" href="{{ url('/admin/user') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item @if($menuAktif=="pegawai") active @endif">
                    <a class="nav-link" href="{{ url('/admin/pegawai') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Pegawai</span>
                    </a>
                </li>
                <li class="nav-item @if($menuAktif=="pelanggan") active @endif">
                    <a class="nav-link" href="{{ url('/admin/pelanggan') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>
                <li class="nav-item @if($menuAktif=="golonganTarif") active @endif">
                    <a class="nav-link" href="{{ url('/admin/golonganTarif') }}">
                        <i class="fas fa-fw fa-tags"></i>
                        <span>Gol. Tarif</span>
                    </a>
                </li>
                <li class="nav-item @if($menuAktif=="pegawaiBayar") active @endif">
                    <a class="nav-link" href="{{ url('/admin/pembayaran') }}">
                        <i class="fas fa-fw fa-money-bill"></i>
                        <span>Terima Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item @if($menuAktif=="setting") active @endif">
                    <a class="nav-link" href="{{ url('/admin/setting') }}">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Setting</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->level == "pencatat_meter")
                <div class="sidebar-heading">
                    Menu Pencatat Meter
                </div>
                <li class="nav-item @if($menuAktif=="catatMeter") active @endif">
                    <a class="nav-link" href="{{ url('/pencatatMeter/catatMeterQr') }}">
                        <i class="fas fa-fw fa-qrcode"></i>
                        <span>Catat Dengan QR</span>
                    </a>
                </li>
                <li class="nav-item @if($menuAktif=="catatMeter") active @endif">
                    <a class="nav-link" href="{{ url('/pencatatMeter/catatMeter') }}">
                        <i class="fas fa-fw fa-edit"></i>
                        <span>Catat Meter</span>
                    </a>
                </li>
                <li class="nav-item @if($menuAktif=="pencatatMeterBayar") active @endif">
                    <a class="nav-link" href="{{ url('/pencatatMeter/pembayaran') }}">
                        <i class="fas fa-fw fa-money-bill"></i>
                        <span>Terima Pembayaran</span>
                    </a>
                </li>
            @endif




        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fas fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }} <span class="text-info font-weight-bold">({{ Auth::user()->level }})</span></span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('asset/') }}/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url('resetPassword') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Reset Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Aplikasi E-PAM &copy; {{ date('Y') }}</span>
                        {{-- <span>Aplikasi E-PAK &copy; Nama Instansi</span> --}}
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('asset/') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('asset/') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('asset/') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('asset/') }}/js/sb-admin-2.js"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('asset/') }}/vendor/chart.js/Chart.min.js"></script>

    @yield('script')

</body>

</html>