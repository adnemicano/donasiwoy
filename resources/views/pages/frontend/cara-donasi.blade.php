@extends('layouts.app')

@section('title', 'Cara Donasi')

@section('content')

    <style>

        .txt-judul {
            font-size: 2rem;
        }

        .txt-judul-span {
            color: #3AA597;
            font-weight: 600;
            font-size: 3rem;
        }

        p {
            color: #16423C;
            font-size: 1.1rem;
            line-height: 1.5;
        }

        /* Step-by-step section styling */
        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .step-number {
            background-color: #16423C;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.25rem;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            margin-right: 15px;
        }

        .step-number::before {
            content: "";
            position: absolute;
            background-color: #3AA597;
            height: 100%;
            width: 25px;
            border-top-left-radius: 25px;
            border-bottom-left-radius: 25px;
            left: -12px;
            z-index: -1;
        }

        .step-content h5 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #16423C;
            margin-bottom: 5px;
        }

        .bg-circle {
            background-color: #16423C;
        }

        .text-circle {
            font-weight: 600;
            color: #fff
        }

        .title-step {
            color: #3AA597;
            font-weight: 600;
        }

        .step-content p {
            font-size: 1rem;
            color: #3AA597;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .row.align-items-center {
                flex-direction: column-reverse;
                text-align: center;
            }

            .col-md-6 {
                margin-bottom: 20px;
            }
        }
    </style>


    <div class="container mt-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="txt-judul">Bagaimana Cara</h2>
                <h2 class="txt-judul-span">Melakukan Donasi?</h2>
                <p>Waktu terus berjalan, namun penderitaan mereka tidak. Mari bersama-sama bergerak cepat untuk
                    meringankan beban mereka sebab donasi Anda sangat berarti.</p>
            </div>
            <div class="col-md-6 text-center">
                <!-- Component Image -->
                <img src="{{ asset('assets/img/homeless1.png') }}" alt="Cara Donasi Image" class="img-fluid"
                    style="max-width: 300px;">
            </div>
        </div>

        <!-- Step-by-step guide -->
        <div class="row mt-5">
            @php
                $steps = [
                    [
                        'number' => 1,
                        'title' => 'Register / membuat akun terlebih dahulu',
                        'description' =>
                            'Donatur wajib memiliki akun sebelum melakukan donasi. Jika belum membuat akun, silakan klik pada button register di pojok kanan atas.',
                    ],
                    [
                        'number' => 2,
                        'title' => 'Login jika sudah mempunyai akun',
                        'description' => 'Klik button login pada pojok kanan atas apabila sudah mendaftarkan akun.',
                    ],
                    [
                        'number' => 3,
                        'title' => 'Klik campaign yang akan didonasikan',
                        'description' =>
                            'Donatur bisa membuka menu campaign yang ada di navigasi bar kemudian memilih campaign mana yang ingin didonasikan.',
                    ],
                    [
                        'number' => 4,
                        'title' => 'Cek detail dari campaign tersebut',
                        'description' =>
                            'Klik button "detail" yang ada pada card campaign untuk membaca detail dari campaign yang dipilih.',
                    ],
                    [
                        'number' => 5,
                        'title' => 'Isi nominal yang akan didonasikan',
                        'description' => 'Donatur mengisi nominal yang akan didonasikan.',
                    ],
                    [
                        'number' => 6,
                        'title' => 'Konfirmasi nominal donasi',
                        'description' => 'Donatur mengonfirmasi apakah nominal yang akan didonasikan sudah sesuai.',
                    ],
                    [
                        'number' => 7,
                        'title' => 'Pilih metode pembayaran',
                        'description' => 'Donatur dapat memilih metode pembayaran untuk melakukan donasi.',
                    ],
                    [
                        'number' => 8,
                        'title' => 'Donatur melakukan pembayaran',
                        'description' => 'Donatur melakukan pembayaran sesuai dengan metode yang dipilih.',
                    ],
                ];
            @endphp

            @foreach ($steps as $step)
                <div class="col-md-6 mb-4 d-flex">
                    <div class="me-3">
                        <div class="rounded-circle bg-circle text-circle d-flex justify-content-center align-items-center"
                            style="width: 50px; height: 50px;">
                            <h4 class="m-0">{{ $step['number'] }}</h4>
                        </div>
                    </div>
                    <div>
                        <h5 class="title-step">{{ $step['title'] }}</h5>
                        <p>{{ $step['description'] }}</p>
                        <!-- Menambahkan gambar untuk langkah -->
                        <img src="{{ asset('assets/img/step' . $step['number'] . '.png') }}"
                            alt="Step {{ $step['number'] }}" class="img-fluid mt-2" style="max-width: 500px;">
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
