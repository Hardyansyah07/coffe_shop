<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'no_meja','subtotal', 'payment_status','order_status', 'payment_method', 'payment_details'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}