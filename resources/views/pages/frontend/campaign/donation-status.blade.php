@extends('layouts.app')

@section('title', 'Status Donasi')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Left side - Payment Status -->
                        <div class="col-md-5 p-4 d-flex flex-column justify-content-center align-items-center" id="status-container">
                            <!-- Status will be updated via JS -->
                            <div id="status-waiting" class="text-center d-none">
                                <div class="spinner-border text-primary mb-4" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h4 class="mb-2">Menunggu Pembayaran</h4>
                                <p class="text-muted">Silahkan pilih metode pembayaran untuk melanjutkan proses donasi</p>
                            </div>

                            <div id="status-pending" class="text-center d-none">
                                <div class="spinner-grow text-warning mb-4" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h4 class="mb-2">Pembayaran Sedang Diproses</h4>
                                <p class="text-muted">Kami sedang menunggu konfirmasi pembayaran Anda</p>
                                <small class="text-muted" id="last-updated"></small>
                            </div>

                            <div id="status-success" class="text-center d-none">
                                <div class="mb-4 text-success">
                                    <i class="fas fa-check-circle" style="font-size: 5rem;"></i>
                                </div>
                                <h4 class="mb-2">Pembayaran Berhasil</h4>
                                <p class="text-muted">Terima kasih! Donasi Anda telah kami terima</p>
                                <small class="text-muted" id="success-updated"></small>
                            </div>

                            <div id="status-failed" class="text-center d-none">
                                <div class="mb-4 text-danger">
                                    <i class="fas fa-times-circle" style="font-size: 5rem;"></i>
                                </div>
                                <h4 class="mb-2">Pembayaran Gagal</h4>
                                <p class="text-muted">Mohon maaf, pembayaran Anda tidak berhasil diproses</p>
                                <div class="mt-3">
                                    <a href="{{ route('donation.details', $donation->id) }}" class="btn btn-primary">
                                        Coba Lagi
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right side - Donation Details -->
                        <div class="col-md-7 border-start">
                            <div class="p-4">
                                <h5 class="fw-bold mb-4">Detail Donasi</h5>

                                <!-- Campaign Info -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $donation->campaign->thumbnail) }}"
                                             alt="{{ $donation->campaign->title }}"
                                             class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="mb-2">{{ $donation->campaign->title }}</h5>
                                        <div class="progress mt-2" style="height: 8px;">
                                            @php
                                                $percentProgress = $donation->campaign->target > 0
                                                    ? min(100, ($donation->campaign->total_donations / $donation->campaign->target) * 100)
                                                    : 0;
                                            @endphp
                                            <div class="progress-bar" role="progressbar"
                                                 style="width: {{ $percentProgress }}%; background-color: #16423C;"
                                                 aria-valuenow="{{ $percentProgress }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1 small">
                                            <span>Rp{{ number_format($donation->campaign->total_donations, 0, ',', '.') }}</span>
                                            <span>{{ number_format($percentProgress, 1) }}%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Donation Info -->
                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted d-block">ID Transaksi</small>
                                                <span class="fw-medium">{{ $donation->transaction_id ?? 'Belum tersedia' }}</span>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small class="text-muted d-block">Tanggal</small>
                                                <span class="fw-medium">{{ $donation->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Donation Amount -->
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Jumlah Donasi</h6>
                                    <h4 class="fw-bold">Rp{{ number_format($donation->value, 0, ',', '.') }}</h4>
                                </div>

                                <!-- Donor Info -->
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Informasi Donatur</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td width="30%">Nama</td>
                                            <td>: {{ $donation->is_anonymous ? 'Anonim' : ($donation->donor_name ?: ($donation->user->fullname ?? $donation->user->name)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>: {{ $donation->user->email }}</td>
                                        </tr>
                                        @if($donation->message)
                                        <tr>
                                            <td>Pesan</td>
                                            <td>: {{ $donation->message }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Metode Pembayaran</h6>
                                    <p class="mb-0">{{ $donation->payment_method ? ucwords(str_replace('_', ' ', $donation->payment_method)) : 'Belum dipilih' }}</p>
                                </div>

                                <!-- Actions -->
                                <div class="d-grid gap-2 mt-4">
                                    <!-- Pay button (only for waiting/pending donations) -->
                                    @if($donation->isPaymentWaiting() || ($donation->isPaymentPending() && $donation->snap_token))
                                        <button type="button" class="btn btn-primary py-2" id="pay-button">
                                            <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                                        </button>
                                    @endif

                                    <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="btn btn-outline-secondary py-2">
                                        Kembali ke Kampanye
                                    </a>

                                    @if($donation->isPaymentCompleted())
                                        <a href="{{ route('profile.donations') }}" class="btn btn-outline-primary py-2">
                                            <i class="fas fa-history me-2"></i> Lihat Riwayat Donasi
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-4tstmwvljOg5AHnc"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial status
        updateStatusDisplay('{{ $donation->status }}');

        // Set up payment button if we have a snap token
        @if($donation->snap_token)
            document.getElementById('pay-button').onclick = function() {
                snap.pay('{{ $donation->snap_token }}', {
                    onSuccess: function(result) {
                        updatePaymentStatus(result);
                    },
                    onPending: function(result) {
                        updatePaymentStatus(result);
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                        console.log(result);
                        location.reload();
                    },
                    onClose: function() {
                        // Start polling when snap is closed
                        startStatusPolling();
                    }
                });
            };
        @endif

        // Start polling for status updates
        startStatusPolling();
    });

    function updatePaymentStatus(result) {
        fetch("{{ route('donation.confirm') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                transaction_id: result.transaction_id,
                order_id: result.order_id,
                status: result.transaction_status,
                is_anonymous: {{ $donation->is_anonymous ? 'true' : 'false' }},
                campaign_id: {{ $donation->campaign_id }},
                amount: {{ $donation->value }}
            })
        }).then(response => response.json())
          .then(data => {
              alert(data.message);
              location.reload();
          });
    }

    function startStatusPolling() {
        // Only poll if not already completed or failed
        if (!['succes', 'settlement', 'failed', 'expire'].includes('{{ $donation->status }}')) {
            checkStatus();
            // Poll every 5 seconds
            setInterval(checkStatus, 5000);
        }
    }

    function checkStatus() {
        fetch("{{ route('donation.check-status', $donation->id) }}")
            .then(response => response.json())
            .then(data => {
                updateStatusDisplay(data.status);
                document.getElementById('last-updated').textContent = 'Terakhir diperbarui: ' + data.updated_at;
                document.getElementById('success-updated').textContent = 'Pembayaran berhasil: ' + data.updated_at;

                // If status changed to completed or failed, reload after a delay
                if (['succes', 'settlement', 'failed', 'expire'].includes(data.status) &&
                    data.status !== '{{ $donation->status }}') {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
    }

    function updateStatusDisplay(status) {
        // Hide all status containers first
        document.querySelectorAll('#status-container > div').forEach(el => {
            el.classList.add('d-none');
        });

        // Show appropriate status based on current state
        if (status === 'waiting') {
            document.getElementById('status-waiting').classList.remove('d-none');
        } else if (['pending', 'challenge'].includes(status)) {
            document.getElementById('status-pending').classList.remove('d-none');
        } else if (['succes', 'settlement'].includes(status)) {
            document.getElementById('status-success').classList.remove('d-none');
        } else if (['failed', 'expire', 'deny', 'cancel'].includes(status)) {
            document.getElementById('status-failed').classList.remove('d-none');
        }
    }
</script>
@endsection

@section('styles')
<style>
    /* Status indicators */
    .spinner-border, .spinner-grow {
        opacity: 0.8;
    }

    /* Animation for pending status */
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.7;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    #status-pending .spinner-grow {
        animation: pulse 2s infinite;
    }

    /* Success checkmark animation */
    @keyframes checkmark {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    #status-success .fa-check-circle {
        animation: checkmark 0.5s ease-in-out;
    }
</style>
@endsection
