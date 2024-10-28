@extends('Pengguna.template-user')
@section('list-transaksi')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                
                <li
                    class="breadcrumb-item {{ $title == 'Beverage Request List' || $title == 'Beverage History' ? 'active' : '' }}">
                    <a href="{{ url('beverage-request-list') }}">{{ $title }}</a>
                </li>
            </ol>
        </nav>
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item me-2">
                <a class="nav-link {{ $title == 'List Transaksi' ? 'active' : '' }}" href="{{ url('list-transaksi-customer') }}"><i
                        class="far fa-file-alt fa-lg me-1"></i>List Pesanan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $title == 'Beverage History' ? 'active' : '' }}"
                    href="{{ url('history-transaksi-customer') }}"><i class="fas fa-history fa-lg me-1"></i>
                    History</a>
            </li>
        </ul>
        @if ($title == 'List Transaksi')
            <div class="card">
                <h5 class="card-header">List Pesanan Barang</h5>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <form class="d-flex" method="GET" id="search_form">
                                <input class="form-control" type="search" name="search" placeholder="Search"
                                    value="{{ request('search') }}">
                                <input type="hidden" name="sortir" id="sortir" value="{{ request('sortir') }}">
                                <button class="btn btn-outline-primary btnSearch ms-2" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr style="background-color: rgba(67, 89, 113, 0.1)">
                                    <th class="align-middle" rowspan="2" style="text-align: center">No</th>
                                    <th class="align-middle" rowspan="2" style="text-align: center">Customer</th>
                                    <th class="align-middle" rowspan="2" style="text-align: center">Tanggal Pesanan</th>
                                    <th class="text-center" colspan="4">Detail</th>
                                    <th class="align-middle" rowspan="2" style="text-align: center">Status</th>
                                    <th class="align-middle" rowspan="2" style="text-align: center">Action</th>
                                </tr>
                                <tr style="background-color: rgba(67, 89, 113, 0.1)">
                                    <th class="text-center">Barang</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Harga / Item</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @if (!$data_beverage_request->isEmpty())
                                    <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $no = $limit * $page - $limit; ?>
                                    @foreach ($data_beverage_request as $item)
                                        <?php
                                        $data_barang = DB::table('detail_transaksi')->select('barang.NamaBarang', 'detail_transaksi.*')
                                            ->join('barang', 'barang.IdBarang', 'detail_transaksi.IdBarang')
                                            ->where('IdTransaksi', $item->IdTransaksi)
                                            ->get();
                                        
                                        $total_tabel = $data_barang->count();
                                        ?>

                                        <tr>
                                            <td class="text-center" rowspan="{{ $total_tabel + 1 }}"
                                                style="text-align: center">
                                                {{ ++$no }}</td>
                                            <td class="text-center" rowspan="{{ $total_tabel + 1 }}"
                                                style="text-align: center">
                                                {{ $item->NamaDepan . ' ' . $item->NamaBelakang  }} </td>

                                            <td class="text-center fw-bold" rowspan="{{ $total_tabel + 1 }}"
                                                style="width: 15%">
                                                {{ date('j M Y ', strtotime($item->TanggalTransaksiDitambah)) }}
                                            </td>
                                        </tr>

                                        <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        $no_item = $limit * $page - $limit; ?>

                                        @foreach ($data_barang as $i)
                                            <tr>
                                                <td class="text-center" style="display:none; width: 10%">
                                                    {{ ++$no_item }}</td>
                                                <td class="text-center fw-bold"
                                                    style="text-transform:uppercase; width: 15%">
                                                    {{ $i->NamaBarang }}</td>
                                                <td class="text-center" style="width: 15%">{{ $i->TotalBarang }}
                                                    pcs
                                                </td>
                                                <td class="text-center" style="width: 15%">
                                                    {{-- {{ 'Rp. ' . number_format($i->beverage_price, 0, ',', '.') }} --}}
                                                    {{ 'Rp. ' . number_format($i->HargaBarang / $i->TotalBarang, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center" style="width: 15%">
                                                    {{ 'Rp. ' . number_format($i->HargaBarang, 0, ',', '.') }}
                                                </td>
                                                @if ($no_item == 1)
                                                    <td class="text-center" rowspan="{{ $total_tabel }}"
                                                        style="width: 15%">

                                                        <button type="button" class="badge bg-label-warning"
                                                            style="border: none;" 
                                                            ><span class="tf-icons bx bxs-timer"></span>
                                                            Pending
                                                        </button>

                                                    </td>
                                                    <td class="text-center" rowspan="{{ $total_tabel }}"
                                                        style="width: 15%">

                                                        <button type="button" class="btn btn-danger" value="{{ $item->IdTransaksi }}" id="buttonCancel">
                                                           Batalkan
                                                        </button>

                                                    </td>
                                                @endif
                                                
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" style="text-align: center">No Data Existed</td>
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
                            {!! $data_beverage_request->firstItem() !!} to
                            {!! $data_beverage_request->lastItem() !!} of {!! $data_beverage_request->total() !!} entries
                        </div>
                        <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                            {!! $data_beverage_request->appends(request()->all())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($title == 'Beverage History')
            @yield('beverage-history')
        @endif
    </div>


    {{-- CHANGE STATUS TO WAITING --}}
    <div class="modal fade" id="batalkanModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Batalkan pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hapus-transaksi') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="company_name" class="form-label" style="text-transform: uppercase">Apakah Anda Yakin
                            Akan Menghapus Pesanan Ini ?</label>
                        <input type="hidden" id="IdTransaksi" name="IdTransaksi">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            button
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Hapus
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
         

            $(document).on('click', '#buttonCancel', function() {
                var IdTransaksi = $(this).val();
                $('#batalkanModal').modal('show')

                $('#IdTransaksi').val(IdTransaksi)
            });

        });
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
            $('#sortir').val(nValue);
            $('#search_form').submit();
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
