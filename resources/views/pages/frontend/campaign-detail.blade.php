@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Bagian kiri -->
        <div class="col-md-8">
            <img src="{{ asset('storage/' . $campaign->thumbnail) }}" alt="{{ $campaign->title }}" class="img-fluid rounded mb-3">
            <h2 class="fw-bold">{{ $campaign->title }}</h2>
            <div class="mb-3">
                <span class="badge bg-warning text-dark">
                    Target: Rp{{ number_format($campaign->target, 0, ',', '.') }}
                </span>
                <span class="badge bg-light text-dark ms-2">
                    Tanggal berakhir: {{ \Carbon\Carbon::parse($campaign->end_date)->format('d F Y') }}
                </span>
            </div>
            <p class="text-justify">
                {!! nl2br(e($campaign->story)) !!}
            </p>
        </div>

        <!-- Bagian kanan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-1">
                <div class="card-body">
                    @error('donation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <form action="{{ route('donation.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                        <div class="mb-3">
                            <label for="donation" class="form-label fw-semibold">Donasi</label>
                            <input type="number" class="form-control" id="donation" name="donation" value="10000" min="1000" step="1000">
                        </div>
                        @auth
                            <button type="submit" class="btn w-100" style="background-color: #16423C; color: #fff;">Donasi Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">Login untuk Donasi</a>
                        @endauth
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
