<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\CampaignDonation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::exists($user->profile_photo)) {
                Storage::delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');

            $user->profile_photo = $path;
            $user->save();

            return back()->with('success', 'Profile photo updated successfully');
        }

        return back()->with('error', 'No photo uploaded');
    }

    public function index()
    {
        $user = Auth::user(); // Retrieve the authenticated user
        $donations = collect([]);

        if (Auth::check()) {
            // Get the user ID
            $userId = Auth::id();

            // Log the user ID for debugging
            Log::info('Fetching donations for user ID: ' . $userId);

            // Use a more specific query to fetch the donations
            $donations = CampaignDonation::where('user_id', $userId)
                            ->with('campaign')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

            // Log the count of donations found
            Log::info('Found ' . $donations->count() . ' donations');
        }

        return view('pages.frontend.user.profile', compact('user', 'donations'));
    }

    public function donation()
    {
        $donations = CampaignDonation::where('user_id', Auth::id())
                        ->with('campaign')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('pages.frontend.user.history-donation', compact('donations'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('pages.frontend.user.settings', compact('user'));
    }
}
