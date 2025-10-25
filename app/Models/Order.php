<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'stripe_session_id',
        'payment_intent',
        'payment_method',
        'payment_status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
