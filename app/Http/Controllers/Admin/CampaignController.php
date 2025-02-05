<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert as Swal;

// fungsi sebuah controller adalah untuk membuat logic dari aplikasi
class CampaignController extends Controller
{
    /**
     * menampilkan halaman utama/data campaign
     */
    public function index()
    {
        $campaigns = Campaign::all();

        return view('pages.admin.campaign.index', compact('campaigns'));
    }

    /**
     * menampilkan halaman untuk membuat campaign baru.
     */
    public function create()
    {
        // return view berfungsi untuk menentukan view apa yang akan ditampilkan
        return view('pages.admin.campaign.create');
    }

    /**
     * menyimpan data campaign baru
     */
    public function store(Request $request)
    {
        // $request->all() berfungsi untuk mengambil semua data yang dikirimkan melalui form
        $data = $request->all();
        $data['thumbnail'] = $request->file('thumbnail')->store('assets/campaign', 'public');
        $data['slug'] = Str::slug($request->title);

        // Campaign::create berfungsi untuk menyimpan data ke database
        Campaign::create($data);

        // redirect()->route berfungsi untuk mengarahkan ke route tertentu
        return redirect()->route('admin.campaigns.index');
    }

    /**
     * menampilkan halaman untuk menampilkan detail campaign
     */
    public function show(string $id)
    {
        //
    }

    /**
     * menampilkan halaman untuk mengedit campaign
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * menyimpan perubhaan data campaign
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * menghapus data campaign
     */
    public function destroy(string $id)
    {
        // cari data campaign berdasarkan id
        $campaign = Campaign::findOrFail($id);

        // hapus data campaign
        $campaign->delete();

        // tampilkan alert bahwa data campaign berhasil dihapus
        Swal::toast('Campaign berhasil dihapus', 'Succes');

        // redirect ke halaman campaign
        return redirect()->route('admin.campaigns.index');
    }
}
