<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class LoginController extends Controller
{
    // membuat function index untuk menampilkan halaman register
    public function index()
    {
        // return view berfungsi untuk menampilkan halaman register
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials =  $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            if (auth()-> user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');

        }



        // jika login gagal , maka akan redirect ke halaman login dan menampilkan toast error
        Swal::toast('Email atau password salah', 'error');

        return redirect()->route('login');
    }

    // fungsi logout berfungsi untuk melakukan proses logout
    public function logout()
    {
        auth()->logout();

        // menampilkan toast success
        Swal::toast('Logout berhasil', 'success');

        return redirect()->route('login');
    }
}
