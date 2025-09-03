@extends('components.layouts.app')

@section('content')
<style>
    .logo-gradient {
        background: linear-gradient(135deg, #ff00cc 0%, #ff9900 25%, #66ff00 50%, #00ffff 75%, #cc00ff 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradientShift 8s linear infinite;
    }
    @keyframes gradientShift {
        0% { background-position: 0% center; }
        100% { background-position: 200% center; }
    }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover {
        transform: translateY(-8px) rotate(1deg);
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    }
    .hero-bg {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    }
    .glow {
        box-shadow: 0 0 20px rgba(255, 0, 204, 0.4);
        animation: pulseGlow 3s ease-in-out infinite alternate;
    }
    @keyframes pulseGlow {
        0% { box-shadow: 0 0 20px rgba(255, 0, 204, 0.4); }
        100% { box-shadow: 0 0 40px rgba(0, 255, 255, 0.6), 0 0 70px rgba(102, 255, 0, 0.4); }
    }
    .product-card {
        border: 1px solid rgba(168, 85, 247, 0.2);
        background: linear-gradient(135deg, rgba(31,41,55,0.8) 0%, rgba(17,24,39,0.9) 100%);
    }
    .btn-primary {
        background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(168,85,247,0.4);
    }
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        transition: all 0.3s ease;
    }
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(245,158,11,0.4);
    }
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        transition: all 0.3s ease;
    }
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(239,68,68,0.4);
    }
    .empty-state {
        background: linear-gradient(135deg, rgba(31,41,55,0.8) 0%, rgba(17,24,39,0.9) 100%);
        border: 2px dashed rgba(168,85,247,0.4);
    }
</style>

<div class="bg-[#2C2957] text-white font-chakra">
    @include('components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8 min-h-screen">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white font-syne">My Products</h1>
                <p class="text-purple-300 mt-2">Manage your product listings</p>
            </div>
            <a href="{{ route('marketer.products.create') }}"
               class="btn-primary text-white px-5 py-3 rounded-lg font-medium mt-4 sm:mt-0 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                          clip-rule="evenodd"/>
                </svg>
                Add New Product
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-purple-300 text-purple-600 border border-purple-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 
                             7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Product Grid -->
        @if ($products->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="product-card rounded-xl p-5">
                        <!-- Product Image -->
                        <div class="h-48 w-full overflow-hidden rounded-lg bg-gray-800 flex items-center justify-center mb-4">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title ?? 'Product image' }}" class="w-full h-48 object-cover">
                            @else
                                <div class="text-center text-purple-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                                                 l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V7a2 2 0 
                                                 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm mt-1">No image</p>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <h3 class="font-semibold text-lg text-white">{{ $product->title ?? 'Untitled Product' }}</h3>
                        <p class="text-gray-400 text-sm mt-2">{{ Str::limit($product->description, 100) }}</p>

                        <div class="mt-4 space-y-2">
                            <div class="flex items-center text-sm text-purple-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 
                                             8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                <span class="font-medium">Category:</span>
                                <span class="ml-1">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            </div>

                            @if (!is_null($product->price))
                                <div class="flex items-center text-sm text-purple-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 
                                                 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 
                                                 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 
                                                 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">Price:</span>
                                    <span class="ml-1 font-bold">₦{{ number_format($product->price, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="mt-5 flex items-center gap-2">
                            <a href="{{ route('marketer.products.edit', $product) }}" class="btn-edit text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 
                                             002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 
                                             2 0 112.828 2.828L11.828 15H9v-2.828
                                             l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('marketer.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 
                                                 0116.138 21H7.862a2 2 0 
                                                 01-1.995-1.858L5 7m5 4v6m4
                                                 -6v6m1-10V4a1 1 0 00-1-1h-4a1 
                                                 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state rounded-xl p-8 text-center glow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 
                             4m8-4v10l-8 4m0-10L4 7m8 
                             4v10M4 7v10l8 4"/>
                </svg>
                <h3 class="text-xl font-medium text-white mt-4">No products yet</h3>
                <p class="text-purple-300 mt-2">You haven't added any products to your catalog.</p>
                <a href="{{ route('marketer.products.create') }}" class="btn-primary text-white px-5 py-3 rounded-lg font-medium mt-6 inline-flex items-center mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 
                              0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 
                              110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                    Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
