<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class CampaignController extends Controller
{
    /**
     * Menampilkan halaman utama/data campaign.
     */
    public function index()
    {
        $campaigns = Campaign::all();
        return view('pages.admin.campaign.index', compact('campaigns'));
    }
    
    /**
     * Menampilkan halaman untuk membuat campaign baru.
     */
    public function create()
    {
        return view('pages.admin.campaign.create');
    }

    /**
     * Menyimpan data campaign baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'story' => 'required|string',
            'target' => 'required|numeric|min:1|max:9223372036854775807',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'end_date' => 'required|date'
        ]);

        $data = $request->all();
        $data['thumbnail'] = $request->file('thumbnail')->store('assets/campaign', 'public');
        $data['slug'] = Str::slug($request->title);

        Campaign::create($data);

        Swal::toast('Campaign berhasil ditambahkan', 'success');
        return redirect()->route('admin.campaigns.index');
    }

    /**
     * Menampilkan halaman untuk mengedit campaign.
     */
    public function edit(string $id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('pages.admin.campaign.edit', compact('campaign'));
    }

    /**
     * Menyimpan perubahan data campaign.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'story' => 'required|string',
            'target' => 'required|numeric|min:1|max:9223372036854775807',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'end_date' => 'required|date'
        ]);

        $campaign = Campaign::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            if ($campaign->thumbnail) {
                Storage::disk('public')->delete($campaign->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('assets/campaign', 'public');
        }

        $campaign->update($data);

        Swal::toast('Campaign berhasil diperbarui', 'success');
        return redirect()->route('admin.campaigns.index');
    }

    /**
     * Menghapus data campaign.
     */
    public function destroy(string $id)
    {
        $campaign = Campaign::findOrFail($id);

        if ($campaign->thumbnail) {
            Storage::disk('public')->delete($campaign->thumbnail);
        }

        $campaign->delete();

        Swal::toast('Campaign berhasil dihapus', 'success');
        return redirect()->route('admin.campaigns.index');
    }
}
