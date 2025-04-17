<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id', 'menu_id', 'packaging', 'note', 'quantity', 'items_price'
    ];

    // Relasi dengan Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
