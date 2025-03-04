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
                    <img src="{{ asset('assets/img/vektor-home.png') }}" alt="Gambar Orang"
                        style="width: 160%; max-width: 800px; margin-bottom: -50px;" />
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
 <!-- Bagian Mulai Donasi -->
 <section class="bg-gradient-to-b from-cyan-100 to-white relative">
    <div class="container mx-auto px-6 py-16">
        <div class="flex flex-col md:flex-row items-center justify-between min-h-screen">
            
            <!-- Gambar Box di Kiri -->
            <div class="flex-1 flex justify-start">
                <img src="{{ asset('images/box1.png') }}" alt="Box" class="w-40 md:w-56">
            </div>

            <!-- Konten Teks di Kanan -->
            <div class="flex-1 text-center md:text-left max-w-lg">
                <h1 class="text-2xl font-bold text-gray-800">Mulai Donasi Sekarang!</h1>
                
                <p class="text-gray-600 mt-2">
                    Setiap rupiah yang Anda donasikan akan digunakan secara transparan untuk membantu mereka yang terpuruk. 
                    Tidak hanya bantuan, tetapi juga menyebarkan cinta dan kepedulian kepada sesama.
                </p>

                <div class="mt-6">
                    <a href="#" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700">
                        Mulai Donasi
                    </a>
                    <p class="mt-2 text-gray-500">
                        atau <a href="#" class="text-blue-500 underline">Pelajari Cara Donasi</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Background Wave -->
    <div class="absolute bottom-0 left-0 w-full">
        <img src="{{ asset('images/wave.png') }}" alt="Wave Background" class="w-full">
    </div>
</section>

@endsection