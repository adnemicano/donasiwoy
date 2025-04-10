@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Breadcrumb Navigation -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news.index') }}" class="text-decoration-none">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($news->title, 30) }}</li>
                </ol>
            </nav>

            <!-- Article Header -->
            <div class="article-header mb-4">
                <h1 class="fw-bold" style="color: #16423C; line-height: 1.3;">{{ $news->title }}</h1>

                <div class="d-flex align-items-center mt-3 mb-4">
                    <span class="me-3 text-muted">
                        <i class="bi bi-calendar-event me-1"></i>
                        {{ \Carbon\Carbon::parse($news->date)->format('d F Y') }}
                    </span>
                    <span class="me-3 text-muted">
                        <i class="bi bi-clock me-1"></i>
                        {{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit membaca
                    </span>
                </div>

                <!-- Featured Image -->
                <div class="position-relative mb-4">
                    <img src="{{ asset('storage/' . $news->thumbnail) }}" class="img-fluid w-100 rounded shadow-sm"
                         alt="{{ $news->title }}" style="max-height: 500px; object-fit: cover;">
                </div>

                <!-- Social Share Buttons -->
                <div class="social-share bg-light p-3 rounded mb-4">
                    <div class="d-flex align-items-center">
                        <span class="me-3 fw-bold">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank" class="btn btn-sm btn-outline-primary me-2" title="Share to Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}"
                           target="_blank" class="btn btn-sm btn-outline-info me-2" title="Share to Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}"
                           target="_blank" class="btn btn-sm btn-outline-success me-2" title="Share to WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject={{ urlencode($news->title) }}&body={{ urlencode(request()->url()) }}"
                           class="btn btn-sm btn-outline-secondary" title="Share via Email">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="article-content mb-5">
                <div class="content lh-lg fs-5">
                    {!! $news->content !!}
                </div>
            </div>

            <!-- Navigation between articles -->
            <div class="article-navigation border-top border-bottom py-4 my-5">
                <div class="row">
                    <div class="col-6 text-start">
                        @php
                            $previousNews = \App\Models\News::where('id', '<', $news->id)->orderBy('id', 'desc')->first();
                        @endphp

                        @if($previousNews)
                            <a href="{{ route('news.show', $previousNews->slug) }}" class="text-decoration-none">
                                <small class="d-block text-muted mb-1"><i class="bi bi-chevron-left"></i> Artikel Sebelumnya</small>
                                <span class="text-dark fw-semibold">{{ Str::limit($previousNews->title, 50) }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        @php
                            $nextNews = \App\Models\News::where('id', '>', $news->id)->orderBy('id')->first();
                        @endphp

                        @if($nextNews)
                            <a href="{{ route('news.show', $nextNews->slug) }}" class="text-decoration-none">
                                <small class="d-block text-muted mb-1">Artikel Selanjutnya <i class="bi bi-chevron-right"></i></small>
                                <span class="text-dark fw-semibold">{{ Str::limit($nextNews->title, 50) }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Back to News List Button -->
            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('news.index') }}" class="btn btn-lg px-4"
                   style="background-color:#16423C; color:white; border-radius: 50px;">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Berita
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Sidebar with Related Articles -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white" style="border-left: 5px solid #16423C;">
                    <h5 class="mb-0 fw-bold" style="color: #16423C;">
                        <i class="bi bi-newspaper me-2"></i>Berita Terkait
                    </h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $relatedNews = \App\Models\News::where('id', '!=', $news->id)
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @forelse ($relatedNews as $related)
                        <div class="related-article border-bottom p-3">
                            <a href="{{ route('news.show', $related->slug) }}" class="text-decoration-none">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                             alt="{{ $related->title }}" class="img-fluid rounded"
                                             style="height: 70px; object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <h6 class="mb-1 text-dark">{{ Str::limit($related->title, 60) }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($related->date)->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Tidak ada berita terkait</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .article-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
        border-radius: 8px;
    }
    .article-content h2, .article-content h3 {
        color: #16423C;
        margin-top: 1.8rem;
        margin-bottom: 1rem;
    }
    .article-content p {
        margin-bottom: 1.2rem;
    }
    .related-article:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
