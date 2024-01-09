<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::user()->seller;
        $perPage = $request->input('perPage', 10);
        $orders = Order::orderby('id','ASC')->where('seller_id',$seller->id)->paginate($perPage);
        $data = ['orders' => $orders];
        return view('sellers.orders.index',$data);
    }

    public function search(Request $request)
    {
        $seller = Auth::user()->seller;
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);

        $orders = Order::where('seller_id', $seller->id)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('seller.user', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%$query%");
                })
                    ->orWhereHas('user', function ($subQuery) use ($query) {
                        $subQuery->where('name', 'like', "%$query%");
                    });
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        return view('sellers.orders.index', [
            'orders' => $orders,
            'query' => $query,
        ]);
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
    public function show()
    {
        $seller = Auth::user()->seller;
        $orders = Order::where('status','5')
            ->where('seller_id',$seller->id)
            ->orderby('id','ASC')->get();
        $data = ['orders' => $orders];
        return view('sellers.orders.show',$data);
    }


}
