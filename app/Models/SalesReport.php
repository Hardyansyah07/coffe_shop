<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'date', 'total_sold', 'total_revenue'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
