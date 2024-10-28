@extends('Admin.template')
@section('list-tipe-posisi')
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
                <li class="breadcrumb-item {{ $title == 'List Tipe Posisi' ? 'active' : '' }}">
                    <a href="{{ url('tipe-posisi') }}">List Tipe Posisi</a>
                </li>
            </ol>
        </nav>
        <div class="card">
            <h5 class="card-header">{{ $title }} </h5>
            <div class="card-body">
                <form class="d-flex mb-4" method="GET" id="search_form">
                    <input class="form-control" style="width: 50%;" type="search" name="search" placeholder="Search"
                        value="{{ request('search') }}" aria-label="Search">
                    <input type="hidden" name="sortir" id="sortir" value="{{ request('sortir') }}">
                    <button class="btn btn-outline-primary ms-2 me-4" type="submit">Search</button>

                </form>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Akses</th>
                                <th>Keterangan</th>
                                <th>Total Pengguna</th> 
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($data_hakakses != null)
                                <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $no = $limit * $page - $limit; ?>

                                @foreach ($data_hakakses as $item)

                                <?php
                                $total = DB::table('pengguna')->where('IdAkses', $item->IdAkses)->get()->count();
                                ?>
                                    <tr style="text-align: left;">
                                        <td>{{ ++$no }}</td>
                                        <td><a href="{{ url('pengguna/' . $item->IdAkses) }}">{{ $item->NamaAkses }}</a></td>
                                        <td>
                                            {{ $item->Keterangan }}
                                        </td>
                                        <td>
                                            {{ $total }}
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
            $.ajax({
                type: "GET",
                url: "{{ url('get-item-user') }}/" + id,
                success: function(data) {
                    // console.log(data);
                    $('#Iduser_role_delete').val(data.data.Idrole_user);
                    document.getElementById('user_name').textContent = data.data.user_full_name;
                }
            });
        });

        $(".btn_update").click(function() {
            var id = $(this).data('id');
            $('#admin-radio-edit').hide();
            $.ajax({
                type: "GET",
                url: "{{ url('get-item-user') }}/" + id,
                success: function(data) {
                    console.log(data);
                    $('#Idrole_user_edit').val(data.data.Idrole_user);
                    $('#user_name_edit').val(data.data.user_full_name);
                    if (data.data.Idemployee != '') {
                        $('#admin-radio-edit').show();
                    }
                    if (data.data.Idrole == '1') {
                        document.getElementById("role_user_edit").checked = true;
                    } else {
                        document.getElementById("role_user_edit2").checked = true;
                    }
                }
            });
        });
    </script>
@stop
