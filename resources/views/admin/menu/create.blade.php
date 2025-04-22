@extends('layouts.app')

@section('styles')
<style>
    body {
        background-color: #000;
        color: #fff;
    }

    .card {
        background-color: #111;
        border: 1px solid #333;
        color: #fff;
    }

    .card-header {
        background-color: #000;
        color: #fff;
        border-bottom: 1px solid #444;
        border-radius: 5px;
    }

    .form-label {
        color: #fff;
    }

    .form-control,
    .input-group-text,
    select,
    textarea {
        background-color: #222;
        color: #fff;
        border: 1px solid #555;
    }

    .form-control::placeholder {
        color: #aaa;
    }

    .input-group-text {
        background-color: #111;
        color: #fff;
    }

    .btn-primary {
        background-color: #fff;
        color: #000;
        border: none;
    }

    .btn-primary:hover {
        background-color: #ddd;
        color: #000;
    }

    .btn-warning {
        background-color: #444;
        color: #fff;
        border: 1px solid #666;
    }

    .btn-warning:hover {
        background-color: #666;
        color: #fff;
    }

    .invalid-feedback,
    .text-danger {
        color: #f88;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header">Tambah menu</div>

                <div class="card-body">
                    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama menu</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                    value="{{ old('nama') }}" placeholder="Masukkan nama menu" required>
                            </div>
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga menu</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                                    value="{{ old('harga') }}" placeholder="Masukkan harga" required>
                            </div>
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok', $menu->stok ?? 0) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                rows="3" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar menu</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" required>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list-alt mr-2"></i></span>
                                <select class="form-control @error('category_id') is-invalid @enderror ml-2" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                           <i class="fas fa-save me-1"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-warning">
                          <i class="fas fa-redo me-1"></i> Reset
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
