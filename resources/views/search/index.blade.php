@extends('components.layouts.app')
@section('content')
    <style type="text/css">
        .logo-gradient {
            background: linear-gradient(135deg, #ff00cc 0%, #ff9900 25%, #66ff00 50%, #00ffff 75%, #cc00ff 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 8s linear infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .product-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.2);
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.9) 100%);
        }

        .btn-whatsapp {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            transition: all 0.3s ease;
        }

        .btn-whatsapp:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(37, 211, 102, 0.4);
        }

        .btn-instagram {
            background: linear-gradient(135deg, #833AB4 0%, #FD1D1D 50%, #FCAF45 100%);
            transition: all 0.3s ease;
        }

        .btn-instagram:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(131, 58, 180, 0.4);
        }

        .btn-view {
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        }
    </style>

    <div class="bg-[#2C2957] text-white font-chakra min-h-screen">
        {{-- Navbar --}}
        @include('components.navbar')

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white font-syne">
                    @if (!empty($query))
                        Search Results for "<span class="logo-gradient">{{ $query }}</span>"
                    @else
                        Search Results
                    @endif
                </h1>
                <p class="text-purple-300 mt-2">
                    Found {{ $products->total() }} product(s)
                </p>
            </div>

            {{-- Products --}}
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-6 text-white border-b border-purple-500 pb-2">Products</h2>

                @if ($products->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <div class="product-card rounded-xl p-5">
                                {{-- Product Image --}}
                                <div
                                    class="h-48 w-full overflow-hidden rounded-lg bg-gray-800 flex items-center justify-center mb-4">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            class="w-full h-48 object-cover" alt="{{ $product->title ?? 'Product image' }}">
                                    @else
                                        <div class="text-center text-purple-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                                                        l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01
                                                        M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2
                                                        0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-sm mt-1">No image</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <h3 class="font-bold text-lg text-white">{{ $product->title ?? 'Untitled Product' }}</h3>

                                {{-- Category --}}
                                <div class="flex items-center text-sm text-purple-300 mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2
                                                0 110 4M5 8v10a2 2 0 002 2h10a2 2
                                                0 002-2V8m-9 4h4" />
                                    </svg>
                                    <span class="font-medium">Category:</span>
                                    <span class="ml-1">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                </div>

                                {{-- Business Name --}}
                                @if ($product->marketerProfile->business_name ?? false)
                                    <div class="flex items-center text-sm text-purple-300 mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2
                                                    0 00-2 2v16m14 0h2m-2 0h-5m-9
                                                    0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1
                                                    4h1m-5 10v-5a1 1 0 011-1h2a1 1
                                                    0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span class="font-medium">Brand:</span>
                                        <span class="ml-1">{{ $product->marketerProfile->business_name }}</span>
                                    </div>
                                @endif

                                {{-- Price --}}
                                @if (!is_null($product->price))
                                    <div class="flex items-center text-sm text-green-400 mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343
                                                    2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11
                                                    0 2.08.402 2.599 1M12 8V7m0 1v8m0
                                                    0v1m0-1c-1.11 0-2.08-.402-2.599-1M21
                                                    12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-medium">Price:</span>
                                        <span class="ml-1 font-bold">₦{{ number_format($product->price, 2) }}</span>
                                    </div>
                                @endif

                                {{-- Description --}}
                                @if ($product->description)
                                    <p class="mt-3 text-sm text-gray-400">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                @endif

                                {{-- Seller Info --}}
                                @if ($product->marketerProfile)
                                    <div class="mt-4 pt-3 border-t border-gray-700">
                                        <p class="text-sm text-purple-300">
                                            Sold by:
                                            <a href="{{ route('marketer.profile.show', $product->marketerProfile->user->id) }}"
                                                class="text-white underline hover:text-purple-300">
                                                {{ $product->marketer?->name ?? $product->marketerProfile?->business_name }}

                                            </a>
                                        </p>

                                        {{-- Socials --}}
                                        <div class="flex gap-2 mt-3">
                                            @if ($product->marketerProfile)
                                                <a href="https://wa.me/{{ $product->marketerProfile->whatsapp }}"
                                                    target="_blank"
                                                    class="btn-whatsapp text-white px-3 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67-.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                                    </svg>
                                                    WhatsApp
                                                </a>
                                            @endif

                                            @if ($product->marketerProfile)
                                                <a href="https://instagram.com/{{ $product->marketerProfile->instagram }}"
                                                    target="_blank"
                                                    class="btn-instagram text-white px-3 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                    </svg>
                                                    Instagram
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($products->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="flex space-x-2">
                                @if (!$products->onFirstPage())
                                    <a href="{{ $products->previousPageUrl() }}"
                                        class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">
                                        Previous
                                    </a>
                                @endif

                                @foreach (range(1, $products->lastPage()) as $i)
                                    @if ($i == $products->currentPage())
                                        <span
                                            class="px-3 py-2 rounded-lg bg-purple-700 text-white">{{ $i }}</span>
                                    @else
                                        <a href="{{ $products->url($i) }}"
                                            class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">
                                            {{ $i }}
                                        </a>
                                    @endif
                                @endforeach

                                @if ($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}"
                                        class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">
                                        Next
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-400 mx-auto mb-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="text-xl font-medium text-white">No products found</h3>
                        <p class="text-purple-300 mt-2">Try different search terms or browse categories</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
