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
</div>

<section style="padding: 20px 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
        <div style="background-color: #f5f7f9; border-radius: 10px; padding: 20px;">
            <h3 style="color: #2d3748; font-size: 18px; margin-bottom: 15px; font-weight: 600;">Campaign yang pernah didonasikan</h3>
            
            {{-- Tambahkan pengecekan eksplisit --}}
            @if(isset($donations) && $donations->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 15px;">
                    @foreach($donations as $donation)
                        <div style="background-color: white; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden;">
                                        <img src="{{ optional($donation->campaign)->image ?? 'images/default-campaign.png' }}" 
                                             alt="{{ optional($donation->campaign)->title ?? 'Campaign Tidak Tersedia' }}" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 5px; color: #2d3748;">
                                            {{ optional($donation->campaign)->title ?? 'Campaign Tidak Tersedia' }}
                                        </h4>
                                        <p style="font-size: 14px; color: #718096; margin: 0;">
                                            Donasi: Rp {{ number_format($donation->amount ?? 0, 0, ',', '.') }}
                                        </p>
                                        <p style="font-size: 14px; color: #718096; margin: 0;">
                                            {{ $donation->created_at ? $donation->created_at->format('d M Y') : 'Tanggal Tidak Tersedia' }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ optional($donation->campaign)->slug ? route('campaign.show', $donation->campaign->slug) : '#' }}" 
                                       style="display: inline-block; padding: 8px 12px; background-color: #2d8b61; color: white; font-size: 14px; border-radius: 5px; text-decoration: none; font-weight: 500;">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="background-color: white; border-radius: 8px; padding: 30px; text-align: center; border: 1px solid #e2e8f0;">
                    <p style="font-size: 16px; color: #718096; margin: 0;">Yah, kamu belum pernah donasi :( </p>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection

<!-- resources/views/components/profile-donation-history.blade.php -->
