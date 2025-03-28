@extends('layouts.app')

@section('title', 'Donasi')

@section('content')
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                <p>Anda akan berdonasi sebesar <strong>{{ number_format($details['amount']) }}</strong></p>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="anonymousCheckbox">
                    <label class="form-check-label" for="anonymousCheckbox">
                        Donasi sebagai anonim
                    </label>
                </div>

                <button type="button" class="btn btn-primary mt-3" id="btnPay">
                    Bayar
                </button>
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
                    is_anonymous: isAnonymous
                })
            }).then(response => response.json())
              .then(data => {
                  alert(data.message);
                  window.location.href = "{{ route('home') }}";
              });
        }
    </script>
@endsection
