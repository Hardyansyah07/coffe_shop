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

    .img-thumbnail {
        border: 1px solid #666;
        background-color: #222;
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

    .btn-light {
        background-color: #333;
        color: #fff;
        border: 1px solid #555;
    }

    .btn-light:hover {
        background-color: #444;
    }

    .invalid-feedback,
    .text-danger {
        color: #f88;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Edit Menu') }}</h5>
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Nama Menu</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ $menu->nama }}" placeholder="Masukkan nama menu">
                            </div>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Harga Menu</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    name="harga" value="{{ $menu->harga }}" placeholder="Masukkan harga">
                            </div>
                            @error('harga')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="stok">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok', $menu->stok ?? 0) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                name="deskripsi" rows="4" placeholder="Masukkan deskripsi">{{ $menu->deskripsi }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Gambar Menu</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            @if($menu->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/menus/'.$menu->image) }}" alt="{{ $menu->nama }}"
                                        class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
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

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <button type="reset" class="btn btn-light btn-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
