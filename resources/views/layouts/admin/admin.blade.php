<!DOCTYPE html>
<html lang="en">
<head>
    <!-- PRECONNECT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="preconnect" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://www.w3.org">
    <link rel="preconnect" href="https://www.w3.org">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="icon" type="image/png" href="{{  url('') }}/assets/img/logo.png">

    @yield('title')

    <!-- Custom fonts for this template -->
    <link href="{{  url('') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="https://use.fontawesome.com/releases/v6.4.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{  url('') }}/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{  url('') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Source Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <!-- Source Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Source DataTables.net -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #000;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dash') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{  url('') }}/assets/img/logo.png" alt="" height="50">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dash') }}">
                    <i class="fas fa-fw fa-chart-simple"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Nav Item - Tentang -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tentang.data') }}">
                    <i class="fas fa-fw fa-house"></i>
                    <span>Tentang</span></a>
            </li>

            <!-- Nav Item - Infografis -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('infografis.data') }}">
                    <i class="fas fa-fw fa-image"></i>
                    <span>Infografis</span></a>
            </li>

            <!-- Nav Item - Edukasi -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('edukasi.data') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Edukasi</span></a>
            </li>

            <!-- Nav Item - Lokasi -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('lokasi.data') }}">
                    <i class="fas fa-fw fa-location-dot"></i>
                    <span>Lokasi</span></a>
            </li>

            <!-- Nav Item - Kontak -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('kontak.data') }}">
                    <i class="fas fa-fw fa-address-card"></i>
                    <span>Kontak</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            {{-- Filter Khusus Super Admin --}}
            @if (Auth::user()->level == 'Super Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('akun.data') }}">
                    <i class="fa-solid fa-fw fa-user"></i>
                    <span>Akun Admin</span>
                </a>
            </li>
            @endif
            {{-- End Filter Khusus Super Admin --}}


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

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
                        <i class="fa fa-bars" style="color:#000;"></i>
                    </button>

                    <!-- Running Text -->
                    <marquee behavior="" direction="">Selamat Datang di Halaman Administrasi Situs <b>Smart Flood Early Detection</b></marquee>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600">
                                    {{ Auth::user()->nama }}
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="{{  url('') }}/img/user.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('prof.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Edit Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    @yield('pageHeading')

                    <hr>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            @yield('page')
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <?= date("Y")?> by Smart Flood Early Detection</span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" Untuk Keluar dari Akun.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-admin').submit();">Logout</a>
                    <form id="logout-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{  url('') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{  url('') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{  url('') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{  url('') }}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{  url('') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{  url('') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{  url('') }}/js/demo/datatables-demo.js"></script>

    <!-- Template Main JS File -->
    <script src="{{  url('') }}/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

</body>
</html>
