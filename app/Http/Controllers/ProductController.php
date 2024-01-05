<?php

namespace App\Http\Controllers;


use App\Models\Order;

use App\Models\Comment;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductCategory;
use App\Models\Seller;
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
            $seller_id=$user->seller->id;
            $product = Product::where('id',$productId)->first();

            $averageScore = Comment::getAverageScoreForProduct($product->id);

            $AllMessages = Comment::getAllMessagesForProduct($product->id);

            $productsCount = Product::where('seller_id', $seller_id)->count();

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
                'productsCount'=>$productsCount,
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
    public function by_seller(Request $request,$seller_id, $category_id = null)
    {
//        // 獲取所有商品類別
        $allCategories = ProductCategory::all();
//
//        // 根據 $seller_id 查詢賣家相關資訊
        $seller = Seller::findOrFail($seller_id);

        //$seller_id = $request->input('seller_id');
        $category_id = $request->input('category_id');
        // 如果提供了 $category_id，則僅顯示該類別的商品
        if ($category_id) {
            //$selectedCategory = $allCategories->find($category_id);
            //$products = $selectedCategory ? $selectedCategory->products : collect();
            // 獲取賣家的商品類別

            $products = Product::where('seller_id', $seller->id)
                ->when($category_id, function ($query) use ($category_id) {
                    return $query->where('product_category_id', $category_id);
                })
                ->where('status', 3)
                ->orderBy('id', 'ASC')
                ->get();
            $sellerCategories = $category_id ? $allCategories->whereIn('id', [$category_id]) : $allCategories;

        } else {
            // 如果未提供 $category_id，則顯示所有商品
            $products = $seller->products()
                ->where('status', 3)
                ->orderBy('id', 'ASC')->get();

            // 獲取賣家的所有商品類別
            $sellerCategories = $allCategories->whereIn('id', $products->pluck('product_category_id'));
        }

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'productsCount' => $products->count(),
        ];
//        dd($request->all());

        return view('products.by_seller', $data);
    }


    public function by_seller_search(Request $request, $seller_id,$categoryid)
    {
        $query = $request->input('query');

        $products = Product::where('seller_id', $seller_id)
            ->where('status', 3)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->orderBy('id', 'ASC')
            ->get();

        $seller = Seller::find($seller_id);

        $sellerCategories = ProductCategory::whereIn('id', $products->pluck('product_category_id'))->get();

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'query' => $query,
        ];

        return view('products.by_seller_search', $data);
    }

    public function by_seller_and_category($seller_id, $category_id)
    {
        $products = Product::where('seller_id', $seller_id)
            ->where('product_category_id', $category_id)
            ->where('status', 3)
            ->orderBy('id', 'ASC')
            ->get();

        $seller = Seller::find($seller_id);

        $sellerCategories = ProductCategory::whereIn('id', $products->pluck('product_category_id'))->get();

        $selectedCategory = ProductCategory::find($category_id);

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'selectedCategory' => $selectedCategory,
        ];

        return view('products.by_seller_and_category', $data);
    }

    public function by_seller_and_category_search(Request $request,$seller_id, $category_id)
    {
        $query = $request->input('query');

        $products = Product::where('seller_id', $seller_id)
            ->where('product_category_id', $category_id)
            ->where('status', 3)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->orderBy('id', 'ASC')
            ->get();

        $seller = Seller::find($seller_id);
        $sellerCategories = ProductCategory::whereIn('id', $products->pluck('product_category_id'))->get();
        $selectedCategory = ProductCategory::find($category_id);

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'selectedCategory' => $selectedCategory,
            'query' => $query,
        ];

        return view('products.by_seller_and_category_search', $data);
    }
}
