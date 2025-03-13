@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #4b2c01; color: white; border-radius: 5px;">
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
                                <span class="input-group-text" style="background-color: #4b2c01; color: white;"><i class="fas fa-utensils"></i></span>
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
                                <span class="input-group-text" style="background-color: #4b2c01; color: white;">Rp</span>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    name="harga" value="{{ $menu->harga }}" placeholder="Masukkan harga">
                            </div>
                            @error('harga')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stok">Stok</label>
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

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <span class="input-group-text" style="background-color: #4b2c01; color: white;"><i class="fas fa-list-alt mr-2"></i>
                            <select class="form-control @error('category_id') is-invalid @enderror ml-2" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
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