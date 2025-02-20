<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert as Swal;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return view('pages.admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->all() berfungsi untuk mengambil semua data yang dikirimkan melalui form
        $data = $request->all();
        $data['thumbnail'] = $request->file('thumbnail')->store('assets/campaign', 'public');
        $data['slug'] = Str::slug($request->title);

        // Campaign::create berfungsi untuk menyimpan data ke database
        News::create($data);

        // redirect()->route berfungsi untuk mengarahkan ke route tertentu
        return redirect()->route('admin.news.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // cari data news berdasarkan id
        $news = News::findOrFail($id);

        // hapus data news
        $news->delete();

        Swal::toast('News berhasil dihapus', 'Succes');

        // redirect ke halaman news
        return redirect()->route('admin.news.index');
    }
}
