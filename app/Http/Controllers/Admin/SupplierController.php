<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function supplier(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('IdAkses') != 4) {

            $query = DB::table('supplier')
                ->select('supplier.*');

            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            if ($request->search) {
                $query->where('supplier.NamaDepan', 'like', '%' . $request->search . '%');
            }

            return view('Admin.Supplier.supplier',  [
                'IdAkses' => $request->Session()->get('IdAkses'),
                'data_supplier' => $query->get(),
                'title' => 'List Supplier',
            ]);
        } else {
            return redirect('login');
        }
    }


    public function tambah_supplier(Request $request)
    {

    
            if ($request->IdSupplier != null) {
                $data = SupplierModel::find($request->IdSupplier);
            } else {
                $data = new SupplierModel();
            }
            $data->NamaSupplier = $request->NamaSupplier;
            $data->NomorTelfonSupplier = $request->NoHP;
            $data->AlamatSupplier = $request->Alamat;
            $data->save();

            \Session::put('success', 'Success!');

        return redirect()->back();
    }


    public function get_item_user($id)
    {

        $user = SupplierModel::where('IdSupplier', $id)->first();

        return response()->json([
            'status' => 200,
            'data' => $user,
        ]);
    }

    public function hapus_supplier(Request $request)
    {

        $user = SupplierModel::where('IdSupplier', $request->IdSupplier_delete)->forceDelete();

        \Session::put('success', 'Berhasil Hapus Data!');
        return redirect()->back();
    }
}
