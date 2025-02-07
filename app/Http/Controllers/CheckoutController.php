<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function showFrontendCheckout()
    {
        return view('frontend.checkout');
    }

    public function confirmation(Request $request)
{
   
    try {
        DB::beginTransaction();

        Log::info('Received checkout data:', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'no_meja' => 'required|string|max:15',
            'items' => 'required|array|min:1',
            'items.*.nama' => 'required|string',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'required|string',
            'paymentDetails' => 'required',
            'paymentDetails.bank_name' => 'required_if:payment_method,bank_transfer|string',
            'paymentDetails.account_number' => 'required_if:payment_method,bank_transfer|string',
            'paymentDetails.provider' => 'required_if:payment_method,e_wallet|string',
            'paymentDetails.number' => 'required_if:payment_method,e_wallet|string',
        ]);
            // Hitung total harga
            $totalSubtotal = 0;
            foreach ($validatedData['items'] as $item) {
                $itemSubtotal = $this->calculateItemSubtotal(
                    floatval($item['harga']),
                    intval($item['quantity']),
                    $item['size']
                );
                $totalSubtotal += $itemSubtotal;
            }
      
            // Simpan order ke database
            $order = Order::create([
                'name' => $validatedData['name'],
                'no_meja' => $validatedData['no_meja'],
                'subtotal' => $totalSubtotal,
                'payment_method' => $validatedData['paymentDetails']['method'], // **Perbaikan**
                'payment_details' => json_encode($validatedData['paymentDetails']), // **Perbaikan**
                'status' => 'pending',
            ]);

            // Simpan item ke order_items
            foreach ($validatedData['items'] as $item) {
                $itemSubtotal = $this->calculateItemSubtotal(
                    floatval($item['harga']),
                    intval($item['quantity']),
                    $item['size']
                );

                OrderItem::create([
                    'order_id' => $order->id,
                    'nama' => $item['nama'],
                    'harga' => floatval($item['harga']),
                    'quantity' => intval($item['quantity']),
                    'ukuran' => $item['size'],
                    'subtotal' => $itemSubtotal,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order berhasil dikonfirmasi!',
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function showConfirmation()
    {
        return view('frontend.confirmation');
    }

    private function calculateItemSubtotal($harga, $quantity, $size)
    {
        $adjustedPrice = match ($size) {
            'level 1' => $harga + 1000,
            'level 2' => $harga + 2000,
            'sedang' => $harga + 5000,
            'besar' => $harga + 10000,
            default => $harga,
        };

        return $adjustedPrice * $quantity;
    }
}
