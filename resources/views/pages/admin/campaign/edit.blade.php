{{-- extends berguna untuk menggunakan layout pada admin layout --}}
@extends('layouts.admin')

{{-- section digunakan untuk mengisi yield yang ada di admin layout --}}
@section('heading', 'Edit Campaign')

@section('content')

    <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Thumbnail Campaign</label>
            <label for="input-file" id="change-this-drop-area" class="drop-area">
                <input type="file" name="thumbnail" id="input-file" accept="image/*" hidden>
                <div id="img-view" class="img-view">
                    @if ($campaign->thumbnail)
                        <img src="{{ asset('storage/' . $campaign->thumbnail) }}" id="img" width="100">
                        <p id="img-info">Ganti Gambar</p>
                    @else
                        <img src="https://cdn.jsdelivr.net/gh/xrafffcode/flex-uploader/dist/images/gallery-export.svg"
                            id="img" width="50">
                        <p id="img-info">Chose Image To Upload</p>
                    @endif
                </div>
            </label>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Campaign</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $campaign->title) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Cerita</label>
            <textarea class="form-control" rows="3" name="story">{{ old('story', $campaign->story) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Target</label>
            <input type="number" class="form-control" name="target" value="{{ old('target', $campaign->target) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Berakhir</label>
            <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $campaign->end_date) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

@endsection

@section('script')
    <script>
        new FlexUploader("drop-area", "input-file", "img-view");
    </script>
@endsection
{{-- yield itu tempat, section itu isi --}}
