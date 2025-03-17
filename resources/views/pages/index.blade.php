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

  <!-- resources/views/components/donation-section.blade.php -->
  <section style="position: relative; padding: 2rem 1rem; background-color: #e6f7f2; overflow: hidden; min-height: 400px;">
    <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 10;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 2rem 0;">
            <div style="flex: 0 0 40%;">
                <img src="{{ asset('assets/img/box1.png') }}" alt="Donation Box" style="max-width: 100%; height: auto;">
            </div>
            <div style="flex: 0 0 55%;">
                <h2 style="font-size: 2rem; color: #2d3748; margin-bottom: 1rem;">Mulai Donasi Sekarang!</h2>
                <p style="font-size: 1rem; color: #4a5568; line-height: 1.6; margin-bottom: 1.5rem;">Setiap rupiah yang Anda donasikan akan digunakan secara transparan untuk membantu mereka yang terpuruk. Tidak hanya bantuan, tetapi juga menyebarkan cinta dan kepedulian kepada sesama.</p>
                <div style="display: flex; align-items: center;">
                    <a href="#" style="display: inline-block; padding: 0.75rem 1.5rem; font-size: 1rem; text-decoration: none; border-radius: 5px; font-weight: 500; background-color: #2d8b61; color: white; border: none;">Mulai donasi</a>
                    <span style="margin: 0 1rem; color: #4a5568;">atau</span>
                    <a href="#" style="display: inline-block; padding: 0.75rem 1.5rem; font-size: 1rem; text-decoration: none; color: #2d8b61; text-decoration: underline;">Pelajari Cara Donasi</a>
                </div>
            </div>
        </div>
    </div>
    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 40%; background-image: url('{{ asset("assets/img/wave.svg") }}'); background-size: cover; background-position: center; z-index: 1;"></div>
</section>








@endsection
