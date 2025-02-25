@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center; font-size: 22px; font-weight: bold; margin-bottom: 20px; color: #333;">Edit Profil</h2>

    <!-- Form Edit Profile -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <img src="{{ $user->avatar_url }}"
                 alt="Avatar"
                 style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #ddd; object-fit: cover;">

            <input type="file" name="avatar"
                   style="margin-top: 10px; font-size: 14px; border: none; padding: 8px; background: #f0f0f0; border-radius: 5px; cursor: pointer;">
        </div>

        <div style="margin-top: 20px;">
            <label style="font-size: 14px; font-weight: bold; color: #555;">Fullname</label>
            <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}"
                   style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">

            <label style="font-size: 14px; font-weight: bold; color: #555; margin-top: 15px; display: block;">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">

            <label style="font-size: 14px; font-weight: bold; color: #555; margin-top: 15px; display: block;">Phone</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                   style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
        </div>

        <button type="submit"
                style="margin-top: 25px; width: 100%; padding: 12px; background: #3AA597; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
