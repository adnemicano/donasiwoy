<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    }
}
