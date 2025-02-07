<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Menu;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_meja' => 'required',
            'payment_method' => 'required',
            'payment_details' => 'required_if:payment_method,Bank Transfer',
        ]);

        // Hitung total harga dari session cart
        $cart = session('cart', []);
        $totalHarga = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // Buat pesanan baru dengan status pembayaran dan status pesanan yang terpisah
        $order = Order::create([
            'name' => $request->nama,
            'no_meja' => $request->no_meja, // Perbaikan dari no_telepon ke no_meja
            'subtotal' => $totalHarga,
            'payment_status' => 'pending', // Default pembayaran menunggu
            'order_status' => 'pending', // Default pesanan belum diproses
            'payment_method' => $request->payment_method,
            'payment_details' => json_encode($request->payment_details), // Simpan sebagai JSON
        ]);

        // Simpan detail pesanan ke tabel order_items
        foreach ($cart as $id => $details) {
            $order->items()->create([
                'menu_id' => $id,
                'harga' => $details['price'],
                'jumlah' => $details['quantity'],
            ]);
        }

        // Hapus keranjang setelah checkout
        session()->forget('cart');

        return redirect()->route('frontend.menu')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Fungsi untuk memperbarui status pembayaran
    public function updatePaymentStatus($id, Request $request)
    {
      
        $order = Order::findOrFail($id);
        $order->payment_status = $request->status;
        $order->save();


        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }

    // Fungsi untuk memperbarui status pesanan
    public function updateOrderStatus($id, Request $request)
    {
        $order = Order::findOrFail($id);
        $order->order_status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}
