<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'user_discount_id', 'table', 
        'total_price', 'status', 'total_point'
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

    public function userDiscount()
    {
        return $this->belongsTo(UserDiscount::class);
    }

}
