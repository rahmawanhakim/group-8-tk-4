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


    public function hakakses(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') != 4) {

            $query = DB::table('hakakses')->get();

            return view('Admin.Pengguna.list-tipe-posisi',  [
                'data_hakakses' => $query,
                'IdAkses' => $request->Session()->get('IdAkses'),
                'title' => 'List Tipe Posisi'
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
                'data_pengguna' => $query->get(),
                'IdAkses' => $request->Session()->get('IdAkses'),
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
