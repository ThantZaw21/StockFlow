
@extends('layouts.app')

@section('title', 'Create Purchase')

@section('content')

<div class="mx-auto max-w-6xl space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('purchases.index') }}" class="transition hover:text-emerald-600">
                    Purchases
                </a>
                <span>/</span>
                <span class="font-medium text-emerald-600">New Purchase</span>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                Create Purchase
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Record a new purchase from your supplier and add the purchased products.
            </p>
        </div>

        <a href="{{ route('purchases.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Purchases
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>

                <div>
                    <p class="font-semibold text-red-800">Please check the following errors</p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST" class="space-y-7">
        @csrf

        {{-- Supplier Information Card --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

            <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M14 3.13a4 4 0 010 7.75M12 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-slate-900">Purchase Information</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Select the supplier and purchase date.</p>
                </div>
            </div>

            <div class="grid gap-6 p-6 sm:grid-cols-2">

                {{-- Supplier --}}
                <div>
                    <label for="supplier_id" class="mb-2 block text-sm font-semibold text-slate-700">
                        Supplier <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="supplier_id"
                        name="supplier_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                    >
                        <option value="">Select a supplier</option>

                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Purchase Date --}}
                <div>
                    <label for="purchase_date" class="mb-2 block text-sm font-semibold text-slate-700">
                        Purchase Date <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        id="purchase_date"
                        name="purchase_date"
                        value="{{ old('purchase_date', date('Y-m-d')) }}"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                    >
                </div>

            </div>
        </section>

        {{-- Purchase Items Card --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

            <div class="flex flex-col justify-between gap-4 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M3 3h2l2 13h12l2-9H6m3 13h.01M17 20h.01"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-bold text-slate-900">Purchase Items</h2>
                        <p class="mt-0.5 text-xs text-slate-500">
                            Add the products included in this purchase.
                        </p>
                    </div>
                </div>

                <span id="item-count"
                      class="inline-flex w-fit items-center rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                    1 Item
                </span>

            </div>

            <div class="p-6">

                {{-- Column Headings --}}
                <div class="mb-3 hidden grid-cols-12 gap-4 px-3 text-xs font-bold uppercase tracking-wider text-slate-400 md:grid">
                    <div class="col-span-5">Product</div>
                    <div class="col-span-2">Quantity</div>
                    <div class="col-span-3">Unit Price</div>
                    <div class="col-span-2 text-center">Action</div>
                </div>

                {{-- Dynamic Product Rows --}}
                <div id="purchase-items-container" class="space-y-4">

                    <div class="purchase-item grid grid-cols-1 gap-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4 md:grid-cols-12 md:items-end">

                        <div class="md:col-span-5">
                            <label class="mb-2 block text-xs font-semibold text-slate-600 md:hidden">
                                Product
                            </label>

                            <select
                                name="items[0][product_id]"
                                required
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >
                                <option value="">Select Product</option>

                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} ({{ $product->sku }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-xs font-semibold text-slate-600 md:hidden">
                                Quantity
                            </label>

                            <input
                                type="number"
                                name="items[0][quantity]"
                                min="1"
                                placeholder="0"
                                required
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                        <div class="md:col-span-3">
                            <label class="mb-2 block text-xs font-semibold text-slate-600 md:hidden">
                                Unit Price
                            </label>

                            <input
                                type="number"
                                name="items[0][unit_price]"
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                required
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                        <div class="flex justify-end md:col-span-2 md:justify-center">
                            <span class="rounded-lg bg-slate-100 px-4 py-2.5 text-xs font-medium text-slate-400">
                                Main Item
                            </span>
                        </div>

                    </div>

                </div>

                {{-- Add Product Button --}}
                <button
                    type="button"
                    id="add-product-button"
                    class="mt-5 inline-flex items-center gap-2 rounded-xl border border-dashed border-emerald-300 bg-emerald-50/50 px-5 py-3 text-sm font-semibold text-emerald-700 transition hover:border-emerald-500 hover:bg-emerald-50"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 5v14m-7-7h14"/>
                    </svg>
                    Add Another Product
                </button>

            </div>
        </section>

        {{-- Form Actions --}}
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">

            <a
                href="{{ route('purchases.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#10251f] px-7 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-950/10 transition hover:bg-emerald-800 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-emerald-500/20"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
                Create Purchase
            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')
<script>
    // Keep track of the next purchase item index
    let itemIndex = 1;

    // Get the product container and buttons
    const container = document.getElementById('purchase-items-container');
    const addButton = document.getElementById('add-product-button');
    const itemCount = document.getElementById('item-count');

    // Update the number of product rows currently displayed
    function updateItemCount() {
        const totalItems = container.querySelectorAll('.purchase-item').length;

        itemCount.textContent = totalItems + (totalItems === 1 ? ' Item' : ' Items');
    }

    // Add a new product row
    addButton.addEventListener('click', function () {

        const newItem = document.createElement('div');

        newItem.className = 'purchase-item grid grid-cols-1 gap-4 rounded-xl border border-slate-200 bg-slate-50/70 p-4 md:grid-cols-12 md:items-end';

        newItem.innerHTML = `
            <div class="md:col-span-5">
                <label class="mb-2 block text-xs font-semibold text-slate-600 md:hidden">
                    Product
                </label>

                <select name="items[${itemIndex}][product_id]"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                    <option value="">Select Product</option>

                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} ({{ $product->sku }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-semibold text-slate-600 md:hidden">
                    Quantity
                </label>

                <input type="number"
                    name="items[${itemIndex}][quantity]"
                    min="1"
                    placeholder="0"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
            </div>

            <div class="md:col-span-3">
                <label class="mb-2 block text-xs font-semibold text-slate-600 md:hidden">
                    Unit Price
                </label>

                <input type="number"
                    name="items[${itemIndex}][unit_price]"
                    min="0"
                    step="0.01"
                    placeholder="0.00"
                    required
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
            </div>

            <div class="flex justify-end md:col-span-2 md:justify-center">
                <button type="button"
                    class="remove-item inline-flex items-center gap-1.5 rounded-lg px-3 py-2.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Remove
                </button>
            </div>
        `;

        // Add the new row to the container
        container.appendChild(newItem);

        // Move to the next unique index
        itemIndex++;

        // Update the item count
        updateItemCount();
    });

    // Remove a dynamically added product row
    container.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.remove-item');

        if (!removeButton) {
            return;
        }

        const itemRow = removeButton.closest('.purchase-item');

        if (itemRow) {
            itemRow.remove();
            updateItemCount();
        }
    });
</script>
@endpush
