@extends('layouts.app')

@section('styles')
    body {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #343a40;
        color: #fff;
        font-weight: bold;
        text-align: center;
        font-size: 1.25rem;
        padding: 1rem;
        border-radius: 15px 15px 0 0;
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: bold;
        color: #343a40;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #80bdff;
    }

    .form-select {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1px solid #ced4da;
    }

    .form-select:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #80bdff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.5);
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.5);
    }

    .form-control-file {
        display: block;
        width: 100%;
        margin-top: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 10px;
    }
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
                            <span class="input-group-text"><i class="fas fa-list-alt mr-2"></i>
                            <select class="form-control @error('category_id') is-invalid @enderror ml-2" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama }}
                                    </option>
                                @endforeach
                            </select>
                            </span>
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