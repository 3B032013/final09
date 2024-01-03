<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->seller;
        $products = Product::orderby('id','ASC')->where('seller_id',$seller->id)->get();
        $data = ['products' => $products];
        return view('sellers.products.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seller = Auth::user()->seller;
        $product_category = ProductCategory::orderby('id','ASC')->get();
        $data = ['product_category' => $product_category,'seller'=>$seller];

        return view('sellers.products.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 驗證請求...
        $this->validate($request, [
            'name' => 'required|max:25',
            'detail' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        $product = new Product;
        $seller_id=auth()->user()->seller->id;
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // 存儲原始圖片
            Storage::disk('products')->put($imageName, file_get_contents($image));

            $product->image_url = $imageName;
        }

        $product->product_category_id = $request->product_category;
        $product->seller_id = $seller_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->inventory = $request->inventory;
        $product->detail =  $request->input('detail');
        $product->status='0';

        $product->save();


        return redirect()->route('sellers.products.index');

    }
    public function edit(Product $product)
    {
        $data = [
            'product'=> $product,
        ];
        return view('sellers.products.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|max:25',
            'content' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            // Delete the old image from storage
            if ($product->image_url) {
                Storage::disk('products')->delete($product->image_url);
            }


            // Upload the new image
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // Log the image file name

            Storage::disk('products')->put($imageName, file_get_contents($image));

            // Set the new image URL in the Product instance
            $product->image_url = $imageName;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->content = $request->input('content');

        $product->save();

        return redirect()->route('sellers.products.index');
    }
    public function reply(Product $product)
    {
        $product->status='0';
        $product->save();
        return redirect()->route('sellers.products.index');
    }
    public function statusoff(Product $product)
    {
        $product->status='4';
        $product->save();
        return redirect()->route('sellers.products.index');
    }
    public function statuson(Product $product)
    {
        $product->status='3';
        $product->save();
        return redirect()->route('sellers.products.index');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('sellers.products.index');
    }
}
