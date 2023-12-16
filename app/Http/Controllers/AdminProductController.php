<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::orderby('id','ASC')->get();
        $data = ['products' => $products];
        return view('admins.products.index',$data);
    }

    public function create()
    {
        return view('admins.products.create');
    }

    public function store(Request $request)
    {
        // 驗證請求...
        $this->validate($request, [
            'product_category_id' => 'required',
            'seller_id' => 'required',
            'name' => 'required|max:25',
            'detail' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
        ]);

        $product = new Product;

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // 存儲原始圖片
            Storage::disk('products')->put($imageName, file_get_contents($image));

            $product->image_url = $imageName;
        }

        $product->product_category_id = $request->product_category_id;
        $product->seller_id = $request->seller_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->inventory = $request->inventory;
        $product->detail =  $request->input('detail');
        $product->status = $request->status;

        $product->save();

        return redirect()->route('admins.products.index');
    }

    public function edit(Product $product)
    {
        $data = [
            'product'=> $product,
        ];
        return view('admins.products.edit',$data);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'product_category_id' => 'required',
            'seller_id' => 'required',
            'name' => 'required|max:25',
            'detail' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
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

        $product->product_category_id = $request->product_category_id;
        $product->seller_id = $request->seller_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->inventory = $request->inventory;
        $product->detail = $request->input('detail');
        $product->status = $request->status;

        $product->save();

        return redirect()->route('admins.products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admins.products.index');
    }
}
