@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-8">
                <img src="{{ asset('storage/' . $campaign->thumbnail) }}" alt="{{ $campaign->title }}" class="img-fluid">
                <h2 class="mt-3">{{ $campaign->title }}</h2>
                <p>
                    Target: Rp. {{ number_format($campaign->target) }}
                    <br>
                    Tanggal berakhir: {{ \Carbon\Carbon::parse($campaign->end_date)->format('d F Y') }}
                </p>
                <p>
                    {!! $campaign->story !!}
                </p>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        @error('donation')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <form action="{{ route('donation.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                            <div class="mb-3">
                                <label for="donation" class="form-label">Donasi</label>
                                <input type="number" class="form-control" id="donation" name="donation" value="10000">
                            </div>
                            @auth
                                <button type="submit" class="btn btn-primary w-100">Donasi</button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Login untuk donasi</a>
                            @endauth
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
