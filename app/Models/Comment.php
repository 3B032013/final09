<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'buyer_rating',
        'buyer_message',
        'seller_rating',
        'seller_message',
    ];

    public function order()
    {
        return $this->belongsTo(order::class);
    }

    public static function getAverageScoreForProduct($productId)
    {
        $averageScore = self::whereHas('order.orderDetails.product', function ($query) use ($productId) {
            $query->where('products.id', $productId);
        })
            ->selectRaw('COALESCE(AVG(buying_rating), 0) AS average_score')
            ->pluck('average_score')
            ->first();

        return number_format($averageScore, 1); // Format the score with one decimal place
    }
}
