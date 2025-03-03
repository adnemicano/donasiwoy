<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class UserController extends Controller
{
    use Notifiable;

    public function profile()
    {
        return view('pages.frontend.user.profile', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('pages.frontend.user.edit-profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Validasi input
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data user
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        // Cek apakah ada file avatar yang diupload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            // Simpan avatar baru
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->update([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);


        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

}
