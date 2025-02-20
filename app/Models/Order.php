<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'no_meja',
        'subtotal', 
        'tax', // Tambahkan pajak ke fillable
        'total', // Tambahkan total ke fillable
        'uang_dibayar', 
        'kembalian', 
        'payment_status',
        'order_status', 
        'payment_method', 
        'payment_details'
    ];

    // Mutator untuk menghitung pajak dan total secara otomatis
    public function setSubtotalAttribute($value)
    {
        $tax = $value * 0.11; // Pajak 11%
        $this->attributes['subtotal'] = $value;
        $this->attributes['tax'] = $tax;
        $this->attributes['total'] = $value + $tax; // Total setelah pajak
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
