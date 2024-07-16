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

    public function get_id_user(Request $request)
    {
        $id_customer = $request->Session()->get('id_customer');
        $data_user = DB::table('ediis.tb_user')
            ->select('tb_user.username', 'tb_customer.customer_name', 'tb_customer.customer_owner', 'tb_customer.customer_phone', 'tb_customer.owner_phone', 'tb_customer.customer_email', 'tb_customer.owner_email')
            ->join('tb_customer', 'tb_customer.id_customer', 'tb_user.id_customer')
            ->where('tb_user.id_customer', $id_customer)->first();
        return $data_user;
    }

    public function display_barang(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 2) {
            $id_pengguna = $request->Session()->get('id_pengguna');
            $data = [
                'data_beverage_req' => $this->data_keranjang($id_pengguna),
            ];

            $beverage = BarangModel::join('tb_harga_barang', 'tb_harga_barang.id_barang', 'tb_barang.id_barang')
                ->groupBy('tb_harga_barang.id_barang')
                ->get();


            return view('Pengguna.Request.add-request-beverage', $data, [
                'title' => 'Add Request Beverage',
                'beverage' => $beverage,
                'id_pengguna' => $id_pengguna,
            ]);
        } else {
            return redirect('login');
        }
    }

    public function history_transaksi_customer(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 2) {

            $id_pengguna = $request->Session()->get('id_pengguna');
            $data = [
                'data_beverage_req' => $this->data_keranjang($id_pengguna),
            ];
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;

            $data_beverage_request = TransaksiModel::leftJoin('tb_pengguna', 'tb_pengguna.id_pengguna', 'tb_transaksi.id_pengguna')
                ->join('tb_detail_transaksi', 'tb_detail_transaksi.id_transaksi', 'tb_transaksi.id_transaksi')
                ->where('status_transaksi','!=', 1)
                ->where('tb_transaksi.id_pengguna',  $request->Session()->get('id_pengguna'))
                ->groupBy('tb_detail_transaksi.id_transaksi')
                ->orderBy('tanggal_transaksi_ditambah', 'desc');


            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('nama_pengguna', 'like', '%' . $search . '%');
            }

            return view('Pengguna.Transaksi.history-transaksi', $data, [
                'title' => 'History Transaksi',
                'id_pengguna' => $id_pengguna,
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }
  

    public function list_transaksi_customer(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 2) {
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;
            $id_pengguna = $request->Session()->get('id_pengguna');
            $data = [
                'data_beverage_req' => $this->data_keranjang($id_pengguna),
            ];

            $data_beverage_request = TransaksiModel::leftJoin('tb_pengguna', 'tb_pengguna.id_pengguna', 'tb_transaksi.id_pengguna')
                ->where('status_transaksi', 1)
                ->where('jenis_transaksi', 0)
                ->where('tb_transaksi.id_pengguna',  $request->Session()->get('id_pengguna'))
                ->orderBy('tanggal_transaksi_ditambah', 'desc');



            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('nama_pengguna', 'like', '%' . $search . '%');
            }

            return view('Pengguna.Transaksi.list-transaksi', $data, [
                'title' => 'List Transaksi',
                'id_pengguna' => $id_pengguna,
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }

    public function data_keranjang($id)
    {
        $data = DetailTransaksiModel::where('id_pengguna', $id)->where('id_transaksi', 0)->get();

        return $data;
    }

    

    public function add_beverage_request(Request $request)
    {

        $id_pengguna = $request->Session()->get('id_pengguna');;
        $check_data = DetailTransaksiModel::where('id_barang', $request->id_barang)
            ->where('id_transaksi', 0)
            ->where('id_pengguna', $id_pengguna)
            ->orderBy('id_detail_transaksi', 'DESC')->first();

        if ($check_data != null) {
            $update = DetailTransaksiModel::find($check_data->id_detail_transaksi);
            $update->harga_barang = $request->harga_barang  + $check_data->harga_barang;
            $update->total_barang = $request->total_barang + $check_data->total_barang;
            $update->save();
        } else {
            $add_req_detail = new DetailTransaksiModel;
            $add_req_detail->total_barang = $request->total_barang;
            $add_req_detail->harga_barang = $request->harga_barang;
            $add_req_detail->id_pengguna = $id_pengguna;
            $add_req_detail->id_barang = $request->id_barang;
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
        $data_req = BeverageRequestModel::find($request->id_req_cancel);
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
        $id_pengguna = $request->Session()->get('id_pengguna');;
        $beverage_detail = $request->id_detail_transaksi;
        $beverage = $request->id_beverage_no;
        $quantity = $request->total_barang;
        $nominal = str_replace(array('Rp.', '.', ',', ' '), "", $request->harga_barang);

        $bv_size = count($beverage);

        // return $nominal;
        $add_req = new TransaksiModel();
        $add_req->tanggal_transaksi_ditambah = date('Y-m-d H:i:s');
        $add_req->transaksi_ditambah_oleh = $id_pengguna;
        $add_req->status_transaksi = 1;
        $add_req->jenis_transaksi = 0;
        $add_req->id_pengguna = $id_pengguna;
        $simpan = $add_req->save();
        for ($i = 0; $i < $bv_size; $i++) {
            $checkout_cart = DetailTransaksiModel::find($beverage_detail[$i]);
            $checkout_cart->id_transaksi = $add_req->id_transaksi;
            $checkout_cart->total_barang = $quantity[$i];
            $checkout_cart->harga_barang = $nominal[$i];
            $simpan = $checkout_cart->save();
        }

        $bev_nominal = DetailTransaksiModel::where('id_transaksi', $add_req->id_transaksi)->get()->sum('harga_barang');

        $edit_nominal = TransaksiModel::find($add_req->id_transaksi);
        $edit_nominal->total_harga_transaksi = $bev_nominal;
        $edit_nominal->save();

        if ($simpan) {
            return redirect('list-transaksi-customer')->with('success', 'Success!');
        } else {
            return redirect()->back()->with('error', 'Failed!');
        }
    }

  
 


    public function item_beverage_request($id)
    {
        $data = BarangModel::join('tb_harga_barang', 'tb_harga_barang.id_barang', 'tb_barang.id_barang')
            ->where('tb_barang.id_barang', $id)
            ->orderBy('tanggal_harga_barang_ditambah', 'DESC')->first();

        return response()->json([
            'status' => 200,
            'beverage' => $data,
        ]);
    }
    public function delete_cart(Request $request)
    {

        $data = DetailTransaksiModel::where('id_detail_transaksi', $request->id_detail_transaksi_delete)->forceDelete();

        return redirect()->back();
    }
}
