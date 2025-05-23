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
    }

    .card-header {
        background-color: #000;
        color: #fff;
        border-bottom: 1px solid #444;
        border-radius: 5px;
    }

    .form-control {
        background-color: #222;
        color: #fff;
        border: 1px solid #555;
    }

    .form-control::placeholder {
        color: #aaa;
    }

    .btn-outline-light {
        color: #fff;
        border-color: #fff;
    }

    .btn-outline-light:hover {
        background-color: #fff;
        color: #000;
    }

    .table-hover tbody tr:hover {
        background-color: #222;
    }

    .table thead th {
        color: #fff;
        background-color: #333;
        border-color: #444;
    }

    .table td {
        color: #fff;
        border-color: #444;
    }

    .menu-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 1px solid #666;
        border-radius: 4px;
    }

    .btn-warning,
    .btn-danger,
    .btn-success {
        color: #fff;
        border: none;
    }

    .btn-warning {
        background-color: #999;
    }

    .btn-danger {
        background-color: #c00;
    }

    .btn-success {
        background-color: #0a0;
    }

    .btn-warning:hover,
    .btn-danger:hover,
    .btn-success:hover {
        filter: brightness(1.2);
    }

    .card-footer {
        background-color: #000;
        color: #fff;
    }

    .pagination .page-link {
        background-color: #222;
        color: #fff;
        border: 1px solid #444;
    }

    .pagination .page-item.active .page-link {
        background-color: #fff;
        color: #000;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Menu Management') }}</h5>
                    <div class="d-flex">
                        <form action="{{ route('admin.menu.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Search menu..." value="{{ request('search') }}" oninput="this.form.submit()">
                            <select name="category" class="form-control ml-2" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <a href="{{ route('admin.menu.create') }}" class="btn btn-outline-light ml-2">
                            <i class="fas fa-plus mr-1"></i> Add New Menu
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Menu Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menu as $data)
                                    @if((stripos($data->nama, request('search')) !== false || empty(request('search'))) && (empty(request('category')) || $data->category_id == request('category')))
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="font-weight-bold">{{ $data->nama }}</td>
                                        <td class="menu-price">Rp {{ number_format($data->harga, 0, ',', '.') }}</td>
                                        <td class="menu-description" title="{{ $data->deskripsi }}">
                                            {{ $data->deskripsi }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('/storage/menus/' . $data->image) }}" class="menu-image" alt="{{ $data->nama }}">
                                        </td>
                                        <td>{{ optional($data->categories)->nama ?? 'No Category' }}</td>
                                        <td>{{ $data->stok }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-toggle-status {{ $data->is_active ? 'btn-success' : 'btn-danger' }}" 
                                                    data-id="{{ $data->id }}">
                                                {{ $data->is_active ? 'ON' : 'OFF' }}
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('admin.menu.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.menu.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <i class="fas fa-coffee fa-3x mb-3"></i>
                                        <h5>No Menu Items Available</h5>
                                        <p class="text-muted">Start by adding your first menu item.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {!! $menu->withQueryString()->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script>
$(document).ready(function() {
    $(document).on('click', '.btn-toggle-status', function() {
        let button = $(this);
        let menuId = button.data('id');

        let url = "{{ route('admin.menu.toggleStatus', ':id') }}".replace(':id', menuId);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    button.toggleClass('btn-success btn-danger');
                    button.text(response.is_active ? 'ON' : 'OFF');
                } else {
                    alert('Gagal memperbarui status.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('Terjadi kesalahan. Cek console.');
            }
        });
    });
});
</script>
@endpush
