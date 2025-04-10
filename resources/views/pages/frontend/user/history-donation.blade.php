@extends('layouts.app')

@section('title', 'Riwayat Donasi')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Riwayat Donasi</h4>
        </div>
        <div class="card-body">
            @if($donations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kampanye</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $donation)
                                <tr>
                                    <td>{{ $donation->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        @if($donation->campaign)
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $donation->campaign->thumbnail) }}"
                                                     alt="{{ $donation->campaign->title }}"
                                                     class="rounded me-2"
                                                     style="width: 50px; height: 40px; object-fit: cover;">
                                                <div>{{ $donation->campaign->title }}</div>
                                            </div>
                                        @else
                                            <span class="text-muted">Kampanye tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold">Rp {{ number_format($donation->value, 0, ',', '.') }}</span>
                                        @if($donation->is_anonymous)
                                            <span class="badge bg-secondary ms-1">Anonim</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->status == 'succes')
                                            <span class="badge bg-success">Sukses</span>
                                        @elseif($donation->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($donation->status == 'waiting')
                                            <span class="badge bg-info text-dark">Menunggu</span>
                                        @else
                                            <span class="badge bg-danger">Gagal</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($donation->campaign)
                                            <a href="{{ route('campaign.show', $donation->campaign->slug) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                Lihat Kampanye
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled>Tidak Tersedia</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <img src="{{ asset('assets/img/empty-donation.svg') }}" alt="Belum ada donasi" style="max-width: 200px; opacity: 0.7" class="mb-3">
                    <h5>Belum Ada Riwayat Donasi</h5>
                    <p class="text-muted">Anda belum pernah melakukan donasi.</p>
                    <a href="{{ route('campaigns.index') }}" class="btn btn-primary mt-2">Mulai Donasi Sekarang</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
