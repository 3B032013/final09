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
        $averageScore = self::whereHas('order.orderItems.product', function ($query) use ($productId) {
            $query->where('products.id', $productId);
        })
            ->selectRaw('COALESCE(AVG(buyer_rating), 0) AS average_score')
            ->pluck('average_score')
            ->first();

        return number_format($averageScore, 1); // Format the score with one decimal place
    }

    public static function getAverageScoreForProducts($productIds)
    {
        $averageScores = [];

        foreach ($productIds as $productId) {
            $averageScore = self::whereHas('order.orderItems.product', function ($query) use ($productId) {
                $query->where('products.id', $productId);
            })
                ->selectRaw('COALESCE(AVG(buyer_rating), 0) AS average_score')
                ->pluck('average_score')
                ->first();

            $averageScores[$productId] = number_format($averageScore, 1);
        }

        return $averageScores;
    }

    public static function getAllMessagesForProduct($productId)
    {
        $messages = self::whereHas('order.orderItems.product', function ($query) use ($productId) {
            $query->where('products.id', $productId);
        })
            ->with('order.orderItems.product') // 如果需要取得其他相關資料，可以使用 with 方法
            ->get(['order_id', 'buyer_rating', 'buyer_message', 'created_at' ,'updated_at']);

        return $messages;
    }
}
