<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image', 'menu_id'
    ];

    // Relasi dengan Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
