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

    public function login_v()
    {
        return view('Login.loginv2', [
            'title' => 'Login V2',
        ]);
    }

    public function check_login_v2(Request $request)
    {
        $username = $request->username;
        $domain = '@jic.ac.id';
        $account2 = $username . $domain;

        $employee = DB::table('tb_role_user')
            ->join('ediis.tb_user', 'tb_user.id_user', 'tb_role_user.id_user')
            ->join('db_hr.tb_employee', 'tb_employee.id_employee', 'ediis.tb_user.id_employee')
            ->where('username', $username)
            ->first();

        if ($employee != null) {
            session_start();
            $request->Session()->put('username', $username);
            $request->Session()->put('id_user', $employee->id_user);
            $request->Session()->put('id_employee', $employee->id_employee);
            $request->Session()->put('logged_in', true);
            $request->Session()->put('role', $employee->id_role);
            $request->Session()->save();
            return redirect('dashboard');
        } else {
            \Session::put('error', 'Invalid Login!');
            return redirect('login/');
        }
    }

    public function check_login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $check_login = PenggunaModel::where('username', $username)->where('password', $password)->first();

        if ($check_login != null) {
            $request->Session()->put('username', $username);
            $request->Session()->put('id_pengguna', $check_login->id_pengguna);
            $request->Session()->put('logged_in', true);
            $request->Session()->put('id_tipe_posisi', $check_login->id_tipe_posisi);
            $request->Session()->save();

            if($check_login->id_tipe_posisi == 1){
                return redirect('list-transaksi');

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
        return redirect('/');
    }
}
