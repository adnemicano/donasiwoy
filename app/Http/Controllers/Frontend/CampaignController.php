<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;


class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::all();

        return view('pages.frontend.campaign', compact('campaigns'));
    }

    public function show($slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        return view('pages.frontend.campaign-detail', compact('campaign'));
    }
}
