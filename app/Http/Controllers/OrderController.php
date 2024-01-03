<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderItem;
use App\Models\Product;
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

        // 將購買的商品以賣家做區隔
        $groupedItems = $productsByCartItem->groupBy(function ($item) {
            // 以seller_id區隔
            return $item['product']->seller_id;
        });

        // 遍歷分組後的商品，建立對應的訂單
        $groupedItems->each(function ($items, $sellerId) use ($request, $user) {
            // 建立訂單
            $order = new Order();
            $order->user_id = $user->id;
            $order->seller_id = $sellerId; // 賣家的 ID
            $order->status = 0; // 這裡可以根據需求填入適當的初始狀態
            $order->date = now(); // 或者你想要的訂單日期
            $order->pay = 0;
            # 抓取該在該賣家購買的訂單總額
            $sellerTotal = $items->sum(function ($item) {
                return $item['cart_item']['quantity'] * $item['cart_item']['product']['price'];
            });
            $order->price = $sellerTotal+60;
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


                // 訂單建立後，將商品資料表的庫存扣除
                $product = $item['cart_item']['product'];
                $quantity = $item['cart_item']['quantity'];
                // 檢查庫存是否足夠
                if ($product['inventory'] >= $quantity) {
                    // 扣除商品庫存
                    $product['inventory'] -= $quantity;
                    Product::where('id', $product['id'])->update(['inventory' => $product['inventory']]);
                }
            }

            $productIdsToRemove = $items->pluck('cart_item.product_id');
            $user->cartItems()->whereIn('product_id', $productIdsToRemove)->delete();
        });

        return redirect()->route('home'); // 跳轉到你想要的路由
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
