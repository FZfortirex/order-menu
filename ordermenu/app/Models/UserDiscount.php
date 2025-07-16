<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDiscount extends Model
{
    protected $fillable = [
        'user_id', 'reward_id', 'is_used', 'order_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {      
        return $this->belongsTo(Reward::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
