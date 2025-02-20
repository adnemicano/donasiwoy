@extends('layouts.app')

@section('title', 'Berita')

@section('content')
    <div class="container mt-5 mb-4">
        <div class="row" style="margin-bottom: 5rem;">
            <!-- Berita Utama -->
            <div class="col-md-8">
                <div id="beritaUtamaCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($headlineNews as $key => $beritaUtama)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $beritaUtama->thumbnail) }}" class="d-block w-100"
                                    alt="{{ $beritaUtama->title }}"
                                    style="height: 400px; object-fit: cover; border-radius: 8px;">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 class="fw-bold" style="color: #fff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                        {{ $beritaUtama->title }}</h5>
                                    <p class="text-light" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                        {{ \Carbon\Carbon::parse($beritaUtama->date)->format('d F Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#beritaUtamaCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#beritaUtamaCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <div class="col-md-4">
                <h5 class="mb-3" style="color: #16423C; font-weight: bold;">Terbaru</h5>
                <ul class="list-group">
                    @foreach ($latestNews as $beritaTerbaru)
                        <li class="list-group-item d-flex align-items-center gap-3"
                            style="border: none; border-radius: 8px; margin-bottom: 10px;">
                            <a href="{{ route('news.show', $beritaTerbaru->slug) }}">
                                <img src="{{ asset('storage/' . $beritaTerbaru->thumbnail) }}"
                                    alt="{{ $beritaTerbaru->title }}" class="img-thumbnail me-3"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            </a>
                            <div>
                                <a href="{{ route('news.show', $beritaTerbaru->slug) }}"
                                    style="text-decoration: none; color: #16423C; font-weight: bold;">
                                    {{ $beritaTerbaru->title }}
                                </a>
                                <p class="text-muted mb-0" style="font-size: 12px;">
                                    {{ \Carbon\Carbon::parse($beritaTerbaru->date)->format('d F Y') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>


        <!-- News List -->
        <div class="row g-4">
            @forelse ($news as $berita)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100" style="border: none; background-color: #FCEADE;">
                        <img src="{{ asset('storage/' . $berita->thumbnail) }}" class="card-img-top"
                            alt="{{ $berita->title }}" style="height: 180px; object-fit: cover; border-radius: 8px;">

                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #16423C;">{{ $berita->title }}</h5>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->content), 100, '...') }}</p>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($berita->date)->format('d F Y') }}</p>
                        </div>
                        <div class="card-footer text-center" style="background-color: transparent; border: none;">
                            <a href="{{ route('news.show', $berita->slug) }}" class="btn"
                                style="width: 100%; border-radius: 6px; background-color:#16423C; color: #fff;">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Berita tidak ditemukan.</p>
            @endforelse
        </div>

        @if ($news->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <ul class="pagination">
                    {{-- Tombol Sebelumnya --}}
                    @if ($news->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
                    @else
                        <li class="page-item"><a href="{{ $news->previousPageUrl() }}" class="page-link">Sebelumnya</a>
                        </li>
                    @endif

                    {{-- Nomor Halaman --}}
                    @foreach ($news->links()->elements[0] as $page => $url)
                        @if ($page == $news->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Tombol Selanjutnya --}}
                    @if ($news->hasMorePages())
                        <li class="page-item"><a href="{{ $news->nextPageUrl() }}" class="page-link">Selanjutnya</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Selanjutnya</span></li>
                    @endif
                </ul>
            </div>
        @endif


    </div>
@endsection
