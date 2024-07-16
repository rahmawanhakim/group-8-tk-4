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
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item me-2">
                        <a class="nav-link {{ $title == 'Harga Barang' ? 'active' : '' }}"
                            href="{{ url('harga-barang/' . $id) }}"><i class="fas fa-dollar-sign fa-lg me-1"></i>Harga
                            Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $title == 'Tambah Stok Barang' ? 'active' : '' }}"
                            href="{{ url('tambah-stok-barang/' . $id) }}"><i class="fas fa-truck-loading fa-lg me-1"></i>
                            Tambah Stok</a>
                    </li>
                </ul>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row" style="font-size: 14px;">
                            <div class="col-md-12">
                                <div class="row mb-1">
                                    <h4 class="col-md-3  fw-bold" style="">Nama Barang
                                    </h4>
                                    <h4 class="col-md-7">
                                        : {{ $data_barang->nama_barang }}
                                    </h4>
                                </div>
                                <div class="row mb-1">
                                    <h4 class="col-md-3  fw-bold" style="">Harga Jual Barang
                                    </h4>
                                    <?php $data_harga = DB::table('tb_harga_barang')->where('id_barang', $id)->orderBy('id_harga_barang', 'DESC')->first(); ?>
                                    <h4 class="col-md-7">
                                        @if($data_harga != null)
                                        :  Rp.  {{ number_format(ceil($data_harga->harga_barang  ), 0, ',', '.') }}
                                        @else
                                       :  Harga Belum Ditambah
                                        @endif
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
                            {{-- <select required class="form-control" name="id_beverage" id="id_beverage" onchange="getPrice()">
                            <option hidden value="">Select Beverage</option>
                            @foreach ($beverage as $item)
                                <option value="{{ $item->id_beverage }}">{{ $item->beverage_name }}</option>
                            @endforeach
                        </select> --}}
                            <input type="hidden" value="{{ $id }}" name="id_barang" id="id_barang">
                            {{-- </div> --}}
                            {{-- </div> --}}



                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Total Barang</label>
                                <div class="col-sm-8 d-flex">
                                    <input id="total_barang" name="total_barang" type="number" class="form-control"
                                        placeholder="Masukkan Total Barang" onkeyup="getPrice()">
                                    <p style="margin: 10px">Pcs</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Harga Barang</label>
                                <div class="col-sm-8 d-flex">
                                    <input id="harga_barang" name="harga_barang" type="text" class="form-control"
                                        placeholder="Masukkan Harga" onkeyup="getPrice()">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Total Harga</label>
                                <div class="col-sm-8 d-flex">
                                    <input id="total_harga" name="total_harga" type="text" class="form-control" readonly
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
                    var nominal = $('#harga_barang').val();
                    var quantity = $('#total_barang').val();

                    var coba = nominal.replace('Rp.', "");

                    $('#total_harga').val('Rp. ' + parseInt(coba.replace('.', "") * quantity).toLocaleString());
                }

                var harga = document.getElementById('harga_barang');
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
