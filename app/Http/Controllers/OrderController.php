<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $selectedItems = $request->query('selected_items');

        // 將這些 ID 轉換為數組，然後使用它們進行進一步的處理
        $selectedItemsArray = explode(',', $selectedItems);

        // 根據 $selectedItemsArray 獲取相應的商品信息，這可以通過你的數據庫模型或其他方式完成
        $selectedCartItems = CartItem::whereIn('id', $selectedItemsArray)->get();

        // 現在，$selectedProducts 將包含所選商品的信息，你可以將它傳遞給結帳視圖
        return view('orders.create', ['selectedCartItems' => $selectedCartItems]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
