<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignDonation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total donations amount (only successful ones)
        $totalDonations = CampaignDonation::where('status', 'succes')->sum('value');

        // Get total number of campaigns
        $totalCampaigns = Campaign::count();

        // Get total number of unique donors
        $totalDonors = CampaignDonation::where('status', 'succes')
            ->distinct('user_id')
            ->count('user_id');

        // Get total number of donations
        $totalTransactions = CampaignDonation::where('status', 'succes')->count();

        // Get recent donations for quick view
        $recentDonations = CampaignDonation::with(['campaign', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get donation statistics by month for the chart
        $monthlyStats = CampaignDonation::where('status', 'succes')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(value) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Format data for chart
        $chartData = [];
        $chartLabels = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = date('F', mktime(0, 0, 0, $i, 1));
            $chartData[] = $monthlyStats[$i] ?? 0;
        }

        return view('pages.admin.dashboard', compact(
            'totalDonations',
            'totalCampaigns',
            'totalDonors',
            'totalTransactions',
            'recentDonations',
            'chartData',
            'chartLabels'
        ));
    }
}
