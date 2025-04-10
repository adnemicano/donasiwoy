@extends('layouts.app')

@section('title', 'Donasi')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h4 class="mb-0 text-center">Konfirmasi Donasi</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="fs-4 fw-bold mb-2">Rp{{ number_format($details['amount'], 0, ',', '.') }}</div>
                            <p class="text-muted">Anda akan berdonasi sebesar nominal di atas</p>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="anonymousCheckbox">
                            <label class="form-check-label" for="anonymousCheckbox">
                                <i class="fas fa-user-secret me-1"></i> Sembunyikan nama saya (donasi sebagai Anonim)
                            </label>
                            <small class="form-text text-muted d-block mt-1">
                                Jika dicentang, nama Anda tidak akan ditampilkan di daftar donatur
                            </small>
                        </div>

                        <button type="button" class="btn btn-primary w-100 mt-3" id="btnPay">
                            <i class="fas fa-credit-card me-2"></i> Lanjutkan Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-4tstmwvljOg5AHnc"></script>
    <script>
        document.getElementById('btnPay').onclick = function() {
            let isAnonymous = document.getElementById('anonymousCheckbox').checked;

            snap.pay('{{ $details['snap_token'] }}', {
                onSuccess: function(result) {
                    sendDonationStatus(result, isAnonymous);
                },
                onPending: function(result) {
                    sendDonationStatus(result, isAnonymous);
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                }
            });
        };

        function sendDonationStatus(result, isAnonymous) {
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
                    is_anonymous: isAnonymous,
                    campaign_id: {{ $details['campaign_id'] }},
                    amount: {{ $details['amount'] }}
                })
            }).then(response => response.json())
              .then(data => {
                  alert(data.message);
                  window.location.href = "{{ route('home') }}";
              });
        }
    </script>
@endsection
