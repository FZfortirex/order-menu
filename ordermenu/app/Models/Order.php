<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'redeem_point_id', 'table', 
        'additional_note', 'total_price', 'status', 'total_point'
    ];

    // Relasi dengan tabel Item
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Relasi dengan User 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan redeem_point_id
    public function redeemPoint()
    {
        return $this->belongsTo(RedeemPoint::class);
    }
}
