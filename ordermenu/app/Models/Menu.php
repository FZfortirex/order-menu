<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'name', 'desc', 'image', 'price', 'category', 'stock', 'point'
    ];

    public function reviews()
    {      
        return $this->hasMany(Review::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

}