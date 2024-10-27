@extends('Admin.template')
@section('dashboard')
    <style>
        .ui-autocomplete {
            z-index: 9999999 !important;
        }

        /* .select {
                                                                                                                                                color: red;
                                                                                                                                            } */

        .select2 {
            z-index: 9999999 !important;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">Dashboard</a>
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="card col-sm-5">
                <h5 class="card-header fw-bold">Laporan Laba Rugi</h5>
                <div class="card-body">
                    <div class="flex">
                        <div class="row mb-1">
                            <h5 class="col-md-6" style="">Total Barang Terjual
                            </h5>
                            <h5 class="col-md-6">
                                : {{ $data_quantity_sold }} Pcs
                            </h5>
                        </div>
                        <div class="row mb-1">
                            <h5 class="col-md-6" style="">Total Barang Dibeli
                            </h5>

                            <h5 class="col-md-6">
                                : {{ $data_quantity_buy }} Pcs
                            </h5>
                        </div>
                        <div class="row mb-1">
                            <h5 class="col-md-6" style="">Total Harga Barang Terjual
                            </h5>
                            <h5 class="col-md-6">
                                : {{ 'Rp. ' . number_format(ceil($data_price_sold), 0, ',', '.') }}
                            </h5>
                        </div>
                        <div class="row mb-1">
                            <h5 class="col-md-6" style="">Total Harga Barang Dibeli
                            </h5>

                            <h5 class="col-md-6">
                                : {{ 'Rp. ' . number_format(ceil($data_price_buy), 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-1">

            </div>
            <div class="card col-sm-5">
                <h5 class="card-header fw-bold">Laporan Laba Rugi Per Barang</h5>
                <div class="card-body">
                    <div class="flex">
                        @foreach ($barang as $item)
                          <?php
                          $get_total_sold = DB::table('detail_transaksi')->join('transaksi', 'transaksi.IdTransaksi','detail_transaksi.IdTransaksi')
                          ->where('IdBarang', $item->IdBarang)->where('StatusTransaksi',2)->where('JenisTransaksi', 0)->get()->sum('TotalBarang');

                          $get_total_buy = DB::table('detail_transaksi')->join('transaksi', 'transaksi.IdTransaksi','detail_transaksi.IdTransaksi')
                          ->where('IdBarang', $item->IdBarang)->where('StatusTransaksi',2)->where('JenisTransaksi', 1)->get()->sum('TotalBarang');

                          $harga_jual = DB::table('detail_transaksi')->join('transaksi', 'transaksi.IdTransaksi','detail_transaksi.IdTransaksi')
                          ->where('IdBarang', $item->IdBarang)->where('StatusTransaksi',2)->where('JenisTransaksi', 0)->get()->sum('HargaBarang');

                          $check_harga = DB::table('detail_transaksi')->join('transaksi', 'transaksi.IdTransaksi','detail_transaksi.IdTransaksi')
                          ->where('IdBarang', $item->IdBarang)->where('StatusTransaksi',2)->where('JenisTransaksi', 1)->get()->sum('HargaBarang');

                          if($check_harga == 0 || $get_total_buy == 0){
                            $harga_beli = 0;
                          }else{
                            $harga_beli = $get_total_sold * ($check_harga / $get_total_buy);

                          }

                          ?>

                            <div class="d-flex mb-5">
                                <div class="me-3">
                                    <div class="">
                                        <img style="width:100px" src="{{  asset('gambar_barang/' . $item->GambarBarang) }}" />
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="fw-semibold d-block" style="font-size: 20px">{{ $item->NamaBarang }}</span>
                                    <small class="text-muted" style="font-size: 17px">Terjual : {{ $get_total_sold }} Pcs </small>

                                        <div> 
                                            <small class="text-muted" style="font-size: 17px">Keuntungan : {{ 'Rp. ' . number_format(ceil($harga_jual - $harga_beli), 0, ',', '.') }}</small>
                                        </div> 
                                </div>
                                <div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
            <div class="d-flex">
                <div class="card col-sm-2 mt-5  text-center">
                    <h5 class="card-header fw-bold">Total Barang</h5>
                    <div class="card-body">
                        <div class="flex">
                            <h1>{{ $total_barang }}</h1>
                        </div>

                    </div>
                </div>
                <div class="card col-sm-2  mt-5 text-center" style="margin-left: 110px">
                    <h5 class="card-header fw-bold">Total Pengguna</h5>
                    <div class="card-body">
                        <div class="flex">
                            <h1>{{ $user }}</h1>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>




@endsection
@section('js')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stop
