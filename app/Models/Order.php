<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_id',
        'status',
        'date',
        'score',
        'comment',
        'pay',
        'price',
        'receiver',
        'receiver_phone',
        'receiver_address',
        'bank_account',
        'month',
        'year',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function comment()
    {
        return $this->hasOne(comment::class);
    }
}
