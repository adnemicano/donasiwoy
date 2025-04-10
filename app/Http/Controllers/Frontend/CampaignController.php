<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::query();

        // Filter Search
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('story', 'like', '%' . $request->search . '%');
        }

        // Sort by Date
        if ($request->has('sort') && $request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->has('sort') && $request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        // Paginate the results
        $campaigns = $query->paginate(9);

        return view('pages.frontend.campaign.campaign', compact('campaigns'));
    }

    public function latestCampaigns()
    {
        // This method retrieves the latest campaigns for the home page
        $latestCampaigns = Campaign::orderBy('created_at', 'desc')->take(3)->get();
        return $latestCampaigns; // Return latest campaigns
    }

    public function show($slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        // Check if the campaign has ended / expired
        $isExpired = false;
    if ($campaign->end_date && \Carbon\Carbon::parse($campaign->end_date)->isPast()) {
        $isExpired = true;
    }

    return view('pages.frontend.campaign.campaign-detail', compact('campaign', 'isExpired'));
    }
}
