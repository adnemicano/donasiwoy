@extends('layouts.admin')

@section('heading', 'Detail Berita')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12 text-center mb-4">
                    <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>{{ $news->title }}</h2>
                        <div>
                            <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($news->date)->format('d F Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>Konten</h5>
                        <div class="border p-3 rounded bg-light">
                            {!! $news->content !!}
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5>Slug</h5>
                        <div class="border p-3 rounded bg-light">
                            {{ $news->slug }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
