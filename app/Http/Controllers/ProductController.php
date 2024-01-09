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

            $productsCount = Product::where('seller_id', $seller_id)->where('status','3')->count();

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

            $seller_id=$product->seller->id;
            $productsCount = Product::where('seller_id', $seller_id)->count();
            $averageScore = Comment::getAverageScoreForProduct($product->id);
            $AllMessages = Comment::getAllMessagesForProduct($product->id);

            $data = [
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'averageScore'=>$averageScore,
                'AllMessages'=>$AllMessages,
                'productsCount'=>$productsCount,

            ];
            return view('products.show', $data);
        }
    }

    public function search(Request $request)
    {
        $perPage = $request->input('perPage', 12);
        $query = $request->input('query');

        // 搜尋商品
        $products = Product::where('name', 'like', "%$query%")
            ->where('status','=',3)
            ->paginate($perPage);

        $averageScores = Comment::getAverageScoreForProducts($products->pluck('id'));
//        // 搜尋賣家
//        $sellers = Seller::where('name', 'like', "%$query%")->get();

        // 返回結果
        return view('products.search', [
            'products' => $products,
//            'sellers' => $sellers,
            'query' => $query,
            'averageScores'=>$averageScores,
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
        $perPage = $request->input('perPage', 12);
        $selectedCategory = ProductCategory::find($category_id);
        $products = Product::where('product_category_id', $category_id)
            ->where('status', 3)
            ->paginate($perPage);

        $averageScores = Comment::getAverageScoreForProducts($products->pluck('id'));
        return view('products.by_category', [
            'selectedCategory' => $selectedCategory,
            'products' => $products,
            'averageScores'=>$averageScores,
        ]);
    }

    public function by_category_search(Request $request,$category_id)
    {
        $perPage = $request->input('perPage', 12);
        $query = $request->input('query');
        $selectedCategory = ProductCategory::find($category_id);
        $products = Product::where('product_category_id', $category_id)
            ->where('name', 'like', "%$query%")
            ->where('status', 3)
            ->paginate($perPage);
        $averageScores = Comment::getAverageScoreForProducts($products->pluck('id'));
        return view('products.by_category', [
            'selectedCategory' => $selectedCategory,
            'products' => $products,
            'averageScores'=>$averageScores,
            'query' => $query,
        ]);
    }
    public function by_seller(Request $request,$seller_id)
    {
        $perPage = $request->input('perPage', 12);
        $products = Product::where('seller_id', $seller_id)
            ->where('status', 3)
            ->orderby('id','ASC')->paginate($perPage);
        $seller = Seller::where('id', $seller_id)->first();
        $averageScores = Comment::getAverageScoreForProducts($products->pluck('id'));
        $originalSellerCategories = ProductCategory::whereIn('id', function ($query) use ($seller_id) {
            $query->select('product_category_id')
                ->from('products')
                ->where('seller_id', $seller_id)
                ->where('status', 3);
        })->get();
        $sellerCategories = $originalSellerCategories;

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'averageScores'=>$averageScores,
            'productsCount' => $products->count(),
        ];
        return view('products.by_seller', $data);
    }


    public function by_seller_search(Request $request, $seller_id)
    {
        $perPage = $request->input('perPage', 12);
        $query = $request->input('query');

        $originalSellerCategories = ProductCategory::whereIn('id', function ($query) use ($seller_id) {
            $query->select('product_category_id')
                ->from('products')
                ->where('seller_id', $seller_id)
                ->where('status', 3);
        })->get();

        $products = Product::where('seller_id', $seller_id)
            ->where('status', 3)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $seller = Seller::find($seller_id);

        $sellerCategories = $originalSellerCategories;

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'query' => $query,
        ];

        return view('products.by_seller_search', $data);
    }

    public function by_seller_and_category(Request $request,$seller_id, $category_id)
    {
        $perPage = $request->input('perPage', 12);
        $products = Product::where('seller_id', $seller_id)
            ->where('product_category_id', $category_id)
            ->where('status', 3)
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $seller = Seller::find($seller_id);

        $originalSellerCategories = ProductCategory::whereIn('id', function ($query) use ($seller_id) {
            $query->select('product_category_id')
                ->from('products')
                ->where('seller_id', $seller_id)
                ->where('status', 3);
        })->get();
        $sellerCategories = $originalSellerCategories;

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
        $perPage = $request->input('perPage', 12);
        $query = $request->input('query');

        $products = Product::where('seller_id', $seller_id)
            ->where('product_category_id', $category_id)
            ->where('status', 3)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $seller = Seller::find($seller_id);
        $originalSellerCategories = ProductCategory::whereIn('id', function ($query) use ($seller_id) {
            $query->select('product_category_id')
                ->from('products')
                ->where('seller_id', $seller_id)
                ->where('status', 3);
        })->get();
        $sellerCategories = $originalSellerCategories;
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
