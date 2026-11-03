@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-8">

    {{-- Page heading --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Product Details</h1>
            <p class="mt-1 text-sm text-slate-500">
                View the complete information for this product.
            </p>
        </div>

        <a href="{{ route('products.index') }}"
            class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
            Back to Products
        </a>
    </div>

    {{-- Product information card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Product name and status --}}
        <div class="border-b border-slate-100 px-6 py-5">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">
                        {{ $product->name }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        SKU: {{ $product->sku }}
                    </p>
                </div>

                <span class="rounded-full px-3 py-1 text-sm font-medium
                    {{ $product->is_active
                        ? 'bg-emerald-50 text-emerald-700'
                        : 'bg-red-50 text-red-700' }}">
                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        {{-- Product details --}}
        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <p class="text-sm text-slate-500">Purchase Price</p>
                <p class="mt-2 font-semibold text-slate-900">
                    {{ number_format((float) $product->purchase_price, 2) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Selling Price</p>
                <p class="mt-2 font-semibold text-emerald-700">
                    {{ number_format((float) $product->selling_price, 2) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Quantity in Stock</p>
                <p class="mt-2 font-semibold text-slate-900">
                    {{ $product->quantity }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Reorder Level</p>
                <p class="mt-2 font-semibold text-slate-900">
                    {{ $product->reorder_level }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Created At</p>
                <p class="mt-2 font-medium text-slate-900">
                    {{ $product->created_at?->format('d M Y, h:i A') ?? 'N/A'}}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Last Updated</p>
                <p class="mt-2 font-medium text-slate-900">
                    {{ $product->updated_at?->format('d M Y, h:i A') ?? 'N/A'}}
                </p>
            </div>

            {{-- Description spans the full row --}}
            <div class="sm:col-span-2 lg:col-span-3">
                <p class="text-sm text-slate-500">Description</p>
                <p class="mt-2 whitespace-pre-line text-slate-700">
                    {{ $product->description ?: 'No description provided.' }}
                </p>
            </div>

        </div>

        {{-- Actions --}}
        <div class="flex justify-end border-t border-slate-100 px-6 py-4">
            <a href="{{ route('products.edit', $product->id) }}"
                class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                Edit Product
            </a>
        </div>

    </div>
</div>
@endsection