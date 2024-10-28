@extends('Pengguna.template-user')
@section('add-request-beverage')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item {{ $title == 'Dashboard User' ? 'active' : '' }}">
                    <a href="{{ url('dashboard-user') }}">Dashboard</a>
                </li>
                <li
                    class="breadcrumb-item {{ $title == 'Request Beverage' ? 'active' : '' || $title == 'History Beverage' }}">
                    <a href="{{ url('customer-user') }}">Request</a>
                </li>
                <li class="breadcrumb-item {{ $title == 'Add Request Beverage' ? 'active' : '' }}">
                    <a href="{{ url('customer-user/add-request') }}">Add Request Beverage</a>
                </li>
            </ol>
        </nav>
       

        <div class="row">
            @foreach ($beverage as $bv)
               
                <div class="col-sm-2 mt-2 mb-2">
                    <button
                        style="border: none; text-decoration: none; display: inline-block; background-color: #ffffff; border-radius: 0.5rem;"
                        class="btn btnBeverage" value="{{ $bv->IdBarang }}">
                        <img src="{{ asset('gambar_barang/' . $bv->GambarBarang) }}" width="160" height="160">
                        <h6 class="card-title mt-2">{{ $bv->NamaBarang }}</h6>
                        <p class="card-text">
                            Rp {{ number_format(ceil($bv->HargaBarang), 0, ',', '.') }}
                        </p>
                        <input type="hidden" id="HargaBarang-{{ $bv->IdBarang }}"
                            value="{{ $bv->HargaBarang }}">
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="detailBeverage" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btnClose btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="beverage-image" width="300" height="300">
                        </div>
                        <div class="col-md-6">
                            
                            <form method="POST" action="{{ route('add_beverage_request') }}" id="form_add_beverage"
                                enctype="multipart/form-data">
                                <div class="mt-4 mb-3">
                                    @csrf
                                    <h5 id="judul_barang" class="text-uppercase"></h5>
                                    <div class="price d-flex flex-row align-items-center"> <span id="price"
                                            class="act-price"></span>
                                        <div class="ml-2">
                                        </div>
                                    </div>
                                </div>
                                <p id="description" style="width: 350px;"></p>
                                <div class="mt-2">
                                    <div class="col-md-6 col-lg-6 col-xl-5 d-flex">
                                        <input type="hidden" id="IdBarang" name="IdBarang">
                                        <input type="hidden" id="HargaBarang" name="HargaBarang">

                                        <input type="hidden" name="type_button" id="type_button">
                                        <button type="button" class="btn btn-link px-2" onclick="getNominalDown()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input id="TotalBarang" min="1" name="TotalBarang" value="0"
                                            type="number" class="form-control text-center form-control-sm"
                                            onkeyup="getNominal()" />
                                        <button type="button" class="btn btn-link px-2" onclick="getNominalUp()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cart mt-4 align-items-center">
                                    <button type="button" class="btnAddToChart btn btn-danger text-uppercase mr-2 px-4">Add
                                        to
                                        cart</button>
                                    <button type="button" class="btnBuyNow btn btn-primary btn-rounded">Buy
                                        Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function getNominal() {
            var quantity = $('#TotalBarang').val();
            console.log(quantity)
            var beverage_id = $('#IdBarang').val();
            var price = $('#HargaBarang-' + beverage_id).val();
            $('#HargaBarang').val(quantity * response.beverage.HargaBarang)

        }

        function getNominalUp() {
            var quantity = $('#TotalBarang').val();
            var beverage_id = $('#IdBarang').val();
            var price = $('#HargaBarang-' + beverage_id).val();
            var newQty = parseInt(quantity) + 1;
            $('#TotalBarang').val(newQty)
            $('#HargaBarang').val(newQty * price)
        }


        $(document).ready(function() {
            $(document).on('click', '.btnBeverage', function() {
                var beverage_id = $(this).val();
                // var quantity = $('#quantity').val();
                // console.log(quantity);

                $('#detailBeverage').modal('show');

                $.ajax({
                    type: 'GET',
                    url: "{{ url('item_beverage_request') }}/" + beverage_id,
                    success: function(response) {
                        document.getElementById("judul_barang").textContent = (response
                            .beverage.NamaBarang);
                        document.getElementById("price").textContent = ('Rp ' + parseInt(
                            response.beverage.HargaBarang).toLocaleString());
                        document.getElementById("description").textContent = (response.beverage
                            .Keterangan);

                        $('#Keterangan_edit').val(response.beverage
                            .Keterangan)
                        $('#IdBarang').val(response.beverage.IdBarang)
                        $('#TotalBarang').val(0)
                        var get_file = '{{ asset('gambar_barang') }}/';
                        document.getElementById("beverage-image").src = get_file + response
                            .beverage.GambarBarang;

                        getNominalUp();
                        console.log(response);
                    }
                })
            })

            $(document).on('click', '.btnAddToChart', function() {
                $('#type_button').val('1');
                $('#form_add_beverage').submit();
            })

            $(document).on('click', '.btnBuyNow', function() {
                $('#type_button').val('2');
                $('#form_add_beverage').submit();

            })
        });

        function getNominalDown() {
            var quantity = $('#TotalBarang').val();
            var beverage_id = $('#IdBarang').val();
            var price = $('#HargaBarang-' + beverage_id).val();
            var newQty = parseInt(quantity) - 1;

            alert(newQty);
            if (quantity != 1) {

                $('#TotalBarang').val(newQty)
                $('#HargaBarang').val(newQty * price)
            }

        }

        $(document).ready(function() {
            $(document).on('click', '.showBeverage', function() {
                var beverage_id = $(this).val();
                $('#detailBeverage').modal('show')

            })
        });

        $(document).ready(function() {
            $('.select_item').select2();

            $("#date_alert").css('display', 'none');
            $("#quantity_alert").css('display', 'none');
            $("#item_alert").css('display', 'none');
        });

        $('#quantity').on('change', function() {
            //GET BEVERAGE TOTAL
            var Idbev = $("#beverage_list").val();
            if (Idbev == '') {
                $("#item_alert").css('display', '')
                document.getElementById("quantity").value = '';
            } else {
                var quantity = $("#quantity").val();
                var price_per_id = $("#price_item").val();
                convert1 = price_per_id.replace("Rp.", " ");
                convert2 = convert1.replace(",", "");
                total_price = (convert2) * quantity;
                var output = parseInt(total_price).toLocaleString();
                document.getElementById("total_nominal").value = 'Rp. ' + output;
            }
        });

        $('#beverage_list').on('change', function() {
            $('#alert_kosong').hide();
            var Idbev = $(this).val();
            var req_date = $("#request_date").val();
            if (req_date == '') {
                $("#date_alert").css('display', '');
                $("#request_date").removeClass('form-control');
                $("#request_date").addClass('border-red');
                document.getElementById("beverage_list").value = '';
            } else {
                var Idbev = $("#beverage_list").val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('get-bev-price') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'req_date': req_date,
                        'Idbev': Idbev,
                    },
                    success: function(data) {
                        $.each(data, function(index, element) {
                            var price_per_item = parseInt(element.HargaBarang)
                                .toLocaleString();
                            document.getElementById("price_item").value = 'Rp. ' +
                                price_per_item;
                            document.getElementById("item_name").value = element.NamaBarang;
                        });
                    }
                });
            }
        });



        var no = 0 + 1;
        $('#add_item').on('click', function() {
            var Idbev = $("#beverage_list").val();
            var item_name = $('#item_name').val();
            var qtt = $("#quantity").val();
            var price = $("#price_item").val();
            var total = $("#total_nominal").val();
            if (Idbev == '' || qtt == '' || total == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill all fields!',
                })
            } else {
                var item = "<div class='row' id='item-" + no + "'>" +
                    "<input type='hidden' name='IdBarang[]' value='" + Idbev + "'>" +
                    "<div class='col-sm-2 mt-2 text-center'>Item " + no + "</div>" +
                    "<div class='col-sm-2 mt-2 text-center'><input class='form-control2' value='" + item_name +
                    "' readonly></div>" +
                    "<div class='col-sm-2 mt-2 text-center'><input class='form-control2' name='beverage_quantity[]' value='" +
                    qtt + "' readonly></div>" +
                    "<div class='col-sm-2 mt-2 text-center'><input class='form-control2' value='" + price +
                    "' readonly></div>" +
                    "<div class='col-sm-2 mt-2 text-center'><input class='form-control2' name='HargaBarang[]' value='" +
                    total + "' readonly></div>" +
                    "<div class='col-sm-2 mt-2 text-center'><a onclick='remove(" + no +
                    ")' class='btn btn-sm rounded-pill btn-icon btn-danger'>" +
                    "<span class='fas fa-minus' style='color:white'></span></a></div> </div"
                $("#place_item").append(item);
                console.log(no);
                no++;
            }
            document.getElementById("price_item").value = '';
            document.getElementById("total_nominal").value = '';
            document.getElementById("quantity").value = '';
            document.getElementById("beverage_list").value = '';
        });

        function remove(p) {
            $("#item-" + p).remove();
        }

        // if (\Session::has('coba')){
        // $('#shopingcart').modal('show');
        // }
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

        @if (\Session::has('coba'))
            $(document).ready(function() {

                $('#shopingcart').modal('show');

            });
        @endif
    </script>
@stop
