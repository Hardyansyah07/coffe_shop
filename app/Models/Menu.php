<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['category_id', 'nama', 'deskripsi', 'harga', 'image', 'stok', 'is_active'];

     public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
