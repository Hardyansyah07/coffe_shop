@extends('layouts.app')

@section('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
        box-shadow: 0 4px 8px rgba(0,123,255,0.2);
    }

    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Kategori Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Kategori</label>
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->nama }}</td>
                                        <td>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">🗑</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($categories->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-folder-open fa-3x mb-3"></i>
                                <h5>Tidak ada kategori tersedia</h5>
                                <p class="text-muted">Mulai dengan menambahkan kategori baru.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        let formAction = '';
        let formMethod = '';

        document.querySelectorAll('.trigger-modal').forEach(button => {
            button.addEventListener('click', function() {
                formAction = this.dataset.action;
                formMethod = this.dataset.method;

                // Tampilkan modal
                modal.show();
            });
        });

        document.getElementById('confirmActionBtn').addEventListener('click', () => {
            const form = document.createElement('form');
            form.action = formAction;
            form.method = 'POST';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = formMethod;

            form.appendChild(csrfInput);
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        });
    });
</script>
@endsection
