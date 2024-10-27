@extends('Admin.template')
@section('tambah-stok-barang')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item {{ $title == 'Beverage Stok & Price' ? 'active' : '' }}">
                    <a href="{{ url('barang') }}">List Barang</a>
                </li>
                <li
                    class="breadcrumb-item {{ $title == 'Beverage Price Detail' || $title == 'Beverage Add Stock' ? 'active' : '' }}">
                    <a href="{{ Request::url() }}">{{ $title }}</a>
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row" style="font-size: 14px;">
                            <div class="col-md-12">
                                <div class="row mb-1">
                                    <h4 class="col-md-3  fw-bold" style="">Nama Barang
                                    </h4>
                                    <h4 class="col-md-7">
                                        : {{ $data_barang->NamaBarang }}
                                    </h4>
                                </div>
                                <div class="row mb-1">
                                    <h4 class="col-md-3  fw-bold" style="">Harga Jual Barang
                                    </h4>

                                    <h4 class="col-md-7">
                                        : Rp. {{ number_format(ceil($data_barang->HargaBarang), 0, ',', '.') }}
                                    </h4>
                                </div>
                                <div class="row mb-1">
                                    <h4 class="col-md-3 fw-bold" style="">Stok saat ini
                                    </h4>
                                    <h4 class="col-md-7">
                                        : @if ($total_stock == 0)
                                            <span class="badge bg-label-danger">Tidak ada Stock</span>
                                        @elseif($total_stock < 0)
                                            <span class="badge bg-label-warning">Butuh {{ $total_stock * -1 }} Pcs
                                            </span>
                                        @elseif($total_stock < 50)
                                            <span class="badge bg-label-warning"> {{ $total_stock }} Pcs</span>
                                        @else
                                            <span class="badge bg-label-success"> {{ $total_stock }} Pcs</span>
                                        @endif
                                    </h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <form action="{{ route('tambah-transaksi-stok-barang') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <h5 class="card-header">{{ $title }}</h5>

                        <div class="card-body">
                            {{-- <div class="row mb-3"> --}}
                            {{-- <label class="col-sm-4 col-form-label">Beverage</label> --}}
                            {{-- <div class="col-sm-8"> --}}
                            {{-- <select required class="form-control" name="Idbeverage" id="Idbeverage" onchange="getPrice()">
                            <option hidden value="">Select Beverage</option>
                            @foreach ($beverage as $item)
                                <option value="{{ $item->Idbeverage }}">{{ $item->beverage_name }}</option>
                            @endforeach
                        </select> --}}
                            <input type="hidden" value="{{ $id }}" name="IdBarang" id="IdBarang">
                            {{-- </div> --}}
                            {{-- </div> --}}
                            <?php
                            $supplier = DB::table('supplier')->get();
                            ?>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Supplier</label>
                                <div class="col-sm-8 d-flex">
                                    <select name="IdSupplier" id="IdSupplier" class="form-select">
                                        <option value="" hidden>Select Supplier</option>
                                        @foreach ($supplier as $item)
                                            <option value="{{ $item->IdSupplier }}">{{ $item->NamaSupplier }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Total Barang</label>
                                <div class="col-sm-8 d-flex">
                                    <input id="TotalBarang" name="TotalBarang" type="number" class="form-control"
                                        placeholder="Masukkan Total Barang" onkeyup="getPrice()">
                                    <p style="margin: 10px">Pcs</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Harga Barang</label>
                                <div class="col-sm-8 d-flex">
                                    <input id="HargaBarang" name="HargaBarang" type="text" class="form-control"
                                        placeholder="Masukkan Harga" onkeyup="getPrice()">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Total Harga</label>
                                <div class="col-sm-8 d-flex">
                                    <input id="TotalHarga" name="TotalHarga" type="text" class="form-control" readonly
                                        placeholder="Masukkan Harga dan Total barang">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                Tambah Stok
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endsection
    @section('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function getPrice() {
                var nominal = $('#HargaBarang').val();
                var quantity = $('#TotalBarang').val();

                var coba = nominal.replace('Rp.', "");

                $('#TotalHarga').val('Rp. ' + parseInt(coba.replace('.', "") * quantity).toLocaleString());
            }

            var harga = document.getElementById('HargaBarang');
            harga.addEventListener('keyup', function(e) {
                harga.value = formatRupiah(this.value, 'Rp. ');
            });


            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
        </script>
    @stop
