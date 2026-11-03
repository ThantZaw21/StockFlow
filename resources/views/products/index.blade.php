@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="mx-auto w-full max-w-screen-2xl space-y-8 p-4 sm:p-6 lg:p-8">
        {{-- Page heading --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    Products
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Manage your products, prices, and inventory levels.
                </p>
            </div>

            <a href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                <span class="text-lg leading-none">+</span>
                Add Product
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100 font-bold">
                    ✓
                </span>

                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Products table card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            {{-- Table header --}}
            <div
                class="flex flex-col gap-3 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        All Products
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        A list of all products in your inventory.
                    </p>
                </div>

                <span
                    class="inline-flex w-fit items-center rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700">
                    {{ $products->count() }} products
                </span>
            </div>

            {{-- Responsive table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Product
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Category
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                SKU
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Selling Price
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($products as $product)
                            <tr class="transition hover:bg-gray-50">
                                {{-- Row number --}}
                                <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-400">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Product name --}}
                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="font-semibold text-gray-900">
                                        {{ $product->name }}
                                    </div>

                                    <div class="mt-1 max-w-xs truncate text-sm text-gray-500">
                                        {{ $product->description ?: 'No description' }}
                                    </div>
                                </td>

                                {{-- category --}}
                                <td class="whitespace-nowrap px-6 py-5">
                                    <span
                                        class="rounded-lg bg-gray-100 px-2.5 py-1 font-mono text-xs font-medium text-gray-600">
                                        {{ $product->category?->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                {{-- SKU --}}
                                <td class="whitespace-nowrap px-6 py-5">
                                    <span
                                        class="rounded-lg bg-gray-100 px-2.5 py-1 font-mono text-xs font-medium text-gray-600">
                                        {{ $product->sku }}
                                    </span>
                                </td>

                                {{-- Selling price --}}
                                <td class="whitespace-nowrap px-6 py-5 text-right text-sm font-semibold text-gray-900">
                                    {{ number_format((float) $product->selling_price, 2) }}
                                </td>

                                {{-- Quantity --}}
                                <td class="whitespace-nowrap px-6 py-5 text-right">
                                    <span
                                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $product->quantity <= $product->reorder_level ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700' }}">
                                        {{ $product->quantity }} units
                                    </span>
                                </td>
                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View button --}}
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="inline-flex items-center rounded-lg border border-emerald-200 px-3 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-50">
                                            View
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="inline-flex items-center rounded-lg border border-indigo-200 px-3 py-2 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50">
                                            Edit
                                        </a>

                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Are u sure you want to delete this product!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-2xl text-indigo-600">
                                        +
                                    </div>

                                    <h3 class="mt-4 text-base font-semibold text-gray-900">
                                        No products yet
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Get started by adding your first product.
                                    </p>

                                    <a href="{{ route('products.create') }}"
                                        class="mt-5 inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                        Create your first product
                                    </a>
                                </td>

                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Table footer --}}
            @if ($products->isNotEmpty())
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                    <p class="text-sm text-gray-500">
                        Showing
                        <span class="font-medium text-gray-900">{{ $products->count() }}</span>
                        {{ Str::plural('product', $products->count()) }}
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection
