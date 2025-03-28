<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

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
            $donations = Donation::where('user_id', Auth::id())
                            ->with('campaign')
                            ->orderBy('created_at', 'desc')
                            ->get();
        }
        
        return view('pages.frontend.user.profile', compact('user', 'donations'));
    }

    public function donations()
    {
        $user = Auth::user(); // Retrieve the authenticated user
        $donations = collect([]);

        if (Auth::check()) {
            $donations = Donation::where('user_id', Auth::id())
                            ->with('campaign')
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        return view('pages.frontend.user.donations', compact('user', 'donations')); // Corrected view path
    }
}