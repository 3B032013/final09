<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Http\Requests\StorecommentRequest;
use App\Http\Requests\UpdatecommentRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create(Order $order)
    {


        return view('orders.comments.create', ['order' => $order]);
    }

    public function store(Request $request, Order $order)
    {
        $message = Comment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'buyer_message' => $request->input('buyer_message'),
                'buyer_rating' => $request->input('comment_rating'),
            ]
        );

        if ($message) {
            $message->save();
        }

        // 重定向到訂單列表頁面
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecommentRequest $request, comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(comment $comment)
    {
        //
    }
}
