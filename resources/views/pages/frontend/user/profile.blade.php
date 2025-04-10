@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div style="max-width: 700px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); text-align: center;">
    <!-- Avatar -->
    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="{{ $user->avatar_url }}"
             alt="Avatar" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #ddd; object-fit: cover;">
        <h2 style="margin-top: 15px; font-size: 22px; font-weight: bold; color: #333;">{{ $user->fullname }}</h2>
        <p style="color: #777; font-size: 14px;">Bergabung pada {{ $user->created_at->format('d F Y') }}</p>
    </div>

    <!-- Informasi Profil -->
    <div style="margin-top: 20px; text-align: left;">
        <label style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Fullname</label>
        <input type="text" value="{{ $user->fullname }}"
               style="width: 100%; padding: 10px; border-radius: 8px; background: #f3f4f6; border: 1px solid #ddd;" disabled>

        <label style="display: block; font-size: 14px; color: #555; margin-top: 15px; margin-bottom: 5px;">Email</label>
        <input type="email" value="{{ $user->email }}"
               style="width: 100%; padding: 10px; border-radius: 8px; background: #f3f4f6; border: 1px solid #ddd;" disabled>

        <label style="display: block; font-size: 14px; color: #555; margin-top: 15px; margin-bottom: 5px;">Phone</label>
        <input type="text" value="{{ $user->phone_number }}"
               style="width: 100%; padding: 10px; border-radius: 8px; background: #f3f4f6; border: 1px solid #ddd;" disabled>
    </div>

    <!-- Tombol Edit -->
    <a href="{{ route('profile.edit') }}"
       style="display: block; text-align: center; margin-top: 25px; background: #3AA597; color: #fff; padding: 12px 0; border-radius: 8px; font-weight: bold; text-decoration: none;">
        Edit Profil
    </a>

    <!-- Tombol Riwayat Donasi -->
    <a href="{{ route('profile.donations') }}"
       style="display: block; text-align: center; margin-top: 10px; background: #4a6fa5; color: #fff; padding: 12px 0; border-radius: 8px; font-weight: bold; text-decoration: none;">
        Lihat Semua Riwayat Donasi
    </a>
</div>
@endsection
