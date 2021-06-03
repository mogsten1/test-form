<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;
use App\Models\Product;

use Carbon\Carbon;

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
        $array_value = [
            'Product Name' => $request->product_name,
            'Quantity in Stocks' => $request->quantity,
            'Price Per Item' => $request->price
        ];

        $xml_data = new ArrayToXml($array_value);

        Storage::disk('local')->put($request->product_name.'-'.date('Ymd-his').'.xml', $xml_data->prettify()->toXml());

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
