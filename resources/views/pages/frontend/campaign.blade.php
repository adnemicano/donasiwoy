@extends('layouts.app')

@section('title', 'Campaign')

@section('content')
    <div class="container mt-5 mb-4">
        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <!-- Search Form -->
                <form action="{{ route('campaigns.index') }}" method="GET" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari campaign..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary" style="background-color:#16423C; border-color:#16423C;">Search</button>
                </form>
            </div>
            <div class="col-md-4">
                <!-- Filter by Date -->
                <form action="{{ route('campaigns.index') }}" method="GET" class="d-flex justify-content-end">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Campaign List -->
        <div class="row g-4">
            @forelse ($campaigns as $campaign)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100" style="border: none; background-color: #FCEADE;">
                        <img src="{{ asset('storage/' . $campaign->thumbnail) }}" class="card-img-top" alt="{{ $campaign->title }}" style="height: 180px; object-fit: cover; border-radius: 8px;">

                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #16423C">{{ $campaign->title }}</h5>
                            <p>{{ strtok(strip_tags($campaign->story), '.') }}.</p>
                            <p class="card-text"><strong>Target: Rp{{ number_format($campaign->target) }}</strong></p>
                        </div>
                        <div class="card-footer text-center" style="background-color: transparent; border: none;">
                            <a href="{{ route('campaigns.show', $campaign->slug) }}" class="btn" style="width: 100%; border-radius: 6px; background-color:#16423C; color: #fff;">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Campaign tidak ditemukan.</p>
            @endforelse
        </div>
    </div>
@endsection
