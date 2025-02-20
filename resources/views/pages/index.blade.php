@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section style="background: linear-gradient(to bottom, #3AA597, #ECDFCC); padding: 50px 20px; margin-bottom: 3rem;">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <!-- Judul -->
            <h1 style="font-size: 2.5rem; font-weight: bold; color: #ffffff; margin-bottom: 20px;">
                Bersama Donasi Woy,<br> Kita Wujudkan Perubahan!
            </h1>

            <!-- Kontainer Konten -->
            <div
                style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; width: 100%; gap: 30px; margin-top: 40px;">
                <!-- Konten Kiri -->
                <div style="flex: 1; text-align: center;">
                    <h2 style="font-size: 2.5rem; font-weight: bold; color: #ffffff; margin-bottom: 10px;">Suara Anda.</h2>
                    <p style="color: #ffffff; font-size: 1rem; margin-bottom: 20px;">Suarakan aksi nyata.</p>
                    <button
                        style="background-color: #3AA597; color: #ffffff; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">
                        PETISI
                    </button>
                </div>

                <!-- Gambar Tengah -->
                <div style="flex: 1; display: flex; justify-content: center;">
                    <img src="{{ asset('assets/img/vektor-home.png') }}" alt="Gambar Orang" style="width: 160%; max-width: 800px; margin-bottom: -50px;" />
                </div>

                <!-- Konten Kanan -->
                <div style="flex: 1; text-align: center;">
                    <h2 style="font-size: 2.5rem; font-weight: bold; color: #ffffff; margin-bottom: 10px;">Aksi Nyata.</h2>
                    <p style="color: #ffffff; font-size: 1rem; margin-bottom: 20px;">Jadikan perubahan bersama.</p>
                    <button
                        style="background-color: #3AA597; color: #ffffff; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px; cursor: pointer;">
                        <a href="{{ route('campaigns.index') }}" style="text-decoration: none; color: inherit;">DONASI</a>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section>

    </section>


@endsection
