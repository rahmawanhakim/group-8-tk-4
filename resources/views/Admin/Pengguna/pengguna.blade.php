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
                    <button type="button" class="btn btn-primary btn_add" data-bs-toggle="modal"
                        data-bs-target="#modalCenter">
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
                                <th>No HP</th>
                                <th>Alamat</th>

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
                                        <td>{{ $item->NamaDepan . ' ' . $item->NamaBelakang }}</td>
                                        <td>
                                            @if ($item->IdAkses == 1)
                                                Admin
                                            @else
                                                Customer
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->NamaPengguna }}
                                        </td>
                                        <td>
                                            {{ $item->Password }}
                                        </td>
                                        <td>
                                            {{ $item->NoHp }}
                                        </td>
                                        <td>
                                            {{ $item->Alamat }}
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="btn rounded-pill btn-icon btn-danger btn_delete"
                                                data-bs-toggle="modal" data-bs-target="#modalDelete"
                                                data-id="{{ $item->IdPengguna }}">
                                                <span class="fas fa-trash-alt"></span>
                                            </button>
                                            <button type="button" class="btn rounded-pill btn-icon btn-warning btn_update"
                                                value="{{ $item->IdPengguna }}" data-bs-toggle="modal"
                                                data-bs-target="#modalCenter" data-id="{{ $item->IdPengguna }}">
                                                <span class="fas fa-edit"></span>
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
                        <input type="hidden" value="" id="IdPengguna_delete" name="IdPengguna_delete">
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

                        <input type="hidden" id="IdPengguna" name="IdPengguna">

                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Nama Depan</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" id="NamaDepan"
                                            name="NamaDepan">
                                        <input type="hidden" id="IdAkses" name="IdAkses"
                                            value="{{ $id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Nama Belakang</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" id="NamaBelakang"
                                            name="NamaBelakang">
                                        <input type="hidden" id="IdAkses" name="IdAkses"
                                            value="{{ $id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">No HP</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="number" id="NoHP"
                                            name="NoHP">
                                        <input type="hidden" id="IdAkses" name="IdAkses"
                                            value="{{ $id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" id="Alamat"
                                            name="Alamat">
                                        <input type="hidden" id="IdAkses" name="IdAkses"
                                            value="{{ $id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" id="NamaPengguna"
                                            name="NamaPengguna">
                                        <input type="hidden" id="IdAkses" name="IdAkses"
                                            value="{{ $id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" id="Password"
                                            name="Password">
                                        <input type="hidden" id="IdAkses" name="IdAkses"
                                            value="{{ $id }}">
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
       
        $(".btn_delete").click(function() {
            var id = $(this).data('id');
            $('#IdPengguna_delete').val(id)

        });

        $(".btn_add").click(function() {
            $('#IdPengguna').val('');
            $('#NamaPengguna').val('');
            $('#NamaDepan').val('');
            $('#NamaBelakang').val('');
            $('#Password').val('');
            $('#NoHP').val('');
            $('#Alamat').val('');

        });

        $(".btn_update").click(function() {
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ url('get-item-user') }}/" + id,
                success: function(data) {
                    console.log(data);
                    $('#IdPengguna').val(data.data.IdPengguna);
                    $('#NamaPengguna').val(data.data.NamaPengguna);
                    $('#NamaDepan').val(data.data.NamaDepan);
                    $('#NamaBelakang').val(data.data.NamaBelakang);
                    $('#Password').val(data.data.Password);
                    $('#NoHP').val(data.data.NoHp);
                    $('#Alamat').val(data.data.Alamat);

                }
            });
        });

    </script>
@stop
