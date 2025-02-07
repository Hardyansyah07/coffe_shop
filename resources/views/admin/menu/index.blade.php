@extends('layouts.app')

@section('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        background: #fff;
    }

    .card-header {
        color: rgb(255, 255, 255);
        border-radius: 15px 15px 0 0 !important;
        padding: 1.2rem 1.5rem;
        background: #343a40;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border-top: none;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        color: #ffffff;
        padding: 1.2rem 1rem;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 1rem;
        border-color: #f8f9fa;
    }

    .menu-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .menu-image:hover {
        transform: scale(1.05);
    }

    .btn {
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #6c757d;
    }

    .menu-price {
        font-weight: 600;
        color: #28a745;
    }

    .menu-description {
        color: #6c757d;
        font-size: 0.875rem;
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
                                    <th width="5%">#</th>
                                    <th width="20%">Menu Name</th>
                                    <th width="15%">Price</th>
                                    <th width="25%">Description</th>
                                    <th width="15%">Image</th>
                                    <th width="10%">Category</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menu as $data)
                                    @if(stripos($data->nama, request('search')) !== false || empty(request('search')))
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
                                        <td>{{ $data->category_id }}</td>
                                        <td>
                                        <button type="button" class="btn {{ $data->is_active ? 'btn-success' : 'btn-danger' }} trigger-modal" 
                                                data-action="{{ route('admin.menu.toggle', $data->id) }}" 
                                                data-method="PATCH">
                                            {{ $data->is_active ? 'ON' : 'OFF' }}
                                        </button>

                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('admin.menu.edit', $data->id) }}" class="btn btn-sm btn-warning mr-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger trigger-modal" 
                                                        data-action="{{ route('admin.menu.destroy', $data->id) }}" 
                                                        data-method="DELETE">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                <tr>
                                    <td colspan="8" class="empty-state">
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

                <div class="card-footer bg-white">
                    {!! $menu->withQueryString()->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".trigger-modal").forEach(button => {
            button.addEventListener("click", function () {
                let actionUrl = this.getAttribute("data-action");
                let method = this.getAttribute("data-method");

                if (confirm("Apakah kamu yakin ingin melanjutkan aksi ini?")) {
                    let form = document.createElement("form");
                    form.method = "POST";
                    form.action = actionUrl;
                    form.innerHTML = `
                        <input type="hidden" name="_method" value="${method}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endsection