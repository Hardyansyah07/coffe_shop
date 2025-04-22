<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_meja' => 'required|integer|min:1',
            'payment_method' => 'required|in:Cash,Bank Transfer,E-Wallet',
            'payment_details' => 'required_if:payment_method,Bank Transfer|array',
            'uang_dibayar' => 'nullable|numeric|min:0|required_if:payment_method,Cash',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        $totalHarga = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        if ($request->payment_method === 'Cash' && $request->uang_dibayar < $totalHarga) {
            return redirect()->back()->with('error', 'Uang yang dibayarkan kurang dari total harga!');
        }

        $tax = $totalHarga * 0.11; // Pajak 11%
        $totalSetelahPajak = $totalHarga + $tax; // Total setelah pajak

        $uangDibayar = $request->payment_method === 'Cash' ? $request->uang_dibayar : $totalSetelahPajak;
        $kembalian = $request->payment_method === 'Cash' ? $uangDibayar - $totalSetelahPajak : 0;

        $order = Order::create([
            'name' => $request->nama,
            'no_meja' => $request->no_meja,
            'subtotal' => $totalHarga, // Subtotal sebelum pajak
            'tax' => $tax, // Pajak 11%
            'total' => $totalSetelahPajak, // Total setelah pajak
            'uang_dibayar' => $uangDibayar,
            'kembalian' => $kembalian,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_details' => json_encode($request->payment_method === 'Bank Transfer' ? $request->payment_details : []),
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $id,
                'harga' => $details['price'],
                'jumlah' => $details['quantity'],
                'total_harga' => $details['price'] * $details['quantity'],
            ]);
        }

        session()->forget('cart');

        Alert::success('Berhasil', 'Pesanan berhasil dibuat!');
        return redirect()->route('frontend.menu')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function updatePaymentStatus(Request $request, $id, $status)
    {
        $order = Order::findOrFail($id);
    
        if ($status === 'paid') {
            $order->payment_status = 'paid';
            $order->uang_dibayar = $request->uang_dibayar;
            $order->kembalian = $request->kembalian;
            $order->save();
    
            return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
        }
    
        return redirect()->back()->with('error', 'Status pembayaran tidak valid.');
    }
    

public function updateOrderStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,processing,completed,cancelled',
    ]);

    $order = Order::findOrFail($id);

    // Update status pesanan
    $order->update(['order_status' => $request->status]);

    Alert::success('Berhasil', 'Status pesanan diperbarui.');
    return redirect()->back()->with('success', 'Status pesanan diperbarui.');
}

}
