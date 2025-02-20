@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container mt-5 mb-4">
    <h1 class="mb-4">{{ $news->title }}</h1>
    <p class="text-muted">{{ \Carbon\Carbon::parse($news->date)->format('d F Y') }}</p>
    <img src="{{ asset('storage/' . $news->thumbnail) }}" class="img-fluid mb-4" alt="{{ $news->title }}" style="border-radius: 8px;">

    <div class="content">
        {!! $news->content !!}
    </div>

    <a href="{{ route('news.index') }}" class="btn btn-primary mt-4" style="background-color:#16423C; border-color:#16423C;">Kembali ke Daftar Berita</a>
</div>
@endsection
