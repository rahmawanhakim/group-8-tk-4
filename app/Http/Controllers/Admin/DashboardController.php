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

}