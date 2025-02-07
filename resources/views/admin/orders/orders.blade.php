@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-2 mt-2">{{ __('Daftar Pembayaran dan Pesanan') }}</h5>
                </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pemesan</th>
                        <th>No. Meja</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Metode Pembayaran</th>
                        <th>No. Rekening/No. HP</th>
                        <th>Subtotal</th>
                        <th>Detail Pesanan</th>
                        <th>Aksi Pembayaran</th>
                        <th>Aksi Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    @php
                        $paymentDetails = json_decode($order->payment_details, true);
                    @endphp
                    <tr class="{{ $order->order_status == 'completed' ? 'table-success' : ($order->order_status == 'cancelled' ? 'table-danger' : '') }}">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->no_meja }}</td>
                        <td>
                        <span class="badge {{ strtolower($order->payment_status) == 'pending' ? 'bg-warning' : (strtolower($order->payment_status) == 'paid' ? 'bg-success' : 'bg-danger') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        </td>
                        <td>
                            <span class="badge {{ $order->order_status == 'pending' ? 'bg-warning' : ($order->order_status == 'completed' ? 'bg-success' : 'bg-danger') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td>{{ $paymentDetails['method'] ?? '-' }}</td>
                        <td>
                            @if($order->payment_method == 'Bank Transfer')
                                {{ $paymentDetails['bankName'] ?? '-' }} - {{ $paymentDetails['accountNumber'] ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $order->subtotal }}</td>
                        <td>
                            <a href="{{ route('admin.orders.items.show', $order->id) }}" class="btn btn-info btn-sm">Detail Pesanan</a>
                        </td>
                        <td>
                            @if($order->payment_status == 'pending')
                            <form action="{{ route('orders.updatePayment', ['id' => $order->id, 'status' => 'paid']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Konfirmasi pembayaran untuk pesanan ini?')">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>Sudah Dibayar</button>
                            @endif
                        </td>
                        <td>
                            @if($order->order_status == 'pending')
                            <div class="d-flex gap-2">
                                <form action="{{ route('orders.updateStatus', ['id' => $order->id, 'status' => 'completed']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan pesanan ini?')">
                                        Selesaikan
                                    </button>
                                </form>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelModal" data-id="{{ $order->id }}">
                                    Batalkan
                                </button>
                            </div>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>Sudah Diproses</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Pembatalan -->
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Konfirmasi Pembatalan Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cancellationReason">Alasan Pembatalan</label>
                        <textarea class="form-control" id="cancellationReason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="cancelOrderForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="reason" id="reasonInput">
                        <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#cancelModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var orderId = button.data('id');
        var actionUrl = "{{ route('admin.orders.update', ['id' => 'orderId', 'status' => 'cancelled']) }}".replace('orderId', orderId);

        var form = $(this).find('#cancelOrderForm');
        form.attr('action', actionUrl);

        form.find('button[type="submit"]').off('click').on('click', function() {
            var reason = $('#cancellationReason').val();
            $('#reasonInput').val(reason);
        });
    });
</script>
@endsection
