<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title }} | Group 8</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/jic/logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/sidebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Page CSS -->

    <style>
        .offcanvas-start {
            width: 260px;
        }

        .warning {
            background-color: #fff2d6;
            border: none;
            color: #c28f2c;
            text-transform: uppercase;
            font-size: 14px;
            padding: 5px;
            border-radius: 5px;
        }

        .warning:hover {
            background-color: #c28f2c;
            color: #fff2d6;
            border: none;
            transition: ease-out 0.3s;
        }

        .info {
            background-color: #d7f5fc;
            border: none;
            color: #1997b4;
            text-transform: uppercase;
            font-size: 14px;
            padding: 5px;
            border-radius: 5px;
        }

        .info:hover {
            color: #e0f7fc;
            background-color: #7fd9ed;
            border: none;
            transition: ease-out 0.3s;
        }

        .alert2 {
            position: relative;
            padding: 0.000rem 0.9375rem;
            margin-bottom: 1rem;
            border: 0 solid transparent;
            border-radius: 0.375rem;
        }

        form {
            display: inline-block;
        }

        .footer {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            /* text-align: center; */
        }

        .border-red {
            display: block;
            width: 100%;
            padding: 0.2rem 0.875rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.53;
            color: #697a8d;
            background-color: #fff;
            background-clip: padding-box;
            border: 2px solid rgb(234, 14, 14);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <div class="sidebar close">
                <div class="logo-details mt-3">
                    {{-- <i class="bx bxl-c-plus-plus"></i> --}}
                    <img class="img-xs" src="{{ asset('assets/img/jic/logo.png') }}" alt="">
                    <h5 class="logo_name">Group 8</h5>
                    {{-- <img src="{{ asset('assets/img/jic/jic.png') }}" style="width:140px;" alt=""> --}}
                </div>
                <ul class="nav-links">
                    <li class="menu-item mb-2 {{ $title == 'Dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-home"></i>
                            <span class="link_name">Dashboard</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="{{ route('dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>

                    <li class="menu-item mb-2 {{ $title == 'Barang' ? 'active' : '' }}">
                        <a href="{{ route('barang') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-wine-bottle"></i>
                            <span class="link_name">Barang</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="{{ route('barang') }}">Barang</a></li>
                        </ul>
                    </li>
                    
                    @if ($IdAkses != 3)
                        <li class="menu-item mb-2 {{ $title == 'List Transaksi' ? 'active' : '' }}">
                            <a href="{{ route('list-transaksi') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-list"></i>
                                <span class="link_name">Transaksi</span>
                            </a>
                            <ul class="sub-menu blank">
                                <li><a class="link_name" href="{{ route('list-transaksi') }}">Transaksi</a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($IdAkses == 1)
                        <li
                            class="menu-item mb-2 {{ $title == 'List Tipe Posisi' || $title == 'List Pengguna' ? 'active' : '' }}">
                            <a href="{{ route('tipe-posisi') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-user"></i>
                                <span class="link_name">Pengguna</span>
                            </a>
                            <ul class="sub-menu blank">
                                <li><a class="link_name" href="{{ route('tipe-posisi') }}">Pengguna</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item mb-2 {{ $title == 'List Supplier' ? 'active' : '' }}">
                            <a href="{{ route('supplier') }}" class="menu-link">
                                <i class="menu-icon tf-icons fas fa-box"></i>
                                <span class="link_name">Supplier</span>
                            </a>
                            <ul class="sub-menu blank">
                                <li><a class="link_name" href="{{ route('supplier') }}">Supplier</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>

            <section class="home-section">
                <div class="home-content">
                    <div class="layout-page">
                        <nav class="layout-navbar navbar navbar-detached navbar-expand-xl">
                            <div class="layout-menu-toggle" style="margin-right: auto">
                                <i class="bx bx-menu" style="font-size: 35px;"></i>
                            </div>
                            <div style="margin-left: auto;">
                                <div class="btn-group" style="margin-right: 10px;">
                                    <button type="button" class="btn dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('/uploads/no_images.png') }}" />
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="{{ asset('/uploads/no_images.png') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-semibold d-block">Tes nama</span>
                                                        <small class="text-muted">Tes</small>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#modalLogout" data-bs-toggle="modal"
                                                data-bs-target="#modalLogout">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <div class="content-wrapper">
                            @if ($title == 'List Barang')
                                @yield('barang')
                            @endif
                            @if ($title == 'Harga Barang' || $title == 'Barang Price Detail' || $title == 'Barang Add Stock')
                                @yield('harga-barang')
                            @endif
                            @if ($title == 'Barang Request List' || $title == 'Barang History')
                                @yield('barang-request-list')
                            @endif
                            @if ($title == 'Tambah Stok Barang')
                                @yield('tambah-stok-barang')
                            @endif
                            @if ($title == 'List Transaksi')
                                @yield('list-transaksi')
                            @endif
                            @if ($title == 'History Transaksi')
                                @yield('history-transaksi')
                            @endif
                            @if ($title == 'List Tipe Posisi')
                                @yield('list-tipe-posisi')
                            @endif
                            @if ($title == 'List Pengguna')
                                @yield('pengguna')
                            @endif
                            @if ($title == 'List Supplier')
                                @yield('supplier')
                            @endif
                            @if ($title == 'Dashboard')
                                @yield('dashboard')
                            @endif


                            <footer class="content-footer footer bg-footer-theme">
                                <div
                                    class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                    <div class="mb-2 mb-md-0">
                                        © {{ date('Y') }}
                                        Jakarta International College
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modalLogout" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('logout') }}" method="GET" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="Idreq_cancel" id="Idreq_cancel" value="">
                        Are you sure you want to logout ?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Logout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="shopingcart" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Barang Request List</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-11">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <p class="mb-0">
                                        <span class="text-muted">Sort by:</span>
                                        <a href="#!" class="text-body">date
                                            <i class="fas fa-angle-down mt-1"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-md-2 col-lg-2 col-xl-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp"
                                        class="img-fluid rounded-3" alt="Cotton T-shirt">
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <p class="lead fw-normal mb-2">Basic T-shirt</p>
                                    <p><span class="text-muted">Size: </span>M <span class="text-muted">Color:
                                        </span>Grey</p>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                    <button class="btn btn-link px-2"
                                        onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input id="form1" min="0" name="quantity" value="2"
                                        type="number" class="form-control form-control-sm" />
                                    <button class="btn btn-link px-2"
                                        onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                    <h5 class="mb-0">$499.00</h5>
                                </div>
                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                    <a href="#!" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- / Layout wrapper -->
</body>

<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }

    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });

    @if (\Session::has('success'))
        var msg = "{{ Session::get('success') }}"
        Swal.fire(
            'Success',
            msg,
            'success'
        )
        @php \Session::forget('success') @endphp
        @php \Session::forget('error') @endphp
        @php \Session::forget('info') @endphp
    @endif

    @if (\Session::has('error'))
        var msg = "{{ Session::get('error') }}"
        Swal.fire(
            'Whoops',
            msg,
            'error'
        )
        @php \Session::forget('success') @endphp
        @php \Session::forget('error') @endphp
        @php \Session::forget('info') @endphp
    @endif
</script>
@section('js')
@show

</html>
