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

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function comment()
    {
        return $this->hasOne(comment::class);
    }

    public function calculateTotalProfit()
    {
        $totalProfit = 0;

        foreach ($this->orderItems as $orderItem) {
            // Assuming you have a relationship between OrderDetail and Product model
            $product = $orderItem->product;

            // Calculate the platform fee (5% of the product price times quantity)
            $platformFee = $product->price * 0.05 * $orderItem->quantity;

            // Accumulate the total profit (platform profit)
            $totalProfit += $platformFee;
        }

        return $totalProfit;
    }
}
