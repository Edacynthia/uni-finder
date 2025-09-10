<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\MarketerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * List products for the logged-in marketer (admin sees all).
     */
    public function index()
    {
        $user = Auth::user();

        $products = Product::with(['category', 'marketerProfile.user'])
            ->when(!Auth::user()->hasRole('admin'), function ($q) {
                $profile = MarketerProfile::where('user_id', Auth::id())->first();
                $q->where('marketer_id', Auth::id());
            })
            ->latest()
            ->paginate(12);
        return view('marketer.products.index', compact('products'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $categories = Category::all();
        return view('marketer.products.create', compact('categories'));
    }

    /**
     * Store product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255', // made required for uniqueness
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $profile = MarketerProfile::where('user_id', Auth::id())->first();
        if (!$profile || !Auth::user()->hasRole('marketer')) {
            abort(403, 'You must be a marketer with a profile to add products.');
        }

        // 🔒 Prevent duplicate: same marketer + same title + same category
        $existing = Product::where('marketer_id', Auth::id())
            ->where('title', $validated['title'])
            ->where('category_id', $validated['category_id'])
            ->first();

        if ($existing) {
            return back()->with('error', 'You already added this product.');
        }

        $product = new Product();
        $product->title       = $validated['title'];
        $product->description = $validated['description'];
        $product->price       = $validated['price'];
        $product->category_id = $validated['category_id'];
        $product->marketer_id = Auth::id();

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('marketer.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Edit form.
     */
    public function edit(Product $product)
    {
        $profile = MarketerProfile::where('user_id', Auth::id())->first();
        if ($product->marketer_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }


        $categories = Category::all();
        return view('marketer.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        // $profile = MarketerProfile::where('user_id', Auth::id())->first();
        if ($product->marketer_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->title       = $validated['title'] ?? $product->title;
        $product->description = $validated['description'] ?? $product->description;
        $product->price       = $validated['price'];
        $product->category_id = $validated['category_id'];

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('marketer.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product)
    {
        // $profile = MarketerProfile::where('user_id', Auth::id())->first();
        if ($product->marketer_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $product->delete();
        return redirect()->route('marketer.products.index')->with('success', 'Product deleted successfully!');
    }
}
