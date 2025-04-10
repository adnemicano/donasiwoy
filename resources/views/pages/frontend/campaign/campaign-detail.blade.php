@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
    <div class="container mt-5">
        <div class="row">
            <!-- Bagian kiri -->
            <div class="col-md-8">
                <img src="{{ asset('storage/' . $campaign->thumbnail) }}" alt="{{ $campaign->title }}"
                    class="img-fluid rounded mb-3">
                <h2 class="fw-bold">{{ $campaign->title }}</h2>
                <div class="mb-3">
                    <span class="badge bg-warning text-dark">
                        Target: Rp{{ number_format($campaign->target, 0, ',', '.') }}
                    </span>
                    <span class="badge bg-light text-dark ms-2">
                        Tanggal berakhir: {{ \Carbon\Carbon::parse($campaign->end_date)->format('d F Y') }}
                    </span>
                </div>

                <!-- Donation progress section -->
                <div class="card mb-4">
                    <div class="card-body">
                        @php
                            $totalDonation = $campaign->total_donations;
                            $percentProgress =
                                $campaign->target > 0 ? min(100, ($totalDonation / $campaign->target) * 100) : 0;
                        @endphp

                        <h5>Progress Donasi</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Rp{{ number_format($totalDonation, 0, ',', '.') }}</span>
                            <span>dari Rp{{ number_format($campaign->target, 0, ',', '.') }}</span>
                        </div>

                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $percentProgress }}%; background-color: #16423C;"
                                aria-valuenow="{{ $percentProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="d-flex justify-content-between small text-muted">
                            <span>{{ $campaign->donors_count }} Donatur</span>
                            <span>{{ number_format($percentProgress, 1) }}%</span>
                        </div>
                    </div>
                </div>

                <p class="text-justify">
                    {!! nl2br(e($campaign->story)) !!}
                </p>

                <!-- Recent Donors Section -->
                <div class="card mt-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Donatur Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $recentDonations = $campaign
                                ->donations()
                                ->where('status', 'succes')
                                ->with('user')
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();
                        @endphp

                        @if ($recentDonations->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($recentDonations as $donation)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold">
                                                @if ($donation->is_anonymous)
                                                    Anonim
                                                @else
                                                    @php
                                                        $name = $donation->donor_name ?: ($donation->user->fullname ?? $donation->user->name);
                                                        $firstChar = substr($name, 0, 1);
                                                        $censoredName = $firstChar . "***";
                                                    @endphp
                                                    {{ $censoredName }}
                                                @endif
                                            </span>
                                            @if($donation->message)
                                                <small class="text-muted d-block">
                                                    "{{ Str::limit($donation->message, 50) }}"
                                                </small>
                                            @endif
                                            <small class="text-muted d-block">
                                                {{ $donation->created_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">
                                            Rp {{ number_format($donation->value, 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center text-muted my-3">Belum ada donasi untuk kampanye ini</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bagian kanan -->
            <div class="col-md-4">
                <div class="card shadow-sm border-1">
                    <div class="card-body">
                        @if (isset($isExpired) && $isExpired)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-circle"></i> Kampanye ini telah berakhir pada
                                {{ \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') }}
                            </div>
                        @endif

                        @error('donation')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <form action="{{ route('donation.store') }}" method="POST" id="donationForm">
                            @csrf
                            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                            <input type="hidden" name="is_expired"
                                value="{{ isset($isExpired) && $isExpired ? '1' : '0' }}">
                            <div class="mb-3">
                                <label for="donation" class="form-label fw-semibold">Donasi</label>
                                <input type="number" class="form-control" id="donation" name="donation" value="10000"
                                    min="1000" step="1000" {{ isset($isExpired) && $isExpired ? 'disabled' : '' }}>
                            </div>
                            @auth
                                <button type="submit" class="btn w-100" style="background-color: #16423C; color: #fff;"
                                    {{ isset($isExpired) && $isExpired ? 'disabled' : '' }}>
                                    {{ isset($isExpired) && $isExpired ? 'Kampanye Telah Berakhir' : 'Donasi Sekarang' }}
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Login untuk Donasi</a>
                            @endauth
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expired Campaign Modal -->
    @if (isset($isExpired) && $isExpired)
        <div class="modal fade" id="expiredCampaignModal" tabindex="-1" aria-labelledby="expiredCampaignModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="expiredCampaignModalLabel">Kampanye Telah Berakhir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-center">Maaf, kampanye "{{ $campaign->title }}" telah berakhir pada
                            {{ \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') }}.</p>
                        <p class="text-center">Silahkan kunjungi kampanye lain yang masih aktif.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a href="{{ route('campaigns.index') }}" class="btn btn-primary">Lihat Kampanye Lainnya</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        // Show expired campaign modal when page loads
        $(document).ready(function() {
            @if (isset($isExpired) && $isExpired)
                var expiredCampaignModal = new bootstrap.Modal(document.getElementById('expiredCampaignModal'), {
                    backdrop: 'static'
                });
                expiredCampaignModal.show();
            @endif
        });
    </script>
@endsection
