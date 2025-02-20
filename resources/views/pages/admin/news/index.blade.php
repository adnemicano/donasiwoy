@extends('layouts.admin')

@section('heading', 'Data Berita')

@section('content')
    <a href="{{ route('admin.news.create') }}">
        <button class="btn btn-primary mb-3">Tambah Berita</button>
    </a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Tanggal Peristiwa</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $berita)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->title }}"
                                width="100">
                        </td>
                        <td>{{ $berita->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($berita->date)->format('d F Y') }}</td>
                        <td>
                            <a href="{{ route('admin.news.show', $berita->id) }}" class="btn btn-primary">Detail</a>
                            <a href="{{ route('admin.news.edit', $berita->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.news.destroy', $berita->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
