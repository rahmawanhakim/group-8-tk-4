<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ediis\UserModel;
use App\Models\PenggunaModel;
use App\Models\Role\RoleUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }


    public function tipe_posisi(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 1) {

            $query = DB::table('tb_tipe_posisi')->get();

            return view('Admin.Pengguna.list-tipe-posisi',  [
                'data_tipe_posisi' => $query,
                'title' => 'List Tipe Posisi'
            ]);
        } else {
            return redirect('login');
        }
    }

    public function pengguna(Request $request, $id)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('id_tipe_posisi') == 1) {

            $query = DB::table('tb_pengguna')->join('tb_pengguna as add_by', 'add_by.id_pengguna', 'tb_pengguna.pengguna_ditambah_oleh')
                ->where('tb_pengguna.id_tipe_posisi', $id)
                ->select('tb_pengguna.*', 'add_by.nama_pengguna as add_name');

            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            if ($request->search) {
                $query->where('tb_pengguna.nama_pengguna', 'like', '%' . $request->search . '%');
            }

            return view('Admin.Pengguna.pengguna',  [
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

        $data = new PenggunaModel();
        $data->nama_pengguna = $request->nama_pengguna;
        $data->username = $request->username;
        $data->password = $request->password;
        $data->id_tipe_posisi = $request->id_tipe_posisi;
        $data->tanggal_pengguna_ditambah = date('Y-m-d H:i:s');
        $data->pengguna_ditambah_oleh = $request->Session()->get('id_pengguna');

        $data->save();

        \Session::put('success', 'Add New User Success!');

        return redirect()->back();
    }


    public function get_item_user($id)
    {

        $user = PenggunaModel::where('id_pengguna', $id)
            ->first();

        return response()->json([
            'status' => 200,
            'data' => $user,
        ]);
    }

    public function hapus_pengguna(Request $request)
    {

        $user = PenggunaModel::where('id_pengguna', $request->id_pengguna)->forceDelete();

        \Session::put('success', 'Berhasil Hapus Data!');
        return redirect()->back();
    }

   
}
