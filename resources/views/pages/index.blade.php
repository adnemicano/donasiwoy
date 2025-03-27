@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section style="background: linear-gradient(to bottom, #3AA597, #ECDFCC); height: 90vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 50px 20px;">

    <!-- Judul -->
    <h1 style="font-size: 2rem; font-weight: bold; color: #ffffff; max-width: 800px; margin-top: 4rem;">
        Aksi Nyata? Dimulai Dari Sini <br> Bersama Donasi Woy!
    </h1>

    <!-- Tombol Donasi -->
    <a href="{{ route('campaigns.index') }}"
       style="background-color: #3AA597; color: #ffffff; text-decoration: none; padding: 12px 30px; font-size: 1rem; font-weight: bold; border-radius: 5px; margin-top: 20px; display: inline-block;">
        DONASI
    </a>

    <!-- Gambar Tengah -->
    <div style="margin-top: 30px;">
        <img src="{{ asset('assets/img/vektor-home.png') }}" alt="Gambar Orang" style="width: 700px; max-width: 100%;">
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
                                <div
                                    style="
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
                                            alt="{{ $campaign->title }}"
                                            style="
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#campaignCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#campaignCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                </div>
            @endif
        </div>

    </section>

    <section
        style="background: linear-gradient(to bottom, white 10%, #C4FBF3 50%, white); heig
    ht: 100vh; padding: 50px 0;">
        <div
            style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">

            <!-- Gambar Kotak Donasi -->
            <div style="flex: -3; display: flex; justify-content: center;">
                <img src="{{ asset('assets/img/boxxx.png') }}" alt="Kotak Donasi" style="width: 350px; max-width: 100%;">
            </div>

            <!-- Teks Ajakan Donasi -->
            <div style="flex: 1; text-align: center; padding: 20px; min-width: 300px;">
                <h2 style="font`-size: 28px; font-weight: bold; color: #16423C; margin-bottom: 15px;">
                    Mulai Donasi Sekarang!
                </h2>
                <p style="font-size: 16px; color: #16423C; line-height: 1.6;">
                    Setiap rupiah yang Anda donasikan akan digunakan secara transparan untuk membantu mereka yang terpuruk.
                    Tidak hanya bantuan, tetapi juga menyebarkan cinta dan kepedulian kepada sesama.
                </p>
                <button
                    style="background-color: #16423C; color: white; padding: 12px 20px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: bold;">
                    <a href="{{ route('campaigns.index') }}" style="text-decoration: none; color: #fff;">Mulai donasi</a>
                </button>
                <p style="margin-top: 1rem"><a href="{{ route('cara-donasi') }}"
                        style="color: #16423C; font-weight: 600; margin-top: 15px; text-decoration: none; font-size: 14px;">
                        atau <span style="color: #1456DB">Pelajari Cara Donasi</span>
                    </a></p>
            </div>
        </div>
        <img src="{{ asset('assets/img/wave.png') }}" alt="" style="width: 100%; display: block;">

    </section>

    <div class="container my-5">
        <h2 class="mb-4">Berita Terbaru</h2>
        <div class="row">
            @foreach ($latestNews as $news)
                <div class="col-md-6 mb-4">
                    <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none text-dark">
                        <div class="card shadow-sm">
                            <img src="{{ $news->image_url }}" class="card-img-top" alt="{{ $news->title }}"
                                style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $news->title }}</h5>
                                <p class="text-muted small">
                                    {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}
                                </p>
                                <p class="card-text">{{ Str::limit($news->content, 100, '...') }}</p>
                            </div>
                        </div>
                    </a>

                </div>
            @endforeach
        </div>
    </div>
<<<<<<< HEAD
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






=======
>>>>>>> 8a81256 (indexdone)


@endsection
