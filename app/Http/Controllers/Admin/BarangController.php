<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HargaBarangModel;
use App\Models\BarangModel;
use App\Models\DetailTransaksiModel;
use App\Models\TransaksiModel;

class BarangController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function barang(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') != 4) {

            $search = $request->search;
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            $data_barang = BarangModel::where('NamaBarang', '!=', null);

            if ($search) {
                $data_barang =  $data_barang->where('NamaBarang', 'like', '%' . $search . '%');
            }

            // return $data_barang->get();

            return view('Admin.Barang.barang', [
                'title' => 'List Barang',
                'IdAkses' => $request->Session()->get('IdAkses'),
                'data_barang' => $data_barang->paginate($sortir),
            ]);
        } else {
            return redirect('login');
        }
    }

    public function tambah_stok_barang(Request $request, $id)
    {
        $data_barang = BarangModel::where('IdBarang', $id)->first();

        $stock_in = TransaksiModel::join('detail_transaksi', 'detail_transaksi.IdTransaksi', 'transaksi.IdTransaksi')
            ->where('detail_transaksi.IdBarang', $id)
            ->where('JenisTransaksi', 1)
            ->where('StatusTransaksi', 2)
            ->get()->sum('TotalBarang');

        $stock_out = TransaksiModel::join('detail_transaksi', 'detail_transaksi.IdTransaksi', 'transaksi.IdTransaksi')
            ->where('detail_transaksi.IdBarang', $id)
            ->where('JenisTransaksi', 0)
            ->get()->sum('TotalBarang');

        $total_stock = $stock_in - $stock_out;

        return view('Admin.Barang.tambah-stok-barang', [
            'data_barang' => $data_barang,
            'stock_in' => $stock_in,
            'IdAkses' => $request->Session()->get('IdAkses'),
            'stock_out' => $stock_out,
            'total_stock' => $total_stock,
            'title' => 'Tambah Stok Barang',
            'id' => $id
        ]);
    }

    public function beverage_image($id)
    {
        $data = BarangModel::find($id);

        return response()->json([
            'status' => 200,
            'beverage' => $data,
        ]);
    }

    public function tambah_barang(Request $request)
    {
        $data = new BarangModel;
        $data->NamaBarang = $request->NamaBarang;
        if ($request->hasFile('GambarBarang')) {
            $destination_path = 'gambar_barang/';
            $file_name = date('ymd') . '_';
            $image = $request->file('GambarBarang');
            $name = $file_name . rand(1000, 9999) . $image->getClientOriginalName();
            $image->move($destination_path, $name);
            $data->GambarBarang = $name;
        }
        $data->Keterangan = $request->Keterangan;
        $data->SatuanBarang = $request->SatuanBarang;
        $data->HargaBarang = $request->HargaBarang;
        // $data->barang_ditambah_oleh = $request->Session()->get('IdPengguna');

        $data->save();
        if ($data) {
            \Session::put('success', 'Tambah Barang Berhasil!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Tambah Barang Gagal!');
            return redirect()->back();
        }
    }



    public function delete_barang(Request $request)
    {
        $data = BarangModel::where('IdBarang', $request->IdBarang_delete)->forceDelete();

        if ($data) {
            \Session::put('success', 'Delete Barang Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Delete Barang Failed!');
            return redirect()->back();
        }
    }

    public function item_edit_barang($id)
    {

        $data = BarangModel::find($id);

        return response()->json([
            'status' => 200,
            'barang' => $data,
        ]);
    }

    public function HargaBarang(Request $request, $id)
    {

        $sortir = 10;

        if ($request->sortir) {
            $sortir = $request->sortir;
        }

        $data_HargaBarang = HargaBarangModel::leftjoin('pengguna', 'pengguna.IdPengguna', 'HargaBarang.HargaBarang_ditambah_oleh')
            ->where('IdBarang', $id)
            ->orderBy('IdHargaBarang', 'DESC')
            ->paginate($sortir);

        return view('Admin.Barang.harga-barang', [
            'title' => 'Harga Barang',
            'IdAkses' => $request->Session()->get('IdAkses'),
            'data_HargaBarang' => $data_HargaBarang,
            'id' => $id,
        ]);
    }


    public function delete_beverage_price(Request $request)
    {
        $data = HargaBarangModel::where('IdBarang_price', $request->IdBarang_price_delete)->forceDelete();

        if ($data) {
            \Session::put('success', 'Hapu Harga Barang Sukses!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Delete Beverage Price Failed!');
            return redirect()->back();
        }
    }


    public function item_delete_beverage(Request $request, $id)
    {
        $data = BarangModel::find($id);

        return response()->json([
            'status' => 200,
            'delete' => $data,
        ]);
    }

    public function item_edit_beverage($id)
    {

        $data = BarangModel::find($id);

        return response()->json([
            'status' => 200,
            'beverage' => $data,
        ]);
    }

    public function item_edit_beverage_price($id)
    {
        $data = HargaBarangModel::find($id);

        return response()->json([
            'status' => 200,
            'beverage_price' => $data,
        ]);
    }
    public function item_delete_beverage_price($id)
    {
        $data = HargaBarangModel::find($id);

        return response()->json([
            'status' => 200,
            'delete' => $data,
        ]);
    }

    public function list_transaksi(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') != 4) {
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;

            $data_beverage_request = TransaksiModel::leftJoin('pengguna', 'pengguna.IdPengguna', 'transaksi.IdPengguna')
                ->where('StatusTransaksi', 1)
                ->where('JenisTransaksi', 0)
                ->orderBy('TanggalTransaksiDitambah', 'desc');



            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('NamaPengguna', 'like', '%' . $search . '%');
            }

            return view('Admin.Transaksi.list-transaksi', [
                'IdAkses' => $request->Session()->get('IdAkses'),
                'title' => 'List Transaksi',
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }

    public function update_barang(Request $request)
    {
        $data = BarangModel::find($request->IdBarang);
        $data->NamaBarang = $request->NamaBarang_edit;
        if ($request->hasFile('GambarBarang_edit')) {
            if ($data->GambarBarang != null) {
                unlink(public_path('gambar_barang/' . $data->GambarBarang));
            }
            $destination_path = 'gambar_barang/';
            $file_name = date('ymd') . '_';
            $image = $request->file('GambarBarang_edit');
            $name = $file_name . rand(1000, 9999) . $image->getClientOriginalName();
            // return $name;
            $image->move($destination_path, $name);
            $data->GambarBarang = $name;
        }
        $data->Keterangan = $request->Keterangan_edit;
        $data->SatuanBarang = $request->SatuanBarang_edit;
        $data->HargaBarang = $request->HargaBarang_edit;


        $data->save();
        if ($data) {
            \Session::put('success', 'Update Barang Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Update beverage Failed!');
            return redirect()->back();
        }
    }


    public function history_transaksi(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') != 4) {

            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;

            $data_beverage_request = TransaksiModel::leftJoin('pengguna', 'pengguna.IdPengguna', 'transaksi.IdPengguna')
                ->leftJoin('supplier', 'supplier.IdSupplier', 'transaksi.IdSupplier')
                ->join('detail_transaksi', 'detail_transaksi.IdTransaksi', 'transaksi.IdTransaksi')
                ->where('StatusTransaksi', '!=', 1)
                ->groupBy('detail_transaksi.IdTransaksi')
                ->orderBy('TanggalTransaksiDitambah', 'desc');

            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('NamaPengguna', 'like', '%' . $search . '%');
            }

            return view('Admin.Transaksi.history-transaksi', [
                'IdAkses' => $request->Session()->get('IdAkses'),
                'title' => 'History Transaksi',
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }




    public function ubah_status(Request $request)
    {

        $data = TransaksiModel::find($request->IdTransaksi);
        $data->StatusTransaksi = 2;
        $data->save();

        if ($data) {
            \Session::put('success', 'Berhasil ganti status!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Gagal!');
            return redirect()->back();
        }
    }


    public function hapus_transaksi(Request $request)
    {

        $data = TransaksiModel::find($request->IdTransaksi);
        $data->StatusTransaksi = 0;
        $data->save();


        if ($data) {
            \Session::put('success', 'Transaksi Telah Dibatalkan!');
            return redirect()->back();
        } else {
            \Session::put('error', 'gagal!');
            return redirect()->back();
        }
    }


    public function tambah_transaksi_stok_barang(Request $request)
    {
        $data = new TransaksiModel();
        $data->StatusTransaksi = 2;
        $data->JenisTransaksi = 1;
        $data->TanggalTransaksiDitambah = date('Y-m-d H:i:s');
        $data->TransaksiDitambahOleh = $request->Session()->get('IdPengguna');
        $data->IdSupplier = $request->IdSupplier;
        $data->TotalHargaTransaksi = str_replace(array('Rp.', '.', ','), "", $request->TotalHarga);
        $data->IdPengguna = '';
        $data->save();

        $data_detail = new DetailTransaksiModel();
        $data_detail->IdBarang = $request->IdBarang;
        $data_detail->IdTransaksi = $data->IdTransaksi;
        $data_detail->HargaBarang = str_replace(array('Rp.', '.', ','), "", $request->TotalHarga);
        $data_detail->TotalBarang = $request->TotalBarang;
        $data_detail->save();

        if ($data && $data_detail) {
            \Session::put('success', 'Stok Barang Telah Ditambah!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Stok Barang Gagal Ditambah!');
            return redirect()->back();
        }
    }

    public function item_beverage_select(Request $request, $id)
    {
        $data = HargaBarangModel::join('beverage', 'beverage.IdBarang', 'beverage_price.IdBarang')
            ->where('beverage_price.IdBarang', $id)
            ->where('beverage_price_start_date', '<=', date('Y-m-d'))
            ->orderBy('beverage_price_start_date', 'desc')
            ->first();

        return response()->json([
            'status' => 200,
            'beverage_data' => $data,
        ]);
    }
}
