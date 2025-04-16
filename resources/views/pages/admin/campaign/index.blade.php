@extends('layouts.admin')

@section('heading', 'Data Campaign')

@section('content')
    <a href="{{ route('admin.campaigns.create') }}">
        <button class="btn btn-primary mb-3">Tambah Campaign</button>
    </a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Target</th>
                    <th scope="col">Tanggal Berakhir</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campaigns as $campaign)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            <img src="{{ asset('storage/' . $campaign->thumbnail) }}" alt="{{ $campaign->title }}"
                                width="100">
                        </td>
                        <td>{{ $campaign->title }}</td>
                        <td>Rp. {{ number_format($campaign->target) }}</td>
                        <td>{{ \Carbon\Carbon::parse($campaign->end_date)->format('d F Y') }}</td>
                        <td>
                            <a href="{{ route('admin.campaigns.show', $campaign->id) }}" class="btn btn-primary">Detail</a>
                            <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST"
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

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-3">
            {{ $campaigns->withQueryString()->links('pagination::bootstrap-4') }}
        </div>

    </div>

@endsection
