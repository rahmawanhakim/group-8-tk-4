<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\PenggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function login(Request $request)
    {
        if ($request->Session()->get('logged_in') == true && $request->Session()->get('role') == 1) {
            return redirect('dashboard');
        } elseif ($request->Session()->get('logged_in') == true && $request->Session()->get('role') == 2) {
            return redirect('dashboard-user');
        } else {

            return view('Login.login', [
                'title' => 'Login',
            ]);
        }
    }

    public function check_login(Request $request)
    {
        $NamaPengguna = $request->NamaPengguna;
        $password = $request->Password;

        $check_login = PenggunaModel::where('NamaPengguna', $NamaPengguna)->where('Password', $password)->first();

        if ($check_login != null) {
            $request->Session()->put('NamaPengguna', $NamaPengguna);
            $request->Session()->put('IdPengguna', $check_login->IdPengguna);
            $request->Session()->put('logged_in', true);
            $request->Session()->put('IdAkses', $check_login->IdAkses);
            $request->Session()->save();

            if($check_login->IdAkses != 4){
                return redirect('dashboard');

            }else{
                return redirect('list-transaksi-customer');
            }
        } else {
            \Session::put('error', 'You are not registered in system!');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}
