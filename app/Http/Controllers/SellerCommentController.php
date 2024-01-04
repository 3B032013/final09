<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Http\Requests\StorecommentRequest;
use App\Http\Requests\UpdatecommentRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerCommentController extends Controller
{
    public function index()
    {
        $orders = Order::where('status','5',)->orderby('id','ASC')->get();
        $data = ['orders' => $orders];
        return view('sellers.comments.index',$data);
    }
    public function edit(Order $order)
    {
        $data = [
            'order'=> $order,
        ];
        return view('sellers.comments.edit',$data);
    }
    public function update(Request $request, Order $order,$order_id)
    {
        $request->validate([
            // 其他驗證規則...
            'seller_rating' => 'nullable|integer|min:1|max:5',
        ]);
        $message = Comment::updateOrCreate(
            ['order_id' => $order_id],
            [
                'seller_message' => $request->input('seller_message'),
                'seller_rating' => $request->input('seller_rating'),
            ]
        );

        if ($message) {
            $message->save();
        }

        // 在這裡可以進一步處理其他邏輯
        //dd($request->all());
        return redirect()->route('sellers.comments.index');
    }
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('sellers.comments.index');
    }
}
