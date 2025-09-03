<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
   public function index(Request $request)
{
    $query = $request->input('q');
    $categoryId = $request->input('category');

    $products = Product::with(['category', 'marketer.marketerProfile']);

    if ($query) {
        $products->where('title', 'like', "%{$query}%")
                 ->orWhereHas('category', function ($q) use ($query) {
                     $q->where('name', 'like', "%{$query}%");
                 });
    }

    if ($categoryId) {
        $products->where('category_id', $categoryId);
    }

    $products = $products->paginate(9);

    return view('search.index', [
        'query' => $query,
        'products' => $products,
    ]);
}
}