<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderby('id','ASC')->get();
        $data = ['products' => $products];
        return view('index',$data);
    }
}
