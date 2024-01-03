<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $orders = Order::orderby('id','ASC')->paginate($perPage);
        $data = ['orders' => $orders];
        return view('sellers.orders.index',$data);
    }
    public function edit(Order $order)
    {
        $data = [
            'order'=> $order,
        ];
        return view('sellers.orders.edit',$data);
    }
    public function update(Request $request, Order $order)
    {

        $order->save();

        return redirect()->route('sellers.orders.index');
    }
    public function pass(Order $order)
    {
        $order->status='2';
        $order->save();
        return redirect()->route('sellers.orders.index');
    }
    public function unpass(Order $order)
    {
        $order->status='8';
        $order->save();
        return redirect()->route('sellers.orders.index');
    }
    public function transport(Order $order)
    {
        $order->status='3';
        $order->save();

        return redirect()->route('sellers.orders.index');
    }
    public function arrive(Order $order)
    {
        $order->status='4';
        $order->save();
        return redirect()->route('sellers.orders.index');
    }
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('sellers.orders.index');
    }

}
