<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\Beverage\BeverageRequestModel;
use App\Models\DetailTransaksiModel;
use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RequestController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function get_Iduser(Request $request)
    {
        $Idcustomer = $request->Session()->get('Idcustomer');
        $data_user = DB::table('ediis.user')
            ->select('user.NamaPengguna', 'customer.customer_name', 'customer.customer_owner', 'customer.customer_phone', 'customer.owner_phone', 'customer.customer_email', 'customer.owner_email')
            ->join('customer', 'customer.Idcustomer', 'user.Idcustomer')
            ->where('user.Idcustomer', $Idcustomer)->first();
        return $data_user;
    }

    public function display_barang(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') == 4) {
            $IdPengguna = $request->Session()->get('IdPengguna');
            $data = [
                'data_beverage_req' => $this->data_keranjang($IdPengguna),
            ];

            $beverage = BarangModel::get();


            return view('Pengguna.Request.add-request-beverage', $data, [
                'title' => 'Add Request Beverage',
                'beverage' => $beverage,
                'IdAkses' => $request->Session()->get('IdAkses'),
                'IdPengguna' => $IdPengguna,
            ]);
        } else {
            return redirect('login');
        }
    }

    public function history_transaksi_customer(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') == 4) {

            $IdPengguna = $request->Session()->get('IdPengguna');
            $data = [
                'data_beverage_req' => $this->data_keranjang($IdPengguna),
            ];
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;

            $data_beverage_request = TransaksiModel::leftJoin('pengguna', 'pengguna.IdPengguna', 'transaksi.IdPengguna')
                ->join('detail_transaksi', 'detail_transaksi.IdTransaksi', 'transaksi.IdTransaksi')
                ->where('StatusTransaksi','!=', 1)
                ->where('transaksi.IdPengguna',  $request->Session()->get('IdPengguna'))
                ->groupBy('detail_transaksi.IdTransaksi')
                ->orderBy('TanggalTransaksiDitambah', 'desc');


            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('NamaPengguna', 'like', '%' . $search . '%');
            }

            return view('Pengguna.Transaksi.history-transaksi', $data, [
                'title' => 'History Transaksi',
                'IdAkses' => $request->Session()->get('IdAkses'),
                'IdPengguna' => $IdPengguna,
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }
  

    public function list_transaksi_customer(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') == 4) {
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;
            $IdPengguna = $request->Session()->get('IdPengguna');
            $data = [
                'data_beverage_req' => $this->data_keranjang($IdPengguna),
            ];

            $data_beverage_request = TransaksiModel::leftJoin('pengguna', 'pengguna.IdPengguna', 'transaksi.IdPengguna')
                ->where('StatusTransaksi', 1)
                ->where('JenisTransaksi', 0)
                ->where('transaksi.IdPengguna',  $request->Session()->get('IdPengguna'))
                ->orderBy('TanggalTransaksiDitambah', 'desc');



            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('NamaPengguna', 'like', '%' . $search . '%');
            }

            return view('Pengguna.Transaksi.list-transaksi', $data, [
                'IdAkses' => $request->Session()->get('IdAkses'),
                'title' => 'List Transaksi',
                'IdPengguna' => $IdPengguna,
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }

    public function data_keranjang($id)
    {
        $data = DetailTransaksiModel::where('IdPengguna', $id)->where('IdTransaksi', 0)->get();

        return $data;
    }

    

    public function add_beverage_request(Request $request)
    {

        $IdPengguna = $request->Session()->get('IdPengguna');;
        $check_data = DetailTransaksiModel::where('IdBarang', $request->IdBarang)
            ->where('IdTransaksi', 0)
            ->where('IdPengguna', $IdPengguna)
            ->orderBy('IdDetailTransaksi', 'DESC')->first();

        if ($check_data != null) {
            $update = DetailTransaksiModel::find($check_data->IdDetailTransaksi);
            $update->HargaBarang = $request->HargaBarang  + $check_data->HargaBarang;
            $update->TotalBarang = $request->TotalBarang + $check_data->TotalBarang;
            $update->save();
        } else {
            $add_req_detail = new DetailTransaksiModel;
            $add_req_detail->TotalBarang = $request->TotalBarang;
            $add_req_detail->HargaBarang = $request->HargaBarang;
            $add_req_detail->IdPengguna = $IdPengguna;
            $add_req_detail->IdBarang = $request->IdBarang;
            $add_req_detail->save();
        }

        if ($request->type_button == 1) {
            \Session::put('success', 'Add to cart success!');
            return redirect()->back();
        } else {
            \Session::put('coba', 'Cancel Request failed!');
            return redirect()->back();
        }
    }

    public function cancel_request(Request $request)
    {
        $data_req = BeverageRequestModel::find($request->Idreq_cancel);
        $data_req->beverage_status = 0;

        $save = $data_req->save();

        if ($save) {
            \Session::put('success', 'Cancel Request Success!');
        } else {
            \Session::put('error', 'Cancel Request failed!');
        }
        return redirect()->back();
    }

    public function checkout_beverage(Request $request)
    {
        $IdPengguna = $request->Session()->get('IdPengguna');;
        $beverage_detail = $request->IdDetailTransaksi;
        $beverage = $request->Idbeverage_no;
        $quantity = $request->TotalBarang;
        $nominal = str_replace(array('Rp.', '.', ',', ' '), "", $request->HargaBarang);

        $bv_size = count($beverage);

        // return $nominal;
        $add_req = new TransaksiModel();
        $add_req->TanggalTransaksiDitambah = date('Y-m-d H:i:s');
        $add_req->TransaksiDitambahOleh = $IdPengguna;
        $add_req->StatusTransaksi = 1;
        $add_req->JenisTransaksi = 0;
        $add_req->IdPengguna = $IdPengguna;
        $simpan = $add_req->save();
        for ($i = 0; $i < $bv_size; $i++) {
            $checkout_cart = DetailTransaksiModel::find($beverage_detail[$i]);
            $checkout_cart->IdTransaksi = $add_req->IdTransaksi;
            $checkout_cart->TotalBarang = $quantity[$i];
            $checkout_cart->HargaBarang = $nominal[$i];
            $simpan = $checkout_cart->save();
        }

        $bev_nominal = DetailTransaksiModel::where('IdTransaksi', $add_req->IdTransaksi)->get()->sum('HargaBarang');

        $edit_nominal = TransaksiModel::find($add_req->IdTransaksi);
        $edit_nominal->TotalHargaTransaksi = $bev_nominal;
        $edit_nominal->save();

        if ($simpan) {
            return redirect('list-transaksi-customer')->with('success', 'Success!');
        } else {
            return redirect()->back()->with('error', 'Failed!');
        }
    }


    public function item_beverage_request($id)
    {
        $data = BarangModel::where('barang.IdBarang', $id)->first();

        return response()->json([
            'status' => 200,
            'beverage' => $data,
        ]);
    }
    public function delete_cart(Request $request)
    {

        $data = DetailTransaksiModel::where('IdDetailTransaksi', $request->IdDetailTransaksi_delete)->forceDelete();

        return redirect()->back();
    }
}
