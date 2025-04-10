<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignDonation;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class DonationController extends Controller
{
    /**
     * Display a listing of the donations.
     */
    public function index(Request $request)
    {
        $query = CampaignDonation::with(['campaign', 'user']);

        // Filter by campaign if specified
        if ($request->has('campaign_id') && $request->campaign_id) {
            $query->where('campaign_id', $request->campaign_id);
        }

        // Filter by status if specified
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Order by most recent first
        $donations = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get all campaigns for the filter dropdown
        $campaigns = Campaign::all();

        return view('pages.admin.donation.index', compact('donations', 'campaigns'));
    }

    /**
     * Display the specified donation details.
     */
    public function show($id)
    {
        $donation = CampaignDonation::with(['campaign', 'user'])->findOrFail($id);
        return view('pages.admin.donation.show', compact('donation'));
    }

    /**
     * Update donation status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,waiting,succes,failed',
        ]);

        $donation = CampaignDonation::findOrFail($id);
        $donation->status = $request->status;
        $donation->save();

        Swal::toast('Status donasi berhasil diperbarui', 'success');
        return redirect()->route('admin.donations.show', $id);
    }

    /**
     * Display donations for a specific campaign.
     */
    public function campaignDonations($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);

        $donations = CampaignDonation::with('user')
            ->where('campaign_id', $campaignId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('pages.admin.donation.campaign', compact('donations', 'campaign'));
    }

    /**
     * Generate donation reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $query = CampaignDonation::with(['campaign', 'user'])
            ->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);

        // Filter by status if specified
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $donations = $query->get();

        $totalAmount = $donations->where('status', 'succes')->sum('value');
        $successCount = $donations->where('status', 'succes')->count();
        $pendingCount = $donations->whereIn('status', ['pending', 'waiting'])->count();
        $failedCount = $donations->where('status', 'failed')->count();

        return view('pages.admin.donation.reports', compact(
            'donations',
            'startDate',
            'endDate',
            'totalAmount',
            'successCount',
            'pendingCount',
            'failedCount'
        ));
    }
}
