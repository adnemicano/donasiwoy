@extends('layouts.admin')

@section('heading', 'Detail Campaign')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12 text-center mb-4">
                    <img src="{{ asset('storage/' . $campaign->thumbnail) }}" alt="{{ $campaign->title }}" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>{{ $campaign->title }}</h2>
                        <div>
                            <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Target Donasi:</strong> Rp. {{ number_format($campaign->target) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal Berakhir:</strong> {{ \Carbon\Carbon::parse($campaign->end_date)->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5>Cerita</h5>
                        <div class="border p-3 rounded bg-light">
                            {!! $campaign->story !!}
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5>Slug</h5>
                        <div class="border p-3 rounded bg-light">
                            {{ $campaign->slug }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
