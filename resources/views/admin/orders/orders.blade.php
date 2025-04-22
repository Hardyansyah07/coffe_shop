@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-2 mt-2">{{ __('Daftar Pembayaran dan Pesanan') }}</h5>
                </div>
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
                                    <th>Total</th>
                                    <th>Detail Pesanan</th>
                                    <th>Aksi Pembayaran</th>
                                    <th>Aksi Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
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
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.items.show', $order->id) }}" class="btn btn-info btn-sm">Detail Pesanan</a>
                                    </td>
                                    <td>
                                        @if($order->payment_status == 'pending')
                                            @if($order->payment_method == 'Cash')
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cashPaymentModal"
                                                    data-id="{{ $order->id }}" data-total="{{ $order->total }}">
                                                    Konfirmasi Pembayaran
                                                </button>
                                            @else
                                                <form action="{{ route('orders.updatePayment', ['id' => $order->id, 'status' => 'paid']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        Konfirmasi Pembayaran
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Sudah Dibayar</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->order_status == 'pending')
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('orders.updateStatus', ['id' => $order->id, 'status' => 'completed']) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" {{ $order->payment_status == 'paid' ? '' : 'disabled' }}>
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

                <!-- Modal Konfirmasi Pembayaran Cash -->
                <div class="modal fade" id="cashPaymentModal" tabindex="-1" role="dialog" aria-labelledby="cashPaymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cashPaymentModalLabel">Konfirmasi Pembayaran Cash</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="cashPaymentForm" method="POST" action="">
                                @csrf
                                <div class="modal-body">
                                    <p><strong>Total Harga: </strong>Rp <span id="totalSetelahPajak">0</span></p>
                                    <div class="form-group">
                                        <label for="uangDibayar">Uang Dibayar</label>
                                        <input type="number" class="form-control" id="uangDibayar" name="uang_dibayar" min="0" required>
                                    </div>
                                    <input type="hidden" id="hiddenUangDibayar" name="uang_dibayar">
                                    <input type="hidden" id="hiddenKembalian" name="kembalian">
                                    <p><strong>Kembalian: </strong>Rp <span id="uangKembalian">0</span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentTotal = 0;

$('#cashPaymentModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let orderId = button.data('id');
    let total = parseFloat(button.data('total'));

    currentTotal = isNaN(total) ? 0 : total;

    $('#totalSetelahPajak').text(currentTotal.toLocaleString('id-ID'));
    $('#uangDibayar').val('');
    $('#uangKembalian').text('0');

    $('#hiddenUangDibayar').val('');
    $('#hiddenKembalian').val('0');

    let form = $(this).find('#cashPaymentForm');
    let actionUrl = "{{ route('orders.updatePayment', ['id' => ':orderId', 'status' => 'paid']) }}"
        .replace(':orderId', orderId);
    form.attr('action', actionUrl);
});

// DIPINDAH KE LUAR
$('#uangDibayar').on('input', function () {
    let uangDibayar = parseFloat($(this).val()) || 0;
    let kembalian = uangDibayar - currentTotal;

    $('#uangKembalian').text(kembalian >= 0 ? kembalian.toLocaleString('id-ID') : '0');
    $('#hiddenUangDibayar').val(uangDibayar);
    $('#hiddenKembalian').val(kembalian >= 0 ? kembalian : 0);
});
</script>
@endsection
