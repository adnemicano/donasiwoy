@extends('layouts.admin')

@section('heading', 'Detail Donasi')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Donasi</h6>
                    <a href="{{ route('admin.donations.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">ID Donasi</th>
                                    <td>{{ $donation->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $donation->created_at->format('d M Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Donatur</th>
                                    <td>
                                        @if($donation->is_anonymous)
                                            <span class="badge badge-secondary">Anonim</span>
                                        @else
                                            {{ $donation->user->fullname ?? 'N/A' }}
                                            <small class="text-muted d-block">{{ $donation->user->email ?? '' }}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kampanye</th>
                                    <td>
                                        @if($donation->campaign)
                                            <a href="{{ route('admin.campaigns.edit', $donation->campaign_id) }}">
                                                {{ $donation->campaign->title }}
                                            </a>
                                        @else
                                            <span class="text-danger">Kampanye tidak tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah Donasi</th>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            Rp{{ number_format($donation->value, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                <tr>
                                    <th>Donasi Sebagai</th>
                                    <td>
                                        @if($donation->is_anonymous)
                                            <span class="badge badge-secondary">Anonim</span>
                                        @else
                                            <span class="badge badge-light">Publik</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.donations.update-status', $donation->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="status">Status Donasi</label>
                            <select name="status" id="status" class="form-control">
                                <option value="waiting" {{ $donation->status == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                                <option value="pending" {{ $donation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="succes" {{ $donation->status == 'succes' ? 'selected' : '' }}>Sukses</option>
                                <option value="failed" {{ $donation->status == 'failed' ? 'selected' : '' }}>Gagal</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
