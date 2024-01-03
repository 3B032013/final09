<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::orderby('id','ASC')->get();
        $data = ['orders' => $orders];
        return view('admins.orders.index',$data);
    }

    public function show(Order $order)
    {
        $data = [
            'order'=> $order,
        ];
        return view('admins.orders.show',$data);
    }

    public function cancel(Request $request, Order $order)
    {
        $order->update(['status' => 7]);
        return redirect()->route('admins.orders.index');
    }
}
