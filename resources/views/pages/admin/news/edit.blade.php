{{-- extends berguna untuk menggunakan layout pada admin layout --}}
@extends('layouts.admin')

{{-- section digunakan untuk mengisi yield yang ada di admin layout --}}
@section('heading', 'Edit Berita')

@section('content')

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Thumbnail Berita</label>
            <label for="input-file" id="change-this-drop-area" class="drop-area">
                <input type="file" name="thumbnail" id="input-file" accept="image/*" hidden>
                <div id="img-view" class="img-view">
                    @if ($news->thumbnail)
                        <img src="{{ asset('storage/' . $news->thumbnail) }}" id="img" width="100">
                    @else
                        <img src="https://cdn.jsdelivr.net/gh/xrafffcode/flex-uploader/dist/images/gallery-export.svg"
                            id="img" width="50">
                    @endif
                    <p id="img-info">Choose Image To Upload</p>
                </div>
            </label>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul Berita</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $news->title) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Cerita</label>
            <textarea class="form-control" rows="3" name="content">{{ old('content', $news->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Peristiwa</label>
            <input type="date" class="form-control" name="date" value="{{ old('date', $news->date) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

@endsection

@section('script')
    <script>
        new FlexUploader("drop-area", "input-file", "img-view");
    </script>
@endsection