<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sellers.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show($productId)
    {
        //
        if (Auth::check())
        {
            $user = Auth::user();
            $cartItems = $user->CartItems;

            $product = Product::where('id',$productId)->first();
            $averageScore = Comment::getAverageScoreForProduct($product->id);

            $AllMessages = Comment::getAllMessagesForProduct($product->id);
//            dd($AllMessages);
            $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                ->where('id', '!=', $product->id) // 排除當前產品
                ->inRandomOrder() // 隨機排序
                ->limit(4) // 限制取得的數量，根據你的需求調整
                ->get();


            $data = [
                'cartItems' => $cartItems,
                'product' => $product,
                'averageScore'=>$averageScore,
                'AllMessages'=>$AllMessages,
                'relatedProducts' => $relatedProducts,
            ];
            return view('products.show', $data);
        }
        else
        {

            $product = Product::where('id',$productId)->first();
            // 取得相同 product_category_id 的其他產品
            $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                ->where('id', '!=', $product->id) // 排除當前產品
                ->inRandomOrder() // 隨機排序
                ->limit(4) // 限制取得的數量，根據你的需求調整
                ->get();


            $data = [
                'product' => $product,
                'relatedProducts' => $relatedProducts,

            ];
            return view('products.show', $data);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // 搜尋商品
        $products = Product::where('name', 'like', "%$query%")
            ->where('status','=',3)
            ->get();

//        // 搜尋賣家
//        $sellers = Seller::where('name', 'like', "%$query%")->get();

        // 返回結果
        return view('products.search', [
            'products' => $products,
//            'sellers' => $sellers,
            'query' => $query,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('sellers.products.index');
    }

    public function by_category(Request $request,$category_id)
    {
        $selectedCategory = ProductCategory::find($category_id);
        $products = Product::where('product_category_id', $category_id)
            ->where('status', 3)
            ->get();

        return view('products.by_category', [
            'selectedCategory' => $selectedCategory,
            'products' => $products,
        ]);
    }

    public function by_category_search(Request $request,$category_id)
    {
        $query = $request->input('query');
        $selectedCategory = ProductCategory::find($category_id);
        $products = Product::where('product_category_id', $category_id)
            ->where('name', 'like', "%$query%")
            ->where('status', 3)
            ->get();

        return view('products.by_category', [
            'selectedCategory' => $selectedCategory,
            'products' => $products,
            'query' => $query,
        ]);
    }
}
