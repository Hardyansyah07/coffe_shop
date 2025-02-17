@extends('layouts.app')

@section('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        background: #fff;
        padding: 20px;
    }
    .card-header {
        color: #fff;
        background: #007bff;
        border-radius: 15px 15px 0 0;
        padding: 1.2rem 1.5rem;
        font-weight: bold;
    }
    .table {
        margin-bottom: 0;
        border-radius: 10px;
        overflow: hidden;
    }
    .table th {
        background: #007bff;
        color: white;
        text-transform: uppercase;
        font-size: 0.875rem;
        font-weight: bold;
        padding: 1rem;
    }
    .table td {
        vertical-align: middle;
        padding: 1rem;
    }
    .btn-generate {
        border-radius: 20px;
        padding: 0.5rem 1.5rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .btn-generate:hover {
        background: #0056b3;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas"></i> Laporan Penjualan
                </h5>
                
                <form action="{{ route('sales_reports.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-generate">
                        <i class="fas fa-sync-alt"></i> Generate Laporan
                    </button>
                </form>
            </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Jumlah Terjual</th>
                                    <th>Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td>{{ $report->date }}</td>
                                        <td>{{ $report->category->nama }}</td>
                                        <td class="text-center">{{ $report->total_sold }}</td>
                                        <td class="text-right">Rp {{ number_format($report->total_revenue, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Tidak ada data laporan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
