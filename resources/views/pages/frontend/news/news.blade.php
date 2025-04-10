@extends('layouts.app')

@section('title', 'Berita')

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Search and Filter Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form action="{{ route('news.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berita..."
                            value="{{ request('search') }}" aria-label="Search">
                        <button class="btn btn-search" type="submit" style="background-color: #16423C; color: white;">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-end">
                    <select class="form-select" name="sort" onchange="location = this.value;" style="max-width: 200px;">
                        <option value="{{ route('news.index') }}" {{ !request('sort') ? 'selected' : '' }}>Urut Berdasarkan</option>
                        <option value="{{ route('news.index', ['sort' => 'newest', 'search' => request('search')]) }}"
                            {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ route('news.index', ['sort' => 'oldest', 'search' => request('search')]) }}"
                            {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 3rem;">
            <!-- Headline News Carousel -->
            <div class="col-md-8 mb-4">
                <div id="beritaUtamaCarousel" class="carousel slide shadow-sm" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($headlineNews as $key => $headline)
                            <button type="button" data-bs-target="#beritaUtamaCarousel" data-bs-slide-to="{{ $key }}"
                                class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($headlineNews as $key => $beritaUtama)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="5000">
                                <a href="{{ route('news.show', $beritaUtama->slug) }}" class="text-decoration-none">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $beritaUtama->thumbnail) }}" class="d-block w-100"
                                            alt="{{ $beritaUtama->title }}"
                                            style="height: 450px; object-fit: cover; border-radius: 10px;">
                                        <div class="position-absolute bottom-0 w-100 p-4"
                                            style="background: linear-gradient(transparent, rgba(0,0,0,0.8)); border-radius: 0 0 10px 10px;">
                                            <h4 class="fw-bold text-white">{{ $beritaUtama->title }}</h4>
                                            <p class="text-light mb-0">
                                                <i class="bi bi-calendar-event me-2"></i>
                                                {{ \Carbon\Carbon::parse($beritaUtama->date)->format('d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
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

            <!-- Latest News -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom" style="border-left: 5px solid #16423C;">
                        <h5 class="mb-0" style="color: #16423C; font-weight: bold;">
                            <i class="bi bi-lightning-charge-fill me-2"></i>Berita Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="latest-news-container" style="max-height: 450px; overflow-y: auto;">
                            @foreach ($latestNews as $beritaTerbaru)
                                <div class="latest-news-item p-2 p-sm-3 border-bottom">
                                    <a href="{{ route('news.show', $beritaTerbaru->slug) }}" class="d-flex text-decoration-none align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . $beritaTerbaru->thumbnail) }}"
                                                alt="{{ $beritaTerbaru->title }}" class="rounded latest-news-img"
                                                style="width: 70px; height: 55px; object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1 ms-2 ms-sm-3">
                                            <h6 class="mb-1 latest-news-title" style="color: #16423C; font-weight: 600; line-height: 1.2; font-size: 0.95rem;">
                                                {{ Str::limit($beritaTerbaru->title, 40) }}
                                            </h6>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($beritaTerbaru->date)->format('d M Y') }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News List Section -->
        <h4 class="mb-4 pb-2 section-title" style="color: #16423C; font-weight: bold; border-bottom: 2px solid #FCEADE;">
            <i class="bi bi-newspaper me-2"></i>Semua Berita
        </h4>

        <div class="row g-4">
            @forelse ($news as $berita)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 news-card border-0 shadow-sm" style="transition: transform 0.3s ease;">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" class="card-img-top"
                                alt="{{ $berita->title }}" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white px-3 py-1 m-2 rounded-pill">
                                <small><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($berita->date)->format('d M Y') }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #16423C;">{{ $berita->title }}</h5>
                            <p class="card-text text-muted">
                                {{ \Illuminate\Support\Str::limit(strip_tags($berita->content), 80, '...') }}
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center">
                            <a href="{{ route('news.show', $berita->slug) }}" class="btn btn-outline-success w-100 rounded-pill"
                                style="border-color: #16423C; color: #16423C; transition: all 0.3s ease;">
                                <i class="bi bi-book me-2"></i>Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        Tidak ada berita yang tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($news->hasPages())
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($news->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&laquo; Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $news->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Sebelumnya</span>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($news->links()->elements[0] as $page => $url)
                            @if ($page == $news->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($news->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $news->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">Selanjutnya &raquo;</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">Selanjutnya &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <style>
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .card-footer .btn:hover {
            background-color: #16423C !important;
            color: white !important;
        }
        .page-item.active .page-link {
            background-color: #16423C;
            border-color: #16423C;
        }
        .page-link {
            color: #16423C;
        }
        .latest-news-item:hover {
            background-color: #f8f9fa;
        }
        .section-title {
            position: relative;
        }

        /* Responsive styles for latest news */
        @media (max-width: 767.98px) {
            .latest-news-container {
                max-height: 300px;
            }
            .latest-news-img {
                width: 60px !important;
                height: 45px !important;
            }
            .latest-news-title {
                font-size: 0.9rem !important;
            }
        }

        @media (max-width: 575.98px) {
            .latest-news-img {
                width: 50px !important;
                height: 40px !important;
            }
            .latest-news-title {
                font-size: 0.85rem !important;
            }
        }

        @media (max-width: 400px) {
            .latest-news-container .text-muted {
                font-size: 0.7rem;
            }
        }
    </style>
@endsection
