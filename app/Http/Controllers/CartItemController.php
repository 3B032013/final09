<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems
            ->sortBy(function ($cartItem) {
                return $cartItem->product->seller_id;
            });

        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        $shippingFees = [];

        foreach ($cartItems as $cartItem) {
            $sellerId = $cartItem->product->seller->id;

            // 假設每個賣家的運費為60
            if (!isset($shippingFees[$sellerId])) {
                $shippingFees[$sellerId] = 60;
            }
        }
        $totalShippingFee = array_sum($shippingFees);

        $totalAmountWithoutShippingFee = $totalAmount - $totalShippingFee;

        $data = [
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
            'totalShippingFee' => $totalShippingFee,
            'totalAmountWithoutShippingFee' => $totalAmountWithoutShippingFee,
        ];

        return view('cart_items.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request, Product $product)
    {
        $user = Auth::user();
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // 商品已存在於購物車，更新數量
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->input('quantity'),
            ]);
        } else {
            // 商品不存在於購物車，新增購物車項目
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
            ]);
        }

//        return redirect()->back()->with('success', '成功加入購物車!');
        return redirect()->route('home');
    }

    public function addToCart(Product $product)
    {

        $user = Auth::user();
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // 商品已存在於購物車，更新數量
            $cartItem->update([
                'quantity' => $cartItem->quantity + 1,
            ]);
        } else {
            // 商品不存在於購物車，新增購物車項目
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

//        return redirect()->back()->with('success', '成功加入購物車!');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, $cartItem)
    {
        $cartItem = CartItem::findOrFail($cartItem);

        // 取得產品庫存量
        $inventory = $cartItem->product->inventory;

        // 使用min函數比較庫存量和請求的數量，選擇較小的值
        $updatedQuantity = min($inventory, $request->quantity);

        // 更新購物車項目的數量
        $cartItem->update(['quantity' => $updatedQuantity]);

        return redirect()->route('cart_items.index');
    }

    public function quantity_minus(CartItem $cartItem)
    {
        //
        $cartItem->quantity = max(1, $cartItem->quantity - 1);
        $cartItem->save();

        return redirect()->back()->with('success', 'Quantity decremented successfully.');
    }

    public function quantity_plus(CartItem $cartItem)
    {
        //
        $inventory = $cartItem->product->inventory;
        $cartItem->quantity = min($inventory, $cartItem->quantity + 1);
        $cartItem->save();

        return redirect()->back()->with('success', 'Quantity decremented successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart_items.index');
    }
}
