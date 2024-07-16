@extends('Admin.template')
@section('barang')
    <style>
        .elip {
            width: 250px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item {{ $title == 'List Barang' ? 'active' : '' }}">
                    <a href="{{ url('barang') }}">List Barang</a>
                </li>
            </ol>
        </nav>
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <div class="card-body">
                <form class="d-flex mb-4" method="GET" id="search_form">
                    <input class="form-control" style="width: 50%;" type="search" name="search" placeholder="Search"
                        value="{{ request('search') }}" aria-label="Search">
                    <input type="hidden" name="sortir" id="sortir" value="{{ request('sortir') }}">
                    <button class="btn btn-outline-primary btnSearch ms-2 me-4" type="submit">Search</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                        Add New
                    </button>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="widows: 5%;">No</th>
                                <th style="width: 10%;">Name</th>
                                <th style="width: 10%;">Gambar</th>
                                <th style="width: 25%;">Deskripsi</th>
                                <th style="width: 10%;">Stok</th>
                                <th style="width: 10%;">Harga</th>
                                <th style="width: 15%;">Tanggal Ditambah</th>
                                <th style="width: 10%;">Ditambah Oleh</th>
                                <th class="text-center" style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if (!$data_barang->isEmpty())
                                <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                
                                $no = $limit * $page - $limit; ?>
                                @foreach ($data_barang as $item)
                                    <?php
                                    $stock_in = DB::table('tb_transaksi')
                                        ->join('tb_detail_transaksi as detail', 'detail.id_transaksi', 'tb_transaksi.id_transaksi')
                                        ->where('detail.id_barang', $item->id_barang)
                                        ->where('jenis_transaksi', 1)
                                        ->where('status_transaksi', 2)
                                        ->get()
                                        ->sum('total_barang');
                                    
                                    $stock_out = DB::table('tb_transaksi')
                                        ->join('tb_detail_transaksi as detail', 'detail.id_transaksi', 'tb_transaksi.id_transaksi')
                                        ->where('detail.id_barang', $item->id_barang)
                                        ->where('jenis_transaksi', 0)
                                        ->where('status_transaksi', 2)
                                        ->get()
                                        ->sum('total_barang');
                                    
                                    $total_stock = $stock_in - $stock_out;
                                    
                                    $data_harga_barang = DB::table('tb_harga_barang')
                                        ->select('harga_barang')
                                        ->where('id_barang', $item->id_barang)
                                        ->orderBy('id_harga_barang', 'DESC')
                                        ->first();
                                    ?>

                                    <tr>
                                        <td class="text-center p-2">{{ ++$no }}</td>
                                        <td class="p-2">
                                            <a href="{{ url('harga-barang/' . $item->id_barang) }}">{{ $item->nama_barang }}</a>
                                        </td>
                                        <td class="p-2">
                                            <img style="width: 60px;"
                                                src="{{ asset('gambar_barang/' . $item->gambar_barang) }}">
                                        </td>
                                        <?php
                                        $kata = DB::table('tb_barang')
                                            ->where(DB::raw('LENGTH(deskripsi_barang)'), '>', '50')
                                            ->get();
                                        ?>

                                        <td class="p-2">
                                            <p style="white-space:normal ;">
                                                   {{ $item->deskripsi_barang }}
                                            </p>
                                        </td>
                                        <td class="p-2">
                                            @if ($total_stock == 0)
                                                <span class="badge bg-label-danger">Stock Kosong</span>
                                            @elseif($total_stock < 0)
                                                <span class="badge bg-label-warning">Need {{ $total_stock * -1 }} Pcs
                                                </span>
                                            @elseif($total_stock < 50)
                                                <span class="badge bg-label-warning"> {{ $total_stock }} Pcs</span>
                                            @else
                                                <span class="badge bg-label-success"> {{ $total_stock }} Pcs</span>
                                            @endif
                                        </td>
                                        <td class="p-2">
                                            @if ($data_harga_barang != null)
                                                {{ 'Rp. ' . number_format(ceil($data_harga_barang->harga_barang), 0, ',', '.') }}
                                            @else
                                                <span class="badge bg-label-danger">Harga Barang Kosong</span>
                                            @endif
                                        </td>
                                        <td class="p-2">{{ date('j M Y', strtotime($item->tanggal_barang_ditambah)) }}
                                        </td>
                                        <td class="p-2">{{ $item->updated_by }}</td>
                                        <td class="text-center p-2">
                                            <button type="button" value="{{ $item->id_barang }}"
                                                class="btn rounded-pill btn-icon btn-danger deleteBtn">
                                                <span class="fas fa-trash-alt fa-2xs"></span>
                                            </button>
                                            <button type="button" value="{{ $item->id_barang }}"
                                                class="btn rounded-pill btn-icon btn-warning ms-2 editBtn">
                                                <span class="fas fa-edit fa-2xs"></span>
                                            </button>
                                        </td>
                                    </tr>
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
                                <li class="listAttr" value="20"><a class="dropdown-item" href="#">20</a></li>
                                <li class="listAttr" value="50"><a class="dropdown-item" href="#">50</a></li>
                                <li class="listAttr" value="100"><a class="dropdown-item" href="#">100</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5 align-middle d-flex flex-column align-items-md-start" id="showing_page">
                        Showing
                        {!! $data_barang->firstItem() !!} to
                        {!! $data_barang->lastItem() !!} of {!! $data_barang->total() !!} entries
                    </div>
                    <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                        {!! $data_barang->appends(request()->all())->links() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showDescription" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Item Description</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('add_barang_request') }}" id="form_add_barang"
                            enctype="multipart/form-data">
                            @csrf

                            <p id="description"></p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Barang Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('barang/tambah-barang') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Nama Barang</label>
                                <div class="col-sm-8">
                                    <input id="nama_barang" required name="nama_barang" type="text"
                                        class="form-control" placeholder="Masukkan name barang">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Gambar Barang</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" id="gambar_barang" name="gambar_barang"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">Deskripsi Barang</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="deskripsi_barang" required name="deskripsi_barang" rows="3"
                                        placeholder="Masukkan Deskripsi barang"></textarea>
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

        <div class="modal fade" id="modalUpdate" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Edit barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('barang/update_barang') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">barang Name</label>
                                <div class="col-sm-8">
                                    <input id="nama_barang_edit" name="nama_barang_edit" type="text"
                                        class="form-control" placeholder="Insert barang Name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">barang Image</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" id="gambar_barang_edit" name="gambar_barang_edit">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">barang Description</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="deskripsi_barang_edit" name="deskripsi_barang_edit"
                                        placeholder="Insert barang Description" rows="3"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="id_barang" id="id_barang">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDelete" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Delete barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('barang/delete_barang') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <label for="company_name" class="form-label" style="text-transform: uppercase">Are you sure
                                want to delete <span id="name_barang" style="font-weight:bold"></span>?</label>
                            <input type="hidden" name="id_barang_delete" id="id_barang_delete">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Delete
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
            $(document).ready(function() {
                $(document).on('click', '.btnbarang', function() {
                    var barang_id = $(this).val();

                    $('#showDescription').modal('show');

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('item_edit_barang') }}/" + barang_id,
                        success: function(response) {
                            console.log(response)
                            document.getElementById("description").textContent = (response.barang
                                .deskripsi_barang);
                        }
                    })
                })
            });

            // EDIT barang
            $(document).ready(function() {
                $(document).on('click', '.editBtn', function() {
                    var barang_id = $(this).val();
                    console.log(barang_id);

                    $('#modalUpdate').modal('show')

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('item_edit_barang') }}/" + barang_id,
                        success: function(response) {
                            console.log(response)
                            $('#nama_barang_edit').val(response.barang
                                .nama_barang)
                            // $('#gambar_barang_edit').val(response.barang.gambar_barang)
                            $('#deskripsi_barang_edit').val(response.barang
                                .deskripsi_barang)
                            $('#id_barang').val(response.barang.id_barang)
                        }
                    })
                })

            });
            // END EDIT barang

            // DELETE barang
            $(document).ready(function() {
                $(document).on('click', '.deleteBtn', function() {
                    var barang_id = $(this).val();

                    $('#modalDelete').modal('show')

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('item_delete_barang') }}/" + barang_id,
                        success: function(response) {
                            // console.log(response);
                            $('#id_barang_delete').val(response.delete.id_barang)
                            document.getElementById("name_barang").textContent =
                                response.delete
                                .nama_barang;
                        }
                    })
                })

            });
            // END DELETE

            $(document).ready(function() {
                $(".btn_display").click(function() {
                    var id_barang = $(this).val();

                    $.ajax({
                        type: "GET",
                        url: "{{ url('barang_image/') }}/" + id_barang,
                        success: function(data) {
                            $('#id_barang').val(data.barang.id_barang)
                            var get_file = '{{ asset('barang_image') }}/';
                            if (data.barang.gambar_barang == null) {
                                alert('No Receipt Image');
                            } else {
                                var href = get_file + data.barang.gambar_barang;
                                window.open(href);
                            }
                        }
                    });

                })
            });

            var strQuery, strUrlParams, nSortir, nSearch, nPaginatorSelected;

            $(document).ready(function() {
                strQuery = window.location.search;
                strUrlParams = new URLSearchParams(strQuery);
                nSearch = strUrlParams.get('search');
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
