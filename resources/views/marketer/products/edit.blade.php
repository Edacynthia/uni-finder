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

        .profile-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.9) 0%, rgba(17, 24, 39, 0.95) 100%);
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .input-field {
            transition: border-color 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.3);
            background: rgba(44, 41, 87, 0.7);
        }

        .input-field:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            transition: transform 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .country-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23a855f7'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            border: 2px dashed rgba(168, 85, 247, 0.4);
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
    </style>
    <div class="bg-[#2C2957] text-white font-chakra">
        <!-- Include Navbar Component -->
        @include('components.navbar')

        <div class="max-w-2xl mx-auto py-6 sm:py-8 px-4 sm:px-6">
            <div class="profile-card rounded-xl p-4 sm:p-6">
                <h2 class="text-2xl font-bold text-white mb-2 font-syne">Edit Product</h2>
                <p class="text-purple-300 mb-6">Update your product information</p>

                @if (session('success'))
                    <div class="bg-purple-300 text-purple-600 p-3 rounded-lg mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('marketer.products.update', $product) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <!-- Title -->
                    <div class="mb-5">
                        <label class="block text-white font-medium mb-2">Title (optional)</label>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}"
                            class="w-full input-field p-3 rounded-lg text-white" placeholder="Enter product title">
                        @error('title')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-5">
                        <label class="block text-white font-medium mb-2">Price</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                            required class="w-full input-field p-3 rounded-lg text-white" placeholder="Enter price">
                        @error('price')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-5">
                        <label class="block text-white font-medium mb-2">Category</label>
                        <select name="category_id" class="w-full input-field p-3 rounded-lg country-select text-white"
                            required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-5">
                        <label class="block text-white font-medium mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full input-field p-3 rounded-lg text-white"
                            placeholder="Describe your product">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Image -->
                    <div class="mb-6">
                        <label class="block text-white font-medium mb-2">Product Image</label>

                        <!-- Current image preview -->
                        @if ($product->image)
                            <div class="mb-3 flex items-center">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->title ?? 'Product' }}"
                                    class="h-16 w-16 sm:h-20 sm:w-20 rounded object-cover border-2 border-purple-500">
                                <span class="ml-3 text-sm text-purple-300">Current product image</span>
                            </div>
                        @endif

                        <!-- File upload -->
                        <div class="file-upload relative rounded-lg p-4 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10 sm:h-12 sm:w-12 text-purple-400 mx-auto mb-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-purple-300 text-sm sm:text-base">Click to upload or drag and drop</p>
                            <p class="text-xs sm:text-sm text-purple-400 mt-1">JPG, PNG up to 2MB</p>
                            <input type="file" name="image" accept=".jpg,.jpeg,.png" class="file-upload-input">
                        </div>
                        @error('image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Display all errors -->
                    @if ($errors->any())
                        <div class="bg-red-900 text-red-300 p-4 rounded-lg mb-6">
                            <h3 class="font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293极速赛车开奖结果记录"
                                        clip-rule="evenodd" />
                                </svg>
                                Please fix the following errors
                            </h3>
                            <ul class="list-disc pl-5 mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="w-full btn-primary text-white font-medium py-3 px-4 rounded-lg"
                        onclick="this.disabled=true; this.innerText='Updating...'; this.form.submit();">
                        Update Product
                    </button>

                </form>
            </div>
        </div>

        <script>
            // File upload enhancement
            document.querySelectorAll('.file-upload-input').forEach(input => {
                input.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name;
                    if (fileName) {
                        const container = this.closest('.file-upload');
                        const textEl = container.querySelector('p');
                        if (textEl) {
                            textEl.textContent = fileName;
                        }
                    }
                });
            });
        </script>
    </div>
@endsection
