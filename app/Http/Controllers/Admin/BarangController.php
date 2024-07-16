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
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 1) {

            $search = $request->search;
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            $data_barang = BarangModel::leftjoin('tb_pengguna', 'tb_pengguna.id_pengguna', 'tb_barang.barang_ditambah_oleh')
                ->select('tb_barang.*', 'nama_pengguna');

            if ($search) {
                $data_barang =  $data_barang->where('nama_barang', 'like', '%' . $search . '%');
            }

            // return $data_barang->get();

            return view('Admin.Barang.barang', [
                'title' => 'List Barang',
                'data_barang' => $data_barang->paginate($sortir),
            ]);
        } else {
            return redirect('login');
        }
    }

    public function tambah_stok_barang($id)
    {
        $data_barang = BarangModel::where('id_barang', $id)->first();

        $stock_in = TransaksiModel::join('tb_detail_transaksi', 'tb_detail_transaksi.id_transaksi', 'tb_transaksi.id_transaksi')
            ->where('tb_detail_transaksi.id_barang', $id)
            ->where('jenis_transaksi', 1)
            ->where('status_transaksi', 2)
            ->get()->sum('total_barang');

        $stock_out = TransaksiModel::join('tb_detail_transaksi', 'tb_detail_transaksi.id_transaksi', 'tb_transaksi.id_transaksi')
            ->where('tb_detail_transaksi.id_barang', $id)
            ->where('jenis_transaksi', 0)
            ->get()->sum('total_barang');

        $total_stock = $stock_in - $stock_out;

        return view('Admin.Barang.tambah-stok-barang', [
            'data_barang' => $data_barang,
            'stock_in' => $stock_in,
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
        $data->nama_barang = $request->nama_barang;
        if ($request->hasFile('gambar_barang')) {
            $destination_path = 'gambar_barang/';
            $file_name = date('ymd') . '_';
            $image = $request->file('gambar_barang');
            $name = $file_name . rand(1000, 9999) . $image->getClientOriginalName();
            $image->move($destination_path, $name);
            $data->gambar_barang = $name;
        }
        $data->deskripsi_barang = $request->deskripsi_barang;
        $data->tanggal_barang_ditambah = date('Y-m-d H:i:s');
        // $data->barang_ditambah_oleh = $request->Session()->get('id_pengguna');

        $data->save();
        if ($data) {
            \Session::put('success', 'Tambah Barang Berhasil!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Tambah Barang Gagal!');
            return redirect()->back();
        }
    }

  

    public function delete_beverage(Request $request)
    {
        $data = BarangModel::where('id_barang', $request->id_barang_delete)->forceDelete();

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

    public function harga_barang(Request $request, $id)
    {

        $sortir = 10;

        if ($request->sortir) {
            $sortir = $request->sortir;
        }

        $data_harga_barang = HargaBarangModel::leftjoin('tb_pengguna', 'tb_pengguna.id_pengguna', 'tb_harga_barang.harga_barang_ditambah_oleh')
            ->where('id_barang', $id)
            ->orderBy('id_harga_barang', 'DESC')
            ->paginate($sortir);

        return view('Admin.Barang.harga-barang', [
            'title' => 'Harga Barang',
            'data_harga_barang' => $data_harga_barang,
            'id' => $id,
        ]);
    }



    public function tambah_harga_barang(Request $request)
    {
        $data = new HargaBarangModel;
        $data->harga_barang = str_replace(array('Rp.', '.', ','), "", $request->harga_barang);
        $data->id_barang = $request->id_barang;
        $data->tanggal_harga_barang_ditambah = date('Y-m-d H:i:s');
        $data->harga_barang_ditambah_oleh = 1;
        $data->save();

        if ($data) {
            \Session::put('success', 'Tambah Harga Barang!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Beverage Price Failed!');
            return redirect()->back();
        }
    }

    public function delete_beverage_price(Request $request)
    {
        $data = HargaBarangModel::where('id_barang_price', $request->id_barang_price_delete)->forceDelete();

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
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 1) {
            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;

            $data_beverage_request = TransaksiModel::leftJoin('tb_pengguna', 'tb_pengguna.id_pengguna', 'tb_transaksi.id_pengguna')
                ->where('status_transaksi', 1)
                ->where('jenis_transaksi', 0)
                ->orderBy('tanggal_transaksi_ditambah', 'desc');



            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('nama_pengguna', 'like', '%' . $search . '%');
            }

            return view('Admin.Transaksi.list-transaksi', [
                'title' => 'List Transaksi',
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }

    public function update_barang(Request $request)
    {
        $data = BarangModel::find($request->id_barang);
        $data->nama_barang = $request->nama_barang_edit;
        if ($request->hasFile('gambar_barang_edit')) {
            if ($data->gambar_barang != null) {
                unlink(public_path('gambar_barang/' . $data->gambar_barang));
            }
            $destination_path = 'gambar_barang/';
            $file_name = date('ymd') . '_';
            $image = $request->file('gambar_barang_edit');
            $name = $file_name . rand(1000, 9999) . $image->getClientOriginalName();
            // return $name;
            $image->move($destination_path, $name);
            $data->gambar_barang = $name;
        }
        $data->deskripsi_barang = $request->deskripsi_barang_edit;

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
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 1) {

            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $search = $request->search;

            $data_beverage_request = TransaksiModel::leftJoin('tb_pengguna', 'tb_pengguna.id_pengguna', 'tb_transaksi.id_pengguna')
                ->join('tb_detail_transaksi', 'tb_detail_transaksi.id_transaksi', 'tb_transaksi.id_transaksi')
                ->where('status_transaksi','!=', 1)
                ->groupBy('tb_detail_transaksi.id_transaksi')
                ->orderBy('tanggal_transaksi_ditambah', 'desc');

            if ($search !== null) {
                $data_beverage_request =  $data_beverage_request->where('nama_pengguna', 'like', '%' . $search . '%');
            }

            return view('Admin.Transaksi.history-transaksi', [
                'title' => 'History Transaksi',
                'data_beverage_request' => $data_beverage_request->paginate($sortir),

            ]);
        } else {
            return redirect('login');
        }
    }




    public function ubah_status(Request $request)
    {

        $data = TransaksiModel::find($request->id_transaksi);
        $data->status_transaksi = 2;
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

        $data = TransaksiModel::find($request->id_transaksi);
        $data->status_transaksi = 0;
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
        $data->status_transaksi = 2;
        $data->jenis_transaksi = 1;
        $data->tanggal_transaksi_ditambah = date('Y-m-d H:i:s');
        // $data->beverage_sent_by = $request->Session()->get('id_pengguna');
        $data->id_pengguna = '';
        $data->save();

        $data_detail = new DetailTransaksiModel();
        $data_detail->id_barang = $request->id_barang;
        $data_detail->id_transaksi = $data->id_transaksi;
        $data_detail->harga_barang = str_replace(array('Rp.', '.', ','), "", $request->total_harga);
        $data_detail->total_barang = $request->total_barang;
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
        $data = HargaBarangModel::join('tb_beverage', 'tb_beverage.id_barang', 'tb_beverage_price.id_barang')
            ->where('tb_beverage_price.id_barang', $id)
            ->where('beverage_price_start_date', '<=', date('Y-m-d'))
            ->orderBy('beverage_price_start_date', 'desc')
            ->first();

        return response()->json([
            'status' => 200,
            'beverage_data' => $data,
        ]);
    }


    
}
