@extends('layouts.admin')

@section('heading', 'Data Donasi')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Donasi</h6>
            <div>
                <a href="{{ route('admin.donations.reports') }}" class="btn btn-sm btn-info me-2">
                    <i class="fas fa-file-download"></i> Laporan Donasi
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Enhanced Filter Section with Better Styling -->
            <div class="mb-4 p-4 bg-light rounded shadow-sm border">
                <h6 class="mb-3 font-weight-bold">Filter Data</h6>
                <form action="{{ route('admin.donations.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Kampanye</label>
                            <select name="campaign_id" class="form-control form-select custom-select">
                                <option value="">Semua Kampanye</option>
                                @foreach ($campaigns as $campaign)
                                    <option value="{{ $campaign->id }}"
                                        {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
                                        {{ $campaign->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-control form-select custom-select">
                                <option value="">Semua Status</option>
                                <option value="succes" {{ request('status') == 'succes' ? 'selected' : '' }}>Sukses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Periode</label>
                            <select name="period" class="form-control form-select custom-select">
                                <option value="">Semua Waktu</option>
                                <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini
                                </option>
                                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini
                                </option>
                                <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </div>

                    <!-- Clear filters option -->
                    @if (request()->has('campaign_id') || request()->has('status') || request()->has('period'))
                        <div class="text-end mt-2">
                            <a href="{{ route('admin.donations.index') }}" class="text-decoration-none small">
                                <i class="fas fa-times-circle"></i> Reset Filter
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Donasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp {{ number_format($donations->sum('value'), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Sukses</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $donations->where('status', 'succes')->count() }} donasi
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $donations->where('status', 'pending')->count() }} donasi
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Gagal</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $donations->where('status', 'failed')->count() }} donasi
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Table with Striped Rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Donatur</th>
                            <th>Kampanye</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $donation)
                            <tr>
                                <td>{{ $donation->id }}</td>
                                <td>{{ $donation->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if ($donation->is_anonymous)
                                        <span class="badge bg-secondary text-white">
                                            <i class="fas fa-user-secret me-1"></i> Anonim
                                        </span>
                                    @else
                                        <span class="fw-bold">{{ $donation->user->fullname ?? 'N/A' }}</span>
                                        <br>
                                        <small class="text-muted">{{ $donation->user->email ?? '' }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if ($donation->campaign)
                                        <a href="{{ route('admin.donations.campaign', $donation->campaign_id) }}"
                                            class="text-primary fw-bold">
                                            {{ Str::limit($donation->campaign->title, 45) }}
                                        </a>
                                    @else
                                        <span class="text-muted">Kampanye tidak tersedia</span>
                                    @endif
                                </td>
                                <td class="fw-bold">Rp {{ number_format($donation->value, 0, ',', '.') }}</td>
                                <td>
                                    @if ($donation->status == 'succes')
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
                                    <a href="{{ route('admin.donations.show', $donation->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-4">
                {{ $donations->withQueryString()->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        // Add custom styling for select inputs
        $(document).ready(function() {
            $('.custom-select').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih opsi',
                allowClear: true
            });
        });
    </script>
@endsection
