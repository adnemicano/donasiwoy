@extends('layouts.admin')

@section('heading', 'Laporan Donasi')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Donasi</h6>
            <a href="{{ route('admin.donations.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Donasi
            </a>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <form action="{{ route('admin.donations.reports') }}" method="GET" class="row">
                    <div class="col-md-3 mb-3">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="succes" {{ request('status') == 'succes' ? 'selected' : '' }}>Sukses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button type="button" class="btn btn-success ml-2" id="btnExport">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Donasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp{{ number_format($totalAmount, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-donate fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Donasi Sukses</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $successCount }}</div>
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
                                        Donasi Pending</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCount }}</div>
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
                                        Donasi Gagal</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $failedCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="reportTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Donatur</th>
                            <th>Kampanye</th>
                            <th>Jumlah</th>
                            <th>Status</th>
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
                            <td>{{ $donation->campaign->title ?? 'N/A' }}</td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.0/dist/xlsx.full.min.js"></script>
<script>
    // Function to export table to Excel
    document.getElementById('btnExport').addEventListener('click', function() {
        // Get table data
        const table = document.getElementById('reportTable');

        // Create workbook
        const wb = XLSX.utils.table_to_book(table, {sheet: "Laporan Donasi"});

        // Generate filename with current date
        const now = new Date();
        const fileName = `Laporan_Donasi_${now.getFullYear()}-${(now.getMonth()+1)}-${now.getDate()}.xlsx`;

        // Export to file
        XLSX.writeFile(wb, fileName);
    });
</script>
@endsection
