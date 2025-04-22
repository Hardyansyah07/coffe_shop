@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="nota" class="p-4 border rounded shadow-sm bg-white">
        <div class="text-center mb-4">
            <h3 class="mb-1 font-weight-bold">NOTA PENJUALAN</h3>
            <h5 class="font-weight-bold text-uppercase"><i>CAFFE BrewTopia</i></h5>
            <p class="mb-1 font-weight-bold">Rancamanyar</p>
            <p class="mb-3 text-muted">Kabupaten Bandung, Jawa Barat</p>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>No. Pesanan:</strong> {{ $order->id }}</p>
                <p><strong>Nama Pelanggan:</strong> {{ $order->name }}</p>
            </div>
            <div class="col-md-6 text-md-right">
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Nomor Meja:</strong> {{ $order->no_meja }}</p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-dark text-center">
                <tr>
                    <th>No.</th>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $totalKeseluruhan = 0; 
                    $no = 1;
                @endphp
                @foreach($order->items as $item) 
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">{{ $item->quantity }} {{ $item->ukuran ?? '' }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @php $totalKeseluruhan += $item->subtotal; @endphp
                @endforeach
            </tbody>
        </table>

        @php 
            $tax = $totalKeseluruhan * 0.11; // Pajak 11%
            $totalSetelahPajak = $totalKeseluruhan + $tax; // Total setelah pajak
        @endphp

        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <table class="table table-sm">
                    <tr>
                        <th class="text-left">Subtotal</th>
                        <td class="text-right font-weight-bold">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Pajak (11%)</th>
                        <td class="text-right font-weight-bold">Rp {{ number_format($tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Total Setelah Pajak</th>
                        <td class="text-right font-weight-bold">Rp {{ number_format($totalSetelahPajak, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Metode Pembayaran</th>
                        <td class="text-right">{{ $order->payment_method }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Uang Dibayar</th>
                        <td class="text-right font-weight-bold">Rp {{ number_format($order->uang_dibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Kembalian</th>
                        <td class="text-right font-weight-bold">
                            @php 
                                $kembalian = max($order->uang_dibayar - $totalSetelahPajak, 0);
                            @endphp
                            Rp {{ number_format($kembalian, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted">Terima kasih telah berbelanja di <i>CAFFE BrewTopia</i></p>
        </div>
    </div>

    <div class="text-right mt-4">
        <button onclick="cetakNota()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak Nota
        </button>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #nota, #nota * {
            visibility: visible;
        }
        #nota {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
    
    .table th, .table td {
        vertical-align: middle;
    }

    .table thead th {
        background-color: #343a40;
        color: white;
    }

    .border {
        border: 2px solid #ddd !important;
    }

    .rounded {
        border-radius: 10px !important;
    }

    .shadow-sm {
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1) !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .text-uppercase {
        text-transform: uppercase !important;
    }

    .font-weight-bold {
        font-weight: bold !important;
    }
</style>

<script>
    function cetakNota() {
        let printContent = document.getElementById("nota").innerHTML;
        let originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>
@endsection
