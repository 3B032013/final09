<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Comment;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $data = ['orders' => $orders];

        return view('orders.index',$data);
    }

    public function filter(Request $request)
    {
        $status = $request->input('status');
        $status2 = $request->input('status2');
        $status3 = $request->input('status3');
        $status4 = $request->input('status4');

        $orders = Order::whereIn('status', [$status, $status2,$status3,$status4])->get();

        // You can pass $orders to the view and display the filtered orders

        // Redirect back to the order list
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedItems = $request->query('selected_items');

        $selectedItemsArray = explode(',', $selectedItems);

        $selectedCartItems = CartItem::whereIn('id', $selectedItemsArray)
            ->with('product')
            ->get()
            ->sortBy(function ($cartItem) {
                return $cartItem->product->seller_id;
            });

        $shippingFees = [];

        foreach ($selectedCartItems as $cartItem) {
            $sellerId = $cartItem->product->seller->id;

            if (!isset($shippingFees[$sellerId])) {
                $shippingFees[$sellerId] = 60;
            }
        }
        $totalShippingFee = array_sum($shippingFees);

        return view('orders.create', ['selectedCartItems' => $selectedCartItems],['totalShippingFee' => $totalShippingFee]);
    }

    public function show_create(Request $request)
    {
        $selectedItems = $request->input('selected_items');

        $selectedCartItems = Product::where('id', $selectedItems)
            ->first();

        return view('orders.show_create', ['selectedCartItems' => $selectedCartItems]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show_store(StoreOrderRequest $request, Product $product)
    {
        // 創建一個新的訂單
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->seller_id = 1;
        $order->status = 0;
        $order->date = now();
        $order->pay = 0;

        // 使用 $product 來獲取價格
        $order->price = $product->price + 60;

        $order->receiver = $request->receiver;
        $order->receiver_phone = $request->receiver_phone;
        $order->receiver_address = $request->receiver_address;

        // 儲存訂單
        $order->save();

        // 創建一個新的訂單明細
        $orderDetail = new OrderItem();
        $orderDetail->order_id = $order->id;
        $orderDetail->product_id = $product->id; // 使用 $product->id 來獲取商品ID
        $orderDetail->quantity = 1;

        // 儲存訂單明細
        $orderDetail->save();

        // 扣除商品庫存
        $product->decrement('inventory', 1);

        // 檢查庫存是否為 0，如果是，設置商品的 status 為 4
        if ($product->inventory === 0) {
            $product->update(['status' => 4]);
        }

        return redirect()->route('home');
    }


    public function store(StoreOrderRequest $request)
    {
        // 先獲取購物車商品資訊
        $selectedItems = json_decode($request->input('selected_items'), true);

        // 這裡假設你已經登入並取得會員資訊
        $user = auth()->user();

        // 將購物車商品與商品資料表連結
        $productsByCartItem = collect($selectedItems)->map(function ($item) {
            // 利用product_id關聯
            $product = Product::find($item['product_id']);

            // 回傳商品 &　購物車商品連結
            return [
                'product' => $product,
                'cart_item' => $item,
            ];
        });

        // 檢查所有商品庫存是否足夠
        if ($this->checkInventoryForAll($productsByCartItem)) {
            // 遍歷分組後的商品，建立對應的訂單
            $productsByCartItem->groupBy(function ($item) {
                // 以seller_id區隔
                return $item['product']->seller_id;
            })->each(function ($items, $sellerId) use ($request, $user) {
                // 建立訂單
                $order = new Order();
                $order->user_id = $user->id;
                $order->seller_id = $sellerId;
                $order->status = 0;
                $order->date = now();
                $order->pay = 0;
                $order->price = $items->sum(function ($item) {
                        return $item['cart_item']['quantity'] * $item['cart_item']['product']['price'];
                    }) + 60;
                $order->receiver = $request->receiver;
                $order->receiver_phone = $request->receiver_phone;
                $order->receiver_address = $request->receiver_address;

                // 儲存訂單
                $order->save();

                // 建立訂單明細
                foreach ($items as $item) {
                    $orderDetail = new OrderItem();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $item['cart_item']['product_id'];
                    $orderDetail->quantity = $item['cart_item']['quantity'];
                    // ...其他訂單明細相關欄位

                    // 儲存訂單明細
                    $orderDetail->save();

                    // 扣除商品庫存
                    Product::where('id', $item['cart_item']['product']['id'])->decrement('inventory', $item['cart_item']['quantity']);

                    // 檢查庫存是否為 0，如果是，設置商品的 status 為 4
                    $updatedInventory = Product::where('id', $item['cart_item']['product']['id'])->value('inventory');

                    if ($updatedInventory == 0) {
                        Product::where('id', $item['cart_item']['product']['id'])->update(['status' => 4]);
                    }
                }

                // 刪除購物車中的商品
                $productIdsToRemove = $items->pluck('cart_item.product_id');
                $user->cartItems()->whereIn('product_id', $productIdsToRemove)->delete();
            });

            return redirect()->route('home'); // 跳轉到你想要的路由
        } else {
            // 如果庫存不足，返回上一頁並帶上錯誤訊息
            return back()->withErrors(['error' => '庫存不足，請調整購買數量。']);
        }
    }

// 檢查所有商品庫存是否足夠
    private function checkInventoryForAll($productsByCartItem)
    {
        foreach ($productsByCartItem as $item) {
            $product = $item['product'];
            $quantity = $item['cart_item']['quantity'];

            if ($product['inventory'] < $quantity) {
                return false; // 如果有任一商品庫存不足，返回 false
            }
        }

        return true; // 所有商品庫存足夠
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // 获取订单关联的评论
        $comment = Comment::where('order_id', $order->id)->first();

        $orderDetails = OrderItem::where('order_id', $order->id)->get();

        $data = [
            'order_details' => $orderDetails,
            'has_comment' => $comment !== null, // 如果评论存在，has_comment 将为 true，否则为 false
            'orderId' => $order->id,
        ];

        return view('orders.show', $data);
    }

    public function payment($order_id)
    {
        $orderItems = orderItem::where('order_id', $order_id)->get();
        $data = ['orderItems' => $orderItems,
            'orderId' => $order_id,];

        return view('orders.payment', $data);
    }

    public function update_pay(StoreOrderRequest $request,Order $order)
    {
        $order->update([
            'status' => 1,
            'pay'=> 1,
            'bank_account'=> $request->bank_account,
            'month'=> $request->month,
            'year'=> $request->year,
            ]);
        return redirect()->route('orders.index');
    }

    public function complete_order(Order $order)
    {
        //
        $order->update([
            'status' => 5,
        ]);
        return redirect()->route('orders.index');
    }

    public function cancel_order(Order $order)
    {
        //
        $order->update([
            'status' => 7,
        ]);
        return redirect()->route('orders.index');
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
