@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section style="background: linear-gradient(to bottom, #3AA597, #ECDFCC); padding: 50px 20px; margin-bottom: 3rem; height: 92vh;">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <!-- Judul -->
            <h1 style="font-size: 2.5rem; font-weight: bold; color: #ffffff; margin-top: 52px;">
                Bersama Donasi Woy,<br> Kita Wujudkan Perubahan!
            </h1>

            <!-- Kontainer Konten -->
            <div
                style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; width: 100%; gap: 30px; margin-top: 8rem;">
                <!-- Konten Kiri -->
                <div style="flex: 1; text-align: center;">
                    <h2 style="font-size: 2.5rem; font-weight: bold; color: #ffffff; margin-bottom: 10px;">Suara Anda.</h2>
                    <p style="color: #ffffff; font-size: 1rem; margin-bottom: 20px;">Suarakan aksi nyata.</p>
                    <button
                        style="background-color: #3AA597; color: #ffffff; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">
                        PETISI
                    </button>
                </div>

                <!-- Gambar Tengah -->
                <div style="flex: 1; display: flex; justify-content: center;">
                    <img src="{{ asset('assets/img/vektor-home.png') }}" alt="Gambar Orang"
                        style="width: 160%; max-width: 800px; margin-bottom: -50px;" />
                </div>

                <!-- Konten Kanan -->
                <div style="flex: 1; text-align: center;">
                    <h2 style="font-size: 2.5rem; font-weight: bold; color: #ffffff; margin-bottom: 10px;">Aksi Nyata.</h2>
                    <p style="color: #ffffff; font-size: 1rem; margin-bottom: 20px;">Jadikan perubahan bersama.</p>
                    <button
                        style="background-color: #3AA597; color: #ffffff; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">
                        <a href="{{ route('campaigns.index') }}" style="text-decoration: none; color: inherit;">DONASI</a>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 50px 0;">
    <div style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        @if ($campaigns->isEmpty())
            <p style="text-align: center; color: #fff;">Belum ada campaign terbaru.</p>
        @else
            <div id="campaignCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">
                    @foreach ($campaigns as $key => $campaign)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div style="
                                display: flex;
                                flex-direction: row;
                                align-items: center;
                                gap: 30px;
                                width: 100%;
                                height: 360px;
                                padding: 30px;
                                border-radius: 20px;
                                background: linear-gradient(180deg, #ECDFCC 0%, #16423C 100%);
                                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                            ">
                                <!-- Thumbnail di kiri -->
                                <div style="flex: 0 0 400px;">
                                    <img src="{{ $campaign->thumbnail ? asset('storage/' . $campaign->thumbnail) : asset('assets/img/default-thumbnail.jpg') }}"
                                        alt="{{ $campaign->title }}" style="
                                            width: 100%;
                                            height: 300px;
                                            border-radius: 15px;
                                            object-fit: cover;
                                        ">
                                </div>

                                <!-- Konten di kanan -->
                                <div style="flex: 1; display: flex; flex-direction: column; gap: 15px;">
                                    <h3 style="font-size: 1.5rem; font-weight: bold; color:#16423C;">
                                        {{ $campaign->title }}
                                    </h3>
                                    <p style="font-size: 1rem; color:#fff;">
                                        {{ Str::limit($campaign->story, 250) }}
                                    </p>
                                    <p style="font-weight: 400; color:#fff;">
                                        Target: Rp{{ number_format($campaign->target, 0, ',', '.') }}
                                    </p>
                                    <a href="{{ route('campaigns.show', $campaign->slug) }}"
                                        style="
                                            padding: 10px 20px;
                                            background-color: #ECDFCC;
                                            color: #16423C;
                                            font-weight: bold;
                                            border-radius: 8px;
                                            text-decoration: none;
                                            width: fit-content;
                                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                        ">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tombol navigasi -->
                <button class="carousel-control-prev" type="button" data-bs-target="#campaignCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#campaignCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        @endif
    </div>
</section>







@endsection
