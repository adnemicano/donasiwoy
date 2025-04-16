@extends('layouts.admin')

@section('heading', 'Data Berita')

@section('content')
    <a href="{{ route('admin.news.create') }}">
        <button class="btn btn-primary mb-3">Tambah Berita</button>
    </a>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Thumbnail</th>
                    <th style="width: 35%">Judul</th>
                    <th style="width: 20%">Tanggal Peristiwa</th>
                    <th style="width: 25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $berita)
                    <tr>
                        <td>{{ $news->firstItem() + $loop->index }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->title }}"
                                width="100" class="img-thumbnail">
                        </td>
                        <td>{{ $berita->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($berita->date)->format('d F Y') }}</td>
                        <td>
                            <a href="{{ route('admin.news.show', $berita->id) }}" class="btn btn-sm btn-primary mb-1">Detail</a>
                            <a href="{{ route('admin.news.edit', $berita->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                            <form action="{{ route('admin.news.destroy', $berita->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger mb-1"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $news->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
