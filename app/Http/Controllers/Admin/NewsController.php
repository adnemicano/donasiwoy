<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert as Swal;
use Illuminate\Support\Facades\Storage;


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
        $news = News::findOrFail($id);
        return view('pages.admin.news.edit', compact('news'));//
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validasi input dari request
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Cari news berdasarkan ID
    $news = News::findOrFail($id);

    // Ambil semua data dari request
    $data = $request->all();

    // Perbarui slug berdasarkan title baru
    $data['slug'] = Str::slug($request->title);

    // Jika ada file thumbnail baru, simpan dan hapus yang lama
    if ($request->hasFile('thumbnail')) {
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        $data['thumbnail'] = $request->file('thumbnail')->store('assets/news', 'public');
    }

    // Perbarui data news
    $news->update($data);

    // Tampilkan alert sukses
    Swal::toast('News berhasil diperbarui', 'success');

    // Redirect ke halaman daftar news
    return redirect()->route('admin.news.index');
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
