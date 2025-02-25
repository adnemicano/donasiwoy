<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
