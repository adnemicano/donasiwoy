@extends('layouts.admin')

@section('heading', 'Donasi Kampanye: ' . $campaign->title)

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Donasi untuk Kampanye</h6>
            <a href="{{ route('admin.campaigns.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kampanye
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Donasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp{{ number_format($campaign->total_donations, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-donate fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Target Kampanye</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp{{ number_format($campaign->target, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-bullseye fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Persentase Tercapai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ number_format(($campaign->total_donations / $campaign->target) * 100, 1) }}%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Donatur</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->id }}</td>
                            <td>{{ $donation->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($donation->is_anonymous)
                                    <span class="badge badge-secondary">Anonim</span>
                                @else
                                    {{ $donation->user->fullname ?? 'N/A' }}
                                @endif
                            </td>
                            <td>Rp {{ number_format($donation->value, 0, ',', '.') }}</td>
                            <td>
                                @if($donation->status == 'succes')
                                    <span class="badge badge-success">Sukses</span>
                                @elseif($donation->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($donation->status == 'waiting')
                                    <span class="badge badge-info">Menunggu</span>
                                @else
                                    <span class="badge badge-danger">Gagal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.donations.show', $donation->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $donations->links() }}
            </div>
        </div>
    </div>
@endsection
