<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class RegisterController extends Controller
{
    // membuat function index untuk menampilkan halaman register
    public function index()
    {
        // return view berfungsi untuk menampilkan halaman register
        return view('pages.auth.register');
    }

    public function store(Request $request)
    {
        // menyimpan semua request
        $data = $request->all();

        // mengubah inputan password menjadi random
        $data['password'] = bcrypt($request->password);

        // membuat data
        $user = User::create($data);

        // memeberikan role user
        $user->assignRole('user');

        // menampilkan alert
        Swal::toast('Register berhasil silakan login', 'Succes');

        return redirect()->route('login');
    }

}
