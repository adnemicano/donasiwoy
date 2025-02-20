{{-- extends berguna untuk menggunakan layout pada admin layout --}}
@extends('layouts.admin')

{{-- section digunakan untuk mengisi yield yang ada di admin layout --}}
@section('heading', 'Tambah Berita')

@section('content')

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Thumbnail Berita</label>
            <label for="input-file" id="change-this-drop-area" class="drop-area">
                <input type="file" name="thumbnail" id="input-file" accept="image/*" hidden>
                <div id="img-view" class="img-view">
                    <img src="https://cdn.jsdelivr.net/gh/xrafffcode/flex-uploader/dist/images/gallery-export.svg"
                        id="img" width="50">
                    <p id="img-info">Chose Image To Upload</p>
                </div>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Judul Berita</label>
            <input type="text" class="form-control" name="title">
        </div>
        <div class="mb-3">
            <label class="form-label">Cerita</label>
            <textarea class="form-control" rows="3" name="content"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Peristiwa</label>
            <input type="date" class="form-control" name="date">
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>

@endsection

@section('script')
    <script>
        new FlexUploader("drop-area", "input-file", "img-view");
    </script>
@endsection
{{-- yield itu tempat, section itu isi --}}
