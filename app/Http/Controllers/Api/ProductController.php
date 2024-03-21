<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        if ( $search = $request->input('search') ) {
            $products = Product::where('name', 'LIKE', '%' . $search . '%')->paginate(10);
            foreach($products as &$product) {
                $product->name = strtr($product->name, [$search => '<span>' . $search . '</span>']);
            }
        } else {
            $products = Product::paginate(10);
        }
        $products->appends($request->input());

        return response()->json($products, 200);
    }

}
