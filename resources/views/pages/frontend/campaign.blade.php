@extends('layouts.app')

@section('title', 'Campaign')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @foreach ($campaigns as $campaign)
            <div class="col-12 col-sm-12 col-md-6 col lg-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $campaign->thumbnail) }}" class="card-img-top"
                    alt="{{ $campaign->title }}">

                    <div class="card-body">
                        <h2 class="card-title">{{ $campaign->title }}</h2>
                        <p class="card-text"> Target: Rp. {{ number_format($campaign->target) }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('campaigns.show', $campaign->slug) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
@endsection
