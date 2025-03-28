<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampaignDonation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'donation' => 'required|numeric',
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-T3gY-2QeGFFOi_pwPW5Isb9-';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;


        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $request->donation,
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $details = [
            'amount' => $request->donation,
            'snap_token' => $snapToken,
        ];

        return view('pages.frontend.campaign.donation', compact('details'));
    }

    public function confirmDonation(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => 'required|string',
            'order_id' => 'required|string',
            'status' => 'required|string',
            'is_anonymous' => 'required|boolean',
        ]);

        // Simpan donasi ke database
        CampaignDonation::create([
            'campaign_id' => 1, // Sesuaikan dengan ID campaign yang benar
            'user_id' => Auth::id(),
            'value' => 100000, // Sesuaikan dengan jumlah yang benar
            'status' => $data['status'],
            'is_anonymous' => $data['is_anonymous'],
        ]);

        return response()->json(['message' => 'Donasi berhasil dikonfirmasi!']);
    }
}
