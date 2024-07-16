@extends('Admin.template')
@section('harga-barang')
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
                            href="{{ url('tambah-stok-barang/' . $id) }}"><i
                                class="fas fa-truck-loading fa-lg me-1"></i>
                            Tambah Stok</a>
                    </li>
                </ul>
                <div class="card">

                    <?php
                        $data_barang = DB::table('tb_barang')->where('id_barang', $id)->first();
                    ?>
                    <h5 class="card-header">{{ $title }} {{ $data_barang->nama_barang }}</h5>
                    <div class="card-body">

                        <form class="d-flex mb-4" method="GET" id="search_form">
                          
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalCenter">
                                Tambah Harga Baru
                            </button>
                        </form>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Harga Barang</th>
                                        <th>Tanggal Harga Barang Ditambah</th>
                                        <th>Harga Barang Ditambah Oleh</th>
                                        <th>Aktif</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @if (!$data_harga_barang->isEmpty())
                                        <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        
                                        $no = $limit * $page - $limit; ?>

                                        @foreach ($data_harga_barang as $item)
                                                <td>{{ ++$no }}</td>
                                                <td>Rp. {{ number_format(ceil($item->harga_barang), 0, ',', '.') }}</td>
                                                <td>{{ date('j M Y H:i:s', strtotime($item->tanggal_harga_barang_ditambah)) }}</td>
                                                <td>{{ $item->nama_pegawai }}</td>
                                                <td>
                                                    @if($no == 1)
                                                    <span class="badge bg-label-success">Yes</span>
                                                    @else
                                                    <span class="badge bg-label-danger">No</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" style="text-align: center">No Data Existed</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-1 align-middle d-flex flex-column align-items-md-start">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-maroon dropdown-toggle"
                                        style="background-color: maroon; color:white;" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        {{ request('sortir') == null ? '10' : request('sortir') }}
                                    </button>
                                    <ul class="dropdown-menu" id="listSortir">
                                        <li class="listAttr" value="10"><a class="dropdown-item text-small">10</a></li>
                                        <li class="listAttr" value="20"><a class="dropdown-item" href="#">20</a>
                                        </li>
                                        <li class="listAttr" value="50"><a class="dropdown-item" href="#">50</a>
                                        </li>
                                        <li class="listAttr" value="100"><a class="dropdown-item" href="#">100</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-5 align-middle d-flex flex-column align-items-md-start" id="showing_page">
                                Showing
                                {!! $data_harga_barang->firstItem() !!} to
                                {!! $data_harga_barang->lastItem() !!} of {!! $data_harga_barang->total() !!} entries
                            </div>
                            <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                                {!! $data_harga_barang->appends(request()->all())->links() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Tambah Harga {{ $data_barang->nama_barang }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route('tambah-harga-barang') }}" enctype="multipart/form-data">
                                <div class="modal-body">

                                    @csrf
                                    <input type="hidden" name="id_barang" id="id_barang"
                                        value="{{ $id }}">
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label">Harga</label>
                                        <div class="col-sm-8">
                                            <input id="harga_barang" required name="harga_barang"
                                                type="text" class="form-control" placeholder="Masukkan Harga">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save
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
                    // EDIT FLOOR
                    $(document).ready(function() {
                        $(document).on('click', '.editBtn', function() {
                            var beverage_price_id = $(this).val();

                            $('#modalUpdate').modal('show')

                            $.ajax({
                                type: 'GET',
                                url: "{{ url('item_edit_beverage_price') }}/" + beverage_price_id,
                                success: function(response) {
                                    console.log(response)
                                    $('#beverage_price_edit').val('Rp. ' + parseInt(response.beverage_price
                                        .beverage_price).toLocaleString())
                                    $('#id_beverage_price').val(response.beverage_price.id_beverage_price)
                                    $('#beverage_price_start_date_edit').val(response.beverage_price
                                        .beverage_price_start_date)
                                }
                            })
                        })

                    });
                    // END EDIT beverage_price

                    // DELETE beverage_price
                    $(document).ready(function() {
                        $(document).on('click', '.deleteBtn', function() {
                            var beverage_price_id = $(this).val();

                            $('#modalDelete').modal('show')

                            $.ajax({
                                type: 'GET',
                                url: "{{ url('item_delete_beverage_price') }}/" + beverage_price_id,
                                success: function(response) {

                                    $('#id_beverage_price_delete').val(response.delete.id_beverage_price)
                                }
                            })
                        })

                    });
                    // END DELETE
                </script>
                <script type="text/javascript">
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

                    var edit_harga = document.getElementById('beverage_price_edit');
                    edit_harga.addEventListener('keyup', function(e) {
                        edit_harga.value = formatEditRupiah(this.value, 'Rp. ');
                    });

                    function formatEditRupiah(angka, prefix) {
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

                    var strQuery, strUrlParams, nSearch, nPaginatorSelected;
                    $(document).ready(function() {

                        strQuery = window.location.search;
                        strUrlParams = new URLSearchParams(strQuery);
                        nSearch = strUrlParams.get('search')

                    });

                    function getSearch() {
                        var result;
                        nSearchFiltering = $(".search").val();
                        if (nSearch) {
                            result = nSearch;

                        } else {
                            if (nSearchFiltering) {
                                result = nSearchFiltering;
                            } else {
                                result = ""
                            }
                        }
                        return result;
                    }

                    $(".listAttr").click(function() {
                        var nValue = $(this).val();
                        console.log(nValue);
                        $('#sortir').val(nValue);
                        submitFilter(nValue);

                    });


                    $('#btnSearch').click(function() {
                        var search = $(this).val();
                        submitFilter(search);
                    });

                    function submitFilter(search) {



                        if (search) {
                            var nSearchFiltered = search;
                        } else {
                            var nSearchFiltered = getSearch();
                        }


                        $('#search').val(nSearchFiltered);
                        $('#search_form').submit();
                    }
                </script>
                <script type="text/javascript">
                    var harga = document.getElementById('rent_charge_nominal_add');
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

                        rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
                        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                    }

                    var edit_harga = document.getElementById('rent_charge_nominal_edit');
                    edit_harga.addEventListener('keyup', function(e) {
                        edit_harga.value = formatEditRupiah(this.value, 'Rp. ');
                    });

                    function formatEditRupiah(angka, prefix) {
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
                <script>
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
            @stop
