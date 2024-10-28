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

        .form-control2 {
            display: block;
            width: 100%;
            padding: 0.2rem 0.875rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.53;
            color: #697a8d;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d9dee3;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
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
            border: 2px solid maroon;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .footer {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            /* text-align: center; */
        }

        .invoice {
            background: #fff;
            padding: 20px
        }

        .invoice-company {
            font-size: 20px
        }

        .invoice-header {
            margin: 0 -20px;
            padding: 20px
        }

        .invoice-date,
        .invoice-from,
        .invoice-to {
            display: table-cell;
            width: 1%
        }

        .invoice-from,
        .invoice-to {
            padding-right: 20px
        }

        .invoice-date .date,
        .invoice-from strong,
        .invoice-to strong {
            font-size: 16px;
            font-weight: 600
        }

        .invoice-date {
            text-align: right;
            padding-left: 20px
        }

        .invoice-price {
            background: #f0f3f4;
            display: table;
            width: 100%
        }

        .invoice-price .invoice-price-left,
        .invoice-price .invoice-price-right {
            display: table-cell;
            padding: 20px;
            font-size: 20px;
            font-weight: 600;
            width: 75%;
            position: relative;
            vertical-align: middle
        }

        .invoice-price .invoice-price-left .sub-price {
            display: table-cell;
            vertical-align: middle;
            padding: 0 20px
        }

        .invoice-price small {
            font-size: 12px;
            font-weight: 400;
            display: block
        }

        .invoice-price .invoice-price-row {
            display: table;
            float: left
        }

        .invoice-price .invoice-price-right {
            width: 25%;
            background: #2d353c;
            color: #fff;
            font-size: 28px;
            text-align: right;
            vertical-align: bottom;
            font-weight: 300
        }

        .invoice-price .invoice-price-right small {
            display: block;
            opacity: .6;
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 12px
        }

        .invoice-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 10px
        }

        .invoice-note {
            color: #999;
            margin-top: 80px;
            font-size: 85%
        }

        .invoice>div:not(.invoice-footer) {
            margin-bottom: 20px
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <br>
            <div class="sidebar close">
                <div class="logo-details">
                   
                </div>
                <div class="logo-details">
                    {{-- <i class="bx bxl-c-plus-plus"></i> --}}
                    <img class="img-xs" src="{{ asset('assets/img/jic/logo.png') }}" alt="">
                    <h5 class="logo_name">Group 8</h5>
                    {{-- <img src="{{ asset('assets/img/jic/jic.png') }}" style="width:140px;" alt=""> --}}
                </div>
                <ul class="nav-links">
                    <li class="menu-item mb-2 {{ $title == 'Dashboard Customer' ? 'active' : '' }}">
                        <a href="{{ route('list-transaksi-customer') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-list"></i>
                            <span class="link_name">List Transaksi</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="{{ route('list-transaksi-customer') }}">List Transaksi</a></li>
                        </ul>
                    </li>
                    <li
                        class="menu-item mb-2 {{ $title == 'Request Beverage' || $title == 'History Beverage' || $title == 'Add Request Beverage' ? 'active' : '' }}">
                        <a href="{{ route('display-barang') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-shopping-basket"></i>
                            <span class="link_name">Tambah Transaksi</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="link_name" href="{{ route('display-barang') }}">Tambah Transaksi</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- / Menu -->
            <?php
            $bev_cart = DB::table('detail_transaksi')
                ->join('barang', 'barang.IdBarang', 'detail_transaksi.IdBarang')
                ->where('IdPengguna', $IdPengguna)
                ->where('IdTransaksi', 0)
                ->get();
            
            $total_cart = $bev_cart->count();
            
            ?>
            <section class="home-section">
                <div class="home-content">
                    <div class="layout-page">
                        <nav class="layout-navbar navbar navbar-detached navbar-expand-xl">
                            <div class="layout-menu-toggle" style="margin-right: auto">
                                <i class="bx bx-menu" style="font-size: 35px;"></i>
                            </div>
                            <div style="margin-left: auto;">
                                <button type="button" class="btn" style="" data-bs-toggle="modal"
                                    data-bs-target="#shopingcart">
                                    <i class="fas fa-shopping-cart" style="font-size: 20px;">
                                        @if ($total_cart != 0)
                                            <span
                                                class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">
                                                {{ $total_cart }}
                                            </span>
                                        @endif
                                    </i>
                                </button>
                                <div class="btn-group" style="margin-right: 10px;">
                                    <button type="button" class="btn dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('/uploads/renter.png') }}" alt
                                                class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="{{ asset('/uploads/renter.png') }}" alt
                                                                class="w-px-40 h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    {{-- <div class="flex-grow-1">
                                                        <span
                                                            class="fw-semibold d-block">{{ $data_user->customer_name }}</span>
                                                        <small
                                                            class="text-muted">{{ $data_user->customer_owner }}</small>
                                                    </div> --}}
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
                            <!-- Content -->
                            
                            @if ($title == 'Add Request Beverage')
                                @yield('add-request-beverage')
                            @endif
                          
                            @if ($title == 'List Transaksi')
                                @yield('list-transaksi')
                            @endif
                            
                            @if ($title == 'History Transaksi')
                                @yield('history-transaksi')
                            @endif
                            
                            <footer class="content-footer footer bg-footer-theme">
                                <div
                                    class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                    <div class="mb-2 mb-md-0">
                                        © {{ date('Y') }}
                                        Group 8
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
                    <h4 class="modal-title" id="modalCenterTitle">List Keranjang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form method="POST" action="{{ route('checkout_beverage') }}" id="form_checkout"
                        enctype="multipart/form-data">
                        <div class="row d-flex justify-content-center align-items-center mb-4">
                            <div class="col-11">
                                @csrf
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    {{-- <div>
                                        <input min="{{ date('Y-m-d') }}" type="date" name="request_date"
                                            id="request_date" class="form-control" required>
                                    </div> --}}
                                </div>
                                @foreach ($bev_cart as $bevrg)
                                    <?php
                                    
                                    $bev_total_nominal = DB::table('detail_transaksi')
                                        ->where('IdBarang', $bevrg->IdBarang)
                                        ->where('IdPengguna', $IdPengguna)
                                        ->where('IdTransaksi', 0)
                                        ->get()
                                        ->sum('HargaBarang');
                                    $bev_total_qty =DB::table('detail_transaksi')
                                        ->where('IdBarang', $bevrg->IdBarang)
                                        ->where('IdPengguna', $IdPengguna)
                                        ->where('IdTransaksi', 0)
                                        ->get()
                                        ->sum('TotalBarang');
                                    ?>
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                            <img src="{{ asset('gambar_barang/' . $bevrg->GambarBarang) }}"
                                                width="160" height="160">
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <h5 class="mb-2">{{ $bevrg->NamaBarang }}</h5>
                                            <h6>{{ $bevrg->Keterangan }}</h6>
                                        </div>
                                        <input type="hidden" name="Idbeverage_no[]" id="Idbeverage_no"
                                            value="{{ $bevrg->IdBarang}}">
                                        <input type="hidden" name="IdDetailTransaksi[]"
                                            id="IdDetailTransaksi"
                                            value="{{ $bevrg->IdDetailTransaksi }}">
                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                            <button type="button" class="btnDown btn px-2"
                                                onclick="getNominalDownList('{{ $bevrg->IdBarang}}')">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input min="0"
                                                id="TotalBarang-{{ $bevrg->IdBarang}}"
                                                name="TotalBarang[]" type="number"
                                                value="{{ $bev_total_qty }}"
                                                onkeyup="getNominalList('{{ $bevrg->IdBarang}}')"
                                                class="form-control form-control-sm" />
                                            <button type="button" class="btnUp btn px-2"
                                                onclick="getNominalUpList('<?= $bevrg->IdBarang?>')">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2">
                                            <input class="col-sm-10" style="border:none; " readonly
                                                id="HargaBarangChart-{{ $bevrg->IdBarang}}"
                                                value="{{ 'Rp. ' . number_format(ceil($bev_total_nominal), 0, ',', '.') }}"
                                                name="HargaBarang[]">
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                            <button type="button" onclick="hapus({{ $bevrg->IdDetailTransaksi }})"
                                                value="{{ $bevrg->IdDetailTransaksi }}"
                                                class="btnDeleteCart btn btn-danger"><span
                                                    class="fas fa-trash fa-lg"></span></button>
                                        </div>
                                    </div>
                                 @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    @if ($total_cart == 1)
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btnCheckout btn btn-primary">Checkout Now</button>
                    @elseif($total_cart != 0)
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btnCheckout btn btn-primary">Checkout Now</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

<div>
    <form method="POST" action="{{ route('delete_cart') }}" id="form_delete_cart" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="IdDetailTransaksi_delete" id="IdDetailTransaksi_delete">
    </form>
</div>

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
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btnDeleteCart', function() {
            var detail_id = $(this).val();
            $('#Idbeverage_detail_delete').val(detail_id);
            $('#form_delete_cart').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btnCheckout', function() {
            var date = $('#request_date').val();
            console.log(date);
            if (date == '') {
                alert('Insert Request Date First')
            } else {
                $('#form_checkout').submit();
                // alert('aman')
            }
        });
    });
</script>
<script>
    function getNominalDownList(Idbeverage) {
        var beverage_id = Idbeverage;
        var quantity = $('#TotalBarang-' + beverage_id).val();
        if (quantity != 1) {
            $('#TotalBarang-' + beverage_id).val(parseInt(quantity) - 1)

            $.ajax({
                type: 'GET',
                url: "{{ url('item_beverage_request') }}/" + beverage_id,
                success: function(response) {
                    $('#HargaBarangChart-' + beverage_id).val('Rp. ' +
                        parseInt((parseInt(quantity) - 1) * response.beverage.HargaBarang)
                        .toLocaleString());
                }
            })
        }
    }

    function hapus(id){
        // alert(id);
        $('#IdDetailTransaksi_delete').val(id);
        $('#form_delete_cart').submit()
    }

    function getNominalList(Idbeverage) {
        // console.log(quantity)
        var beverage_id = Idbeverage;
        var quantity = $('#TotalBarang-' + beverage_id).val();
        console.log(quantity);
        $.ajax({
            type: 'GET',
            url: "{{ url('item_beverage_request') }}/" + beverage_id,
            success: function(response) {
                $('#HargaBarangChart-' + beverage_id).val('Rp. ' + (quantity * response.beverage
                        .HargaBarang)
                    .toLocaleString());
            }
        })
    }

    function getNominalUpList(Idbeverage) {

        
        var beverage_id = Idbeverage;
        var quantity = $('#TotalBarang-' + beverage_id).val();
        var new_qty = parseInt(quantity) + 1;


        $('#TotalBarang-' + beverage_id).val(new_qty);

        $.ajax({
            type: 'GET',
            url: "{{ url('item_beverage_request') }}/" + beverage_id,
            success: function(response) {
                $('#HargaBarangChart-' + beverage_id).val('Rp. ' +
                    parseInt((parseInt(quantity) + 1) * response.beverage.HargaBarang)
                    .toLocaleString());
            }
        });
    }
</script>
<script type="text/javascript">
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

    @if (\Session::has('coba'))
        // var msg = "{{ Session::get('error') }}"

        $('#shopingcart').modal('show');

        // Swal.fire(
        //     'Whoops',
        //     // msg,
        //     // 'error'
        // )
        @php \Session::forget('success') @endphp
        @php \Session::forget('coba') @endphp
        @php \Session::forget('error') @endphp
        @php \Session::forget('info') @endphp
    @endif
</script>
@section('js')
@show

</html>
