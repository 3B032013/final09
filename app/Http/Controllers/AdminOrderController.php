<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $orders = Order::orderby('id','ASC')->paginate($perPage);
        $data = ['orders' => $orders];
        return view('admins.orders.index',$data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);

        $orders = Order::whereHas('seller.user', function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'like', "%$query%");
        })
            ->orWhereHas('user', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%");
            })
            ->paginate($perPage);

        return view('admins.orders.index', [
            'orders' => $orders,
            'query' => $query,
        ]);
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
