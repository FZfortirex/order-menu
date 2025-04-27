<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'redeem_point_id', 'table', 
        'additional_note', 'total_price', 'status', 'total_point'
    ];

    public function indexDashboard()
    {
        $orders = Order::with('user')->get();
        return view('dashboard', compact('orders'));
    }

    public function indexDekstop()
    {
        $orders = Order::with('user')->get();
        return view('admin.list-order-desktop', compact('orders'));
    }

    public function indexMobile()
    {
        $orders = Order::with('user')->get();
        return view('admin.list-order-mobile', compact('orders'));
    }

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
