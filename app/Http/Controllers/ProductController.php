<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $total = 0;
        foreach($products as $product){
            $total += $product->quantity * $product->price;
        }
        return view('welcome', compact('products', 'total'));
    }

    public function submit(Request $request)
    {
        $product = new Product;
        $product->product_name = $request->product_name;
        $product->quantity = $request->quantity;
        $product->price = $request->price;

        $product->save();

        $products = Product::all();

        $total = 0;
        foreach($products as $product){
            $total += $product->quantity * $product->price;
        }

        return response()->json(['status' => 'success', 'product' => $product, 'total' => $total]);
    }
}
