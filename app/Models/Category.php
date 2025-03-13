<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    // Relasi ke tabel menus
    public function menu()
    {
        return $this->hasMany(Menu::class, 'category_id'); // Pastikan nama foreign key sesuai
    }
}
