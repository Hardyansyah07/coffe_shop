@extends('layouts.app')
@section('content')
<div class="container" >
    <div class="row justify-content-center">
        <div class="col-12 col-xl-12">
            <div class="card" >
                <div class="card-header" style="background-color: #4b2c01; color: white; border-radius: 5px;">Tambah menu</div>

                <div class="card-body">
                    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama menu</label>
                            <div class="input-group">
                            <span class="input-group-text" style="background-color: #4b2c01; color: white;"><i class="fas fa-utensils" ></i></span>
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
                                <span class="input-group-text" style="background-color: #4b2c01; color: white;">Rp</span>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                                value="{{ old('harga') }}" placeholder="Masukkan harga" required>
                            </div>
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stok">Stok</label>
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
                            <span class="input-group-text" style="background-color: #4b2c01; color: white;"><i class="fas fa-list-alt mr-2"></i>
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