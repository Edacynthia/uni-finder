<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::check() && ($query || $categoryId)) {
            SearchHistory::updateOrCreate([
                'user_id'     => Auth::id(),  // ✅ assign user
                'query'       => $query,
                'category_id' => $categoryId,    // store first matched product if exists
            ]);
        }

        return view('search.index', [
            'query' => $query,
            'products' => $products,
        ]);
    }
}
