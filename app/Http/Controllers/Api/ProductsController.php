<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        $rows = $query->latest()->with('images', 'category')->paginate();
        return response()->json($rows);
    }

    public function show($slug)
    {
        $product = Product::whereSlug($slug)->with('images', 'category')->firstOrFail();
        $suggestions = Product::with('images', 'category')->where('category_id', $product->category_id)->where('id', '<>', $product->id)->latest()->limit(8)->get();
        return response()->json(['product' => $product, 'suggestions' => $suggestions]);
    }

    public function news(Request $request)
    {
        $rows = Product::latest()->limit(16)->with('images', 'category')->get();
        return response()->json($rows);
    }
}
