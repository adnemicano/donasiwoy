@extends('layouts.app')

@section('title', 'Donasi')

@section('content')
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                <p>Anda akan berdonasi sebesar {{ number_format($details['amount']) }}</p>
                <button type="button" class="btn btn-primary" id="btnPay">
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
            snap.pay('{{ $details['snap_token'] }}', {
                // Optional
                onSuccess: function(result) {
                    alert(JSON.stringify(result));
                },
                // Optional
                onPending: function(result) {
                    alert(JSON.stringify(result));
                },
                // Optional
                onError: function(result) {
                    alert(JSON.stringify(result));
                }
            });
        };
    </script>
@endsection
