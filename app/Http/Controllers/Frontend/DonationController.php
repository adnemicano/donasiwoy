<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampaignDonation;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'donation' => 'required|numeric|min:1000',
            'campaign_id' => 'required|integer',
        ]);

        // Check if campaign is expired
        $campaign = Campaign::findOrFail($request->campaign_id);
        if ($campaign->end_date && Carbon::parse($campaign->end_date)->isPast()) {
            return redirect()->back()->with('error', 'Maaf, kampanye ini telah berakhir dan tidak lagi menerima donasi.');
        }

        // Create pending donation first
        $donation = CampaignDonation::create([
            'campaign_id' => $request->campaign_id,
            'user_id' => Auth::id(),
            'value' => $request->donation,
            'status' => 'waiting',
            'is_anonymous' => false, // Default value, can be updated later
        ]);

        return redirect()->route('donation.details', $donation->id);
    }

    public function details($id)
    {
        $donation = CampaignDonation::with('campaign', 'user')->findOrFail($id);

        // Only allow the donor to access this page
        if ($donation->user_id != Auth::id()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Check if donation is already paid
        if (in_array($donation->status, ['succes', 'settlement'])) {
            return redirect()->route('donation.status', $donation->id);
        }

        return view('pages.frontend.campaign.donation-details', compact('donation'));
    }

    public function processPayment(Request $request, $id)
    {
        $donation = CampaignDonation::findOrFail($id);

        // Update donation with payment details
        $donation->update([
            'donor_name' => $request->donor_name,
            'message' => $request->donation_message,
            'is_anonymous' => $request->has('is_anonymous'),
            'payment_method' => $request->payment_method ?? '',
            'status' => 'pending'
        ]);

        // Initialize Midtrans
        \Midtrans\Config::$serverKey = 'SB-Mid-server-T3gY-2QeGFFOi_pwPW5Isb9-';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'DON-' . time() . '-' . $donation->id;

        // Save order_id to donation
        $donation->update(['transaction_id' => $orderId]);

        // Create transaction parameters for Midtrans
        $customer = [
            'first_name' => $donation->user->name ?? 'Anonim',
            'email' => $donation->user->email ?? 'anonymous@example.com',
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $donation->value,
            ],
            'customer_details' => $customer,
            'expiry' => [
                'unit' => 'hour',
                'duration' => 24,
            ]
        ];

        // Get Snap Payment Page URL
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $donation->update(['snap_token' => $snapToken]);

        return redirect()->route('donation.status', $donation->id);
    }

    public function status($id)
    {
        $donation = CampaignDonation::with('campaign', 'user')->findOrFail($id);

        // Only allow the donor to access this page
        if ($donation->user_id != Auth::id()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('pages.frontend.campaign.donation-status', compact('donation'));
    }

    public function checkStatus($id)
    {
        $donation = CampaignDonation::findOrFail($id);

        // Only allow the donor to access this API
        if ($donation->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // For donations with transaction ID, check status with Midtrans
        if ($donation->transaction_id && $donation->status == 'pending') {
            try {
                \Midtrans\Config::$serverKey = 'SB-Mid-server-T3gY-2QeGFFOi_pwPW5Isb9-';
                \Midtrans\Config::$isProduction = false;

                $status = \Midtrans\Transaction::status($donation->transaction_id);

                // Update donation status based on Midtrans response
                if ($status && isset($status->transaction_status)) {
                    $donation->update(['status' => $status->transaction_status]);
                }
            } catch (\Exception $e) {
                // Keep existing status if error occurs
            }
        }

        // Return current status for AJAX polling
        return response()->json([
            'status' => $donation->status,
            'updated_at' => $donation->updated_at->diffForHumans()
        ]);
    }

    public function confirmDonation(Request $request)
{
    $data = $request->validate([
        'transaction_id' => 'required|string',
        'order_id' => 'required|string',
        'status' => 'required|string',
        'is_anonymous' => 'required|boolean',
        'campaign_id' => 'required|integer',
        'amount' => 'required|numeric',
    ]);

    // Update status donasi berdasarkan hasil callback dari Midtrans
    $donation = CampaignDonation::where('transaction_id', $data['order_id'])->first();

    if ($donation) {
        $donation->update([
            'status' => $data['status'] == 'settlement' || $data['status'] == 'capture' ? 'succes' : $data['status'],
        ]);
    }

    return response()->json(['message' => 'Donasi berhasil dikonfirmasi!']);
}

    public function midtransCallback(Request $request)
    {
        $notificationBody = json_decode($request->getContent(), true);

        // Extract order ID from notification
        $orderId = $notificationBody['order_id'] ?? null;
        $transactionStatus = $notificationBody['transaction_status'] ?? null;
        $fraudStatus = $notificationBody['fraud_status'] ?? null;

        if (!$orderId || !$transactionStatus) {
            return response()->json(['status' => 'error', 'message' => 'Invalid notification data']);
        }

        // Find donation by transaction_id (order_id)
        $donation = CampaignDonation::where('transaction_id', $orderId)->first();

        if (!$donation) {
            return response()->json(['status' => 'error', 'message' => 'Donation not found']);
        }

        // Update donation status based on transaction status
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $donation->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $donation->status = 'succes';
            }
        } else if ($transactionStatus == 'settlement') {
            $donation->status = 'succes';
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $donation->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $donation->status = 'pending';
        }

        $donation->save();

        return response()->json(['status' => 'success']);
    }
}
