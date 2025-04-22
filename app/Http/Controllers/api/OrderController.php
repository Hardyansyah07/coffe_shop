<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'no_meja' => 'required|integer',
            'payment_method' => 'required|in:Cash,Bank Transfer,E-Wallet',
            'items' => 'required|array|min:1',
            'items.*.nama' => 'required|string',
            'items.*.harga' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.ukuran' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Hitung subtotal
            $subtotal = collect($data['items'])->sum(function ($item) {
                return $item['harga'] * $item['quantity'];
            });

            $tax = $subtotal * 0.11;
            $total = $subtotal + $tax;

            // Buat Order
            $order = Order::create([
                'name' => $data['name'],
                'no_meja' => $data['no_meja'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            // Tambahkan setiap item
            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'nama' => $item['nama'],
                    'harga' => $item['harga'],
                    'quantity' => $item['quantity'],
                    'ukuran' => $item['ukuran'],
                    'subtotal' => $item['harga'] * $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'order_id' => $order->id], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal membuat pesanan.'], 500);
        }
    }
}
