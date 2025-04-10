@extends('layouts.app')

@section('title', 'Detail Donasi')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-center">Detail Donasi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('donation.process', $donation->id) }}" method="POST">
                        @csrf

                        <!-- Campaign Info -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $donation->campaign->thumbnail) }}"
                                     alt="{{ $donation->campaign->title }}"
                                     class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-2">{{ $donation->campaign->title }}</h5>
                                <p class="text-muted small mb-0">
                                    Target: Rp{{ number_format($donation->campaign->target, 0, ',', '.') }}
                                </p>
                                <p class="text-muted small">
                                    Berakhir: {{ \Carbon\Carbon::parse($donation->campaign->end_date)->format('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Donation Amount -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-center mb-3">Donasi Anda</h5>
                            <div class="text-center">
                                <span class="h2 fw-bold text-primary">Rp{{ number_format($donation->value, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Donor Info -->
                        <div class="mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">Informasi Donatur</h6>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="donor_name" class="form-label">Nama Donatur</label>
                                            <input type="text" class="form-control" id="donor_name" name="donor_name"
                                                   value="{{ old('donor_name', $donation->user->fullname ?? $donation->user->name) }}"
                                                   placeholder="Masukkan nama yang akan ditampilkan">
                                            <small class="text-muted">Nama ini akan ditampilkan di daftar donatur (jika tidak anonim)</small>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Email</label>
                                            <p class="mb-0 py-2 px-3 bg-white rounded">{{ $donation->user->email }}</p>
                                            <small class="text-muted">Email tidak dapat diubah dan tidak akan ditampilkan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Anonymous Donation Option -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="is_anonymous" id="anonymousCheckbox"
                                   {{ $donation->is_anonymous ? 'checked' : '' }}>
                            <label class="form-check-label" for="anonymousCheckbox">
                                <i class="fas fa-user-secret me-1"></i> Sembunyikan nama saya (donasi sebagai Anonim)
                            </label>
                            <small class="form-text text-muted d-block mt-1">
                                Jika dicentang, nama Anda tidak akan ditampilkan di daftar donatur
                            </small>
                        </div>

                        <!-- Optional Message -->
                        <div class="mb-4">
                            <label for="donation_message" class="form-label">Pesan (Opsional)</label>
                            <textarea class="form-control" id="donation_message" name="donation_message" rows="3"
                                      placeholder="Tulis pesan dukungan Anda...">{{ old('donation_message', $donation->message) }}</textarea>
                            <small class="text-muted">Pesan Anda akan ditampilkan bersama dengan donasi</small>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="mb-4">
                            <h6 class="mb-3">Pilih Metode Pembayaran</h6>

                            <div class="row g-3">
                                <!-- Bank Transfer -->
                                <div class="col-md-4">
                                    <div class="form-check payment-method-option border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="bankTransfer" value="bank_transfer" checked>
                                        <label class="form-check-label d-flex align-items-center" for="bankTransfer">
                                            <i class="fas fa-university me-2 text-primary"></i>
                                            <span>Transfer Bank</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- E-Wallet -->
                                <div class="col-md-4">
                                    <div class="form-check payment-method-option border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="eWallet" value="e_wallet">
                                        <label class="form-check-label d-flex align-items-center" for="eWallet">
                                            <i class="fas fa-wallet me-2 text-primary"></i>
                                            <span>E-Wallet</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Credit Card -->
                                <div class="col-md-4">
                                    <div class="form-check payment-method-option border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="creditCard" value="credit_card">
                                        <label class="form-check-label d-flex align-items-center" for="creditCard">
                                            <i class="fas fa-credit-card me-2 text-primary"></i>
                                            <span>Kartu Kredit</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted d-block mt-2">
                                * Pilihan pembayaran lengkap akan tersedia di halaman pembayaran
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-credit-card me-2"></i> Lanjutkan ke Pembayaran
                            </button>
                            <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .payment-method-option {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .payment-method-option:hover {
        background-color: #f8f9fa;
    }

    .form-check-input:checked ~ .form-check-label .payment-method-option {
        border-color: #16423C !important;
        background-color: #f0f9f7;
    }
</style>
@endsection
