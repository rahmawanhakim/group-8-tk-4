@extends('Admin.template')
@section('pengguna')
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
                <li class="breadcrumb-item {{ $title == 'Card' ? 'active' : '' }}">
                    <a href="{{ url('tipe-posisi') }}">Tipe Posisi</a>
                </li>
                <li class="breadcrumb-item {{ $title == 'Card' ? 'active' : '' }}">
                    <a href="{{ url('pengguna/1') }}">Pengguna</a>
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
                    <button class="btn btn-outline-primary ms-2 me-4" type="submit">Search</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                        Add New
                    </button>
                </form>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name Pengguna</th>
                                <th>Posisi</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Pengguna Ditambah Oleh</th>
                                <th>Tanggal Pengguna Ditambah</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($data_pengguna != null)
                                <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $no = $limit * $page - $limit; ?>

                                @foreach ($data_pengguna as $item)
                                    <tr style="text-align: left;">
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $item->nama_pengguna }}</td>
                                        <td>
                                            @if ($item->id_tipe_posisi == 1)
                                                Admin
                                            @else
                                                Customer
                                            @endif
                                        </td>
                                        <td>
{{ $item->username }}
                                        </td> 
                                        <td>
                                            {{ $item->password }}
                                        </td>
                                        <td>{{ $item->add_name }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($item->tanggal_pengguna_ditambah)) }}</td>

                                        <td class="text-center">
                                            <button type="button" class="btn rounded-pill btn-icon btn-danger btn_delete"
                                                data-bs-toggle="modal" data-bs-target="#modalDelete"
                                                data-id="{{ $item->id_pengguna }}">
                                                <span class="fas fa-trash-alt"></span>
                                            </button>
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
                    <div class="col-md-1 d-flex flex-column">
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

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalDelete" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Hapus Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hapus-pengguna') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" value="" id="id_pengguna" name="id_pengguna">
                        <label class="form-label" style="text-transform: uppercase">Apakah anda yakin ingin menghapus data
                            ini ?</label>
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

    <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambah-pengguna') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Nama Pengguna</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" id="nama_pengguna"
                                            name="nama_pengguna">
                                        <input type="hidden" id="id_tipe_posisi" name="id_tipe_posisi" value="{{ $id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" id="username"
                                            name="username">
                                        <input type="hidden" id="id_tipe_posisi" name="id_tipe_posisi" value="{{ $id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="password" id="password"
                                            name="password">
                                        <input type="hidden" id="id_tipe_posisi" name="id_tipe_posisi" value="{{ $id }}">
                                    </div>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('#autocomplete_user').autocomplete({
                source: function(request, response) {

                    $.getJSON("{{ url('get-user') }}/" + request.term, function(data) {
                        var items = [];

                        $.each(data, function(key, val) {
                            items.push(val);
                        });
                        $('#id_user').val('');
                        $('#admin-radio').hide();
                        response(items);
                    });
                },
                minLength: 2,
                select: function(request, response) {
                    $('#autocomplete_user').val(response.item.label);
                    $('#id_user').val(response.item.id);
                    $('#admin-radio').show();
                }
            });
        });

        $(".btn_delete").click(function() {
            var id = $(this).data('id');
            $('#id_pengguna').val(id)

        });

        $(".btn_update").click(function() {
            var id = $(this).data('id');
            $('#admin-radio-edit').hide();
            $.ajax({
                type: "GET",
                url: "{{ url('get-item-user') }}/" + id,
                success: function(data) {
                    console.log(data);
                    $('#id_role_user_edit').val(data.data.id_role_user);
                    $('#user_name_edit').val(data.data.user_full_name);
                    if (data.data.id_employee != '') {
                        $('#admin-radio-edit').show();
                    }
                    if (data.data.id_role == '1') {
                        document.getElementById("role_user_edit").checked = true;
                    } else {
                        document.getElementById("role_user_edit2").checked = true;
                    }
                }
            });
        });

        // $(".btn_delete").click(function() {
        //     var id = $(this).data('id');
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ url('get-card') }}/" + id,
        //         success: function(data) {
        //             $('#id_card_delete').val(data.id_card);
        //         }
        //     });
        // });
    </script>
@stop
