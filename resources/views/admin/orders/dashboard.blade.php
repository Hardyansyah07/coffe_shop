@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Statistik Ringkasan -->
<div class="col-md-12 mb-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="border-radius: 10px; background-color: #f8f9fa;">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-3x mb-2" style="color: black;"></i>
                    <h5 class="card-title text-dark">Total Pesanan</h5>
                    <p class="card-text fs-4 text-dark">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="border-radius: 10px; background-color: #f8f9fa;">
                <div class="card-body text-center">
                    <i class="fas fa-wallet fa-3x mb-2" style="color: black;"></i>
                    <h5 class="card-title text-dark">Pendapatan Hari Ini</h5>
                    <p class="card-text fs-4 text-dark">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="border-radius: 10px; background-color: #f8f9fa;">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-2" style="color: black;"></i>
                    <h5 class="card-title text-dark">Total Pengguna</h5>
                    <p class="card-text fs-4 text-dark">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Grafik Pendapatan -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background-color: #f8f9fa;">
                <div class="card-header" style="background-color: black; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <h4>Grafik Pendapatan</h4>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; background-color: #f8f9fa;">
                <div class="card-header" style="background-color: black; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <h4>Pesanan Terbaru</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="text-white" style="background-color: black;">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge" style="background-color: black; color: white;">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.items.show', $order->id) }}" class="btn btn-sm text-white"
                                           style="background-color: black; border-radius: 5px;">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let ctx = document.getElementById('revenueChart').getContext('2d');
        let revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($revenueLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($revenueData),
                    borderColor: 'black',
                    backgroundColor: 'rgba(0, 0, 0, 0.2)',
                    borderWidth: 2
                }]
            }
        });
    });
</script>
<!-- Tambahkan Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .btn:hover {
        opacity: 0.8;
        transition: 0.3s;
    }

    .shadow-sm {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table-hover tbody tr:hover {
        background-color: #E0E0E0;
    }

    .badge {
        padding: 8px 12px;
        font-size: 0.85rem;
        border-radius: 5px;
    }
    .card:hover {
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>
@endsection
