@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
    <div class="mx-auto max-w-5xl space-y-8">

        {{-- Page heading --}}
        <div>
            <a href="{{ route('products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                ← Back to Products
            </a>

            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                Create Product
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Add a new product to your inventory.
            </p>
        </div>

        {{-- Product form card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">
                <h2 class="text-lg font-semibold text-gray-900">
                    Product Information
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Enter the basic details, pricing, and stock information.
                </p>
            </div>

            <form action="{{ route('products.store') }}" method="POST" class="space-y-8 p-6">
                @csrf

                {{-- Basic information --}}
                <section>
                    <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider text-gray-500">
                        Basic Information
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        <div>
                            <label for="sku" class="mb-2 block text-sm font-medium text-gray-700">
                                SKU <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                                placeholder="e.g. PRD-002"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                value="{{ old('sku') }}" required>

                            @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                                Product Name <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="e.g. Wireless Mouse"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                value="{{ old('name') }}" required>

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="mb-2 block text-sm font-medium text-gray-700">
                                Category
                            </label>

                            <select id="category_id" name="category_id"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                                <option value="">Select a category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="mb-2 block text-sm font-medium text-gray-700">
                                Description
                            </label>

                            <textarea id="description" name="description" rows="3" placeholder="Describe the product..."
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- Pricing --}}
                <section class="border-t border-gray-100 pt-8">
                    <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider text-gray-500">
                        Pricing
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="purchase_price" class="mb-2 block text-sm font-medium text-gray-700">
                                Purchase Price <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="purchase_price" name="purchase_price"
                                value="{{ old('purchase_price', '0.00') }}" min="0" step="0.01"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                value="{{ old('purchase_price', '0.00') }}" required>
                            @error('purchase_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="selling_price" class="mb-2 block text-sm font-medium text-gray-700">
                                Selling Price <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="selling_price" name="selling_price"
                                value="{{ old('selling_price', '0.00') }}" min="0" step="0.01"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                value="{{ old('selling_price', '0.00') }}" required>
                            @error('selling_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Stock --}}
                <section class="border-t border-gray-100 pt-8">
                    <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider text-gray-500">
                        Inventory
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="quantity" class="mb-2 block text-sm font-medium text-gray-700">
                                Initial Quantity <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}"
                                min="0"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                value="{{ old('quantity', 0) }}" required>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reorder_level" class="mb-2 block text-sm font-medium text-gray-700">
                                Reorder Level <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="reorder_level" name="reorder_level"
                                value="{{ old('reorder_level', 5) }}" min="0"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                value="{{ old('reorder_level', 5) }}" required>
                            @error('reorder_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-xs text-gray-500">
                                Get alerted when stock reaches this level.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Form actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                        Create Product
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
