<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\DetailTransaksiModel;
use App\Models\PenggunaModel;
use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }


    public function dashboard(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') != 4) {

            $query = DB::table('hakakses')->get();

            $data_quantity_sold = DetailTransaksiModel::join('transaksi', 'transaksi.IdTransaksi','detail_transaksi.IdTransaksi')
            ->where('StatusTransaksi', 2)->where('JenisTransaksi',0)->get()->sum('TotalBarang');

            $data_quantity_buy = DetailTransaksiModel::join('transaksi', 'transaksi.IdTransaksi','detail_transaksi.IdTransaksi')
            ->where('StatusTransaksi', 2)->where('JenisTransaksi',1)->get()->sum('TotalBarang');

            $data_price_sold = TransaksiModel::where('StatusTransaksi', 2)->where('JenisTransaksi',0)->get()->sum('TotalHargaTransaksi');

            $data_price_buy = TransaksiModel::where('StatusTransaksi', 2)->where('JenisTransaksi',1)->get()->sum('TotalHargaTransaksi');

            $barang = BarangModel::get();
            $total_barang = BarangModel::get()->count();

            $user = PenggunaModel::get()->count();

            return view('Admin.Dashboard.dashboard',  [
                'data_quantity_sold' => $data_quantity_sold,
                'data_quantity_buy' => $data_quantity_buy,
                'data_price_sold' => $data_price_sold,
                'IdAkses' => $request->Session()->get('IdAkses'),
                'data_price_buy' => $data_price_buy,
                'barang' => $barang,
                'total_barang' => $total_barang,
                'user' => $user,

                'title' => 'Dashboard'
            ]);
        } else {
            return redirect('login');
        }
    }

    public function pengguna(Request $request, $id)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') != 4) {

            $query = DB::table('pengguna')->where('pengguna.IdAkses', $id)
                ->select('pengguna.*');

            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            if ($request->search) {
                $query->where('pengguna.NamaDepan', 'like', '%' . $request->search . '%');
            }

            return view('Admin.Pengguna.pengguna',  [
                'IdAkses' => $request->Session()->get('IdAkses'),
                'data_pengguna' => $query->get(),
                'title' => 'List Pengguna',
                'id' => $id,
            ]);
        } else {
            return redirect('login');
        }
    }


    public function tambah_pengguna(Request $request)
    {

        $check_username = PenggunaModel::where('NamaPengguna', $request->NamaPengguna)->first();

        if ($check_username == null) {
            if ($request->IdPengguna != null) {
                $data = PenggunaModel::find($request->IdPengguna);
            } else {
                $data = new PenggunaModel();
            }
            $data->NamaPengguna = $request->NamaPengguna;
            $data->NamaDepan = $request->NamaDepan;
            $data->NamaBelakang = $request->NamaBelakang;
            $data->NoHP = $request->NoHP;
            $data->Alamat = $request->Alamat;
            $data->Password = $request->Password;
            $data->IdAkses = $request->IdAkses;
            $data->save();

            \Session::put('success', 'Success!');
        } else {
            \Session::put('error', 'Username Already Exist!');
        }

        return redirect()->back();
    }


    public function get_item_user($id)
    {

        $user = PenggunaModel::where('IdPengguna', $id)->first();

        return response()->json([
            'status' => 200,
            'data' => $user,
        ]);
    }

    public function hapus_pengguna(Request $request)
    {

        $user = PenggunaModel::where('IdPengguna', $request->IdPengguna_delete)->forceDelete();

        \Session::put('success', 'Berhasil Hapus Data!');
        return redirect()->back();
    }
}
