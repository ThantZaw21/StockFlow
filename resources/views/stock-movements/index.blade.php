
@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Page Header --}}
    <div>
        <p class="mb-2 text-sm font-medium text-slate-500">
            Inventory / Stock Management
        </p>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
            Stock Movement Management
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Manage incoming and outgoing product stock.
        </p>
    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="mb-2 text-sm font-semibold text-red-800">
                Please correct the following errors:
            </p>

            <ul class="list-inside list-disc space-y-1 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Success Message --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4">
            <svg class="h-5 w-5 shrink-0 text-emerald-600"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>

            <p class="text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </p>
        </div>
    @endif


    {{-- Stock Movement Form Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Tabs --}}
        <div class="border-b border-slate-200 px-6 pt-5">

            <div class="flex gap-8">

                <button type="button"
                        id="stock-in-tab"
                        aria-selected="true"
                        class="stock-tab active-tab relative flex items-center gap-2 border-b-2 border-emerald-600 px-1 pb-4 text-sm font-semibold text-emerald-700 transition">

                    <svg class="h-4 w-4" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 5v14m-7-7h14"/>
                    </svg>

                    Stock In
                </button>


                <button type="button"
                        id="stock-out-tab"
                        aria-selected="false"
                        class="stock-tab relative flex items-center gap-2 border-b-2 border-transparent px-1 pb-4 text-sm font-semibold text-slate-500 transition hover:text-slate-800">

                    <svg class="h-4 w-4" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 12h14"/>
                    </svg>

                    Stock Out
                </button>

            </div>

        </div>


        {{-- Stock In Panel --}}
        <div id="stock-in-panel" class="p-6 sm:p-8">

            <div class="mb-7">
                <h2 class="text-lg font-bold text-slate-900">
                    Add Stock
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Record incoming products and increase available inventory.
                </p>
            </div>


            <form action="{{ route('stock-movements.stock-in') }}"
                  method="POST"
                  class="space-y-6">

                @csrf

                {{-- Product --}}
                <div>
                    <label for="product_id"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Product <span class="text-red-500">*</span>
                    </label>

                    <select name="product_id"
                            id="product_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">

                        <option value="">Select a product</option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Current Stock: {{ $product->quantity }})
                            </option>
                        @endforeach

                    </select>
                </div>


                {{-- Quantity and Reason --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <div>
                        <label for="quantity"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Quantity <span class="text-red-500">*</span>
                        </label>

                        <input type="number"
                               name="quantity"
                               id="quantity"
                               min="1"
                               value="{{ old('quantity') }}"
                               placeholder="Enter quantity"
                               required
                               class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>


                    <div>
                        <label for="reason"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Reason <span class="text-red-500">*</span>
                        </label>

                        <select name="reason"
                                id="reason"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">

                            <option value="Purchase" {{ old('reason', 'Purchase') === 'Purchase' ? 'selected' : '' }}>Purchase</option>
                            <option value="Sale" {{ old('reason') === 'Sale' ? 'selected' : '' }}>Sale</option>
                            <option value="Return" {{ old('reason') === 'Return' ? 'selected' : '' }}>Return</option>
                            <option value="Damage" {{ old('reason') === 'Damage' ? 'selected' : '' }}>Damage</option>
                            <option value="Adjustment" {{ old('reason') === 'Adjustment' ? 'selected' : '' }}>Adjustment</option>

                        </select>
                    </div>

                </div>


                {{-- Notes --}}
                <div>
                    <label for="notes"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Notes
                        <span class="font-normal text-slate-400">(Optional)</span>
                    </label>

                    <textarea name="notes"
                              id="notes"
                              rows="4"
                              placeholder="Add additional information about this stock movement..."
                              class="w-full resize-y rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('notes') }}</textarea>
                </div>


                {{-- Form Actions --}}
                <div class="flex justify-end border-t border-slate-100 pt-5">

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">

                        <svg class="h-4 w-4" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 5v14m-7-7h14"/>
                        </svg>

                        Add Stock
                    </button>

                </div>

            </form>

        </div>


        {{-- Stock Out Panel --}}
        <div id="stock-out-panel" class="hidden p-6 sm:p-8">

            <div class="mb-7">
                <h2 class="text-lg font-bold text-slate-900">
                    Remove Stock
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Record outgoing products and reduce available inventory.
                </p>
            </div>


            <form action="{{ route('stock-movements.stock-out') }}"
                  method="POST"
                  class="space-y-6">

                @csrf

                {{-- Product --}}
                <div>
                    <label for="stock_out_product_id"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Product <span class="text-red-500">*</span>
                    </label>

                    <select name="product_id"
                            id="stock_out_product_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">

                        <option value="">Select a product</option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Available Stock: {{ $product->quantity }})
                            </option>
                        @endforeach

                    </select>
                </div>


                {{-- Quantity and Reason --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <div>
                        <label for="stock_out_quantity"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Quantity <span class="text-red-500">*</span>
                        </label>

                        <input type="number"
                               name="quantity"
                               id="stock_out_quantity"
                               min="1"
                               value="{{ old('quantity') }}"
                               placeholder="Enter quantity"
                               required
                               class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">
                    </div>


                    <div>
                        <label for="stock_out_reason"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Reason <span class="text-red-500">*</span>
                        </label>

                        <select name="reason"
                                id="stock_out_reason"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">

                            <option value="Purchase" {{ old('reason', 'Purchase') === 'Purchase' ? 'selected' : '' }}>Purchase</option>
                            <option value="Sale" {{ old('reason') === 'Sale' ? 'selected' : '' }}>Sale</option>
                            <option value="Return" {{ old('reason') === 'Return' ? 'selected' : '' }}>Return</option>
                            <option value="Damage" {{ old('reason') === 'Damage' ? 'selected' : '' }}>Damage</option>
                            <option value="Adjustment" {{ old('reason') === 'Adjustment' ? 'selected' : '' }}>Adjustment</option>

                        </select>
                    </div>

                </div>


                {{-- Notes --}}
                <div>
                    <label for="stock_out_notes"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Notes
                        <span class="font-normal text-slate-400">(Optional)</span>
                    </label>

                    <textarea name="notes"
                              id="stock_out_notes"
                              rows="4"
                              placeholder="Add additional information about this stock movement..."
                              class="w-full resize-y rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100">{{ old('notes') }}</textarea>
                </div>


                {{-- Form Actions --}}
                <div class="flex justify-end border-t border-slate-100 pt-5">

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">

                        <svg class="h-4 w-4" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M5 12h14"/>
                        </svg>

                        Remove Stock
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>
    // Get the tab buttons.
    const stockInTab = document.getElementById('stock-in-tab');
    const stockOutTab = document.getElementById('stock-out-tab');

    // Get the form panels.
    const stockInPanel = document.getElementById('stock-in-panel');
    const stockOutPanel = document.getElementById('stock-out-panel');

    // Reusable function to switch between Stock In and Stock Out.
    function switchStockTab(activeTab) {

        const isStockIn = activeTab === 'in';

        // Show the selected form and hide the other one.
        stockInPanel.classList.toggle('hidden', !isStockIn);
        stockOutPanel.classList.toggle('hidden', isStockIn);

        // Update the selected tab's appearance.
        stockInTab.classList.toggle('border-emerald-600', isStockIn);
        stockInTab.classList.toggle('text-emerald-700', isStockIn);
        stockInTab.classList.toggle('border-transparent', !isStockIn);
        stockInTab.classList.toggle('text-slate-500', !isStockIn);

        stockOutTab.classList.toggle('border-red-600', !isStockIn);
        stockOutTab.classList.toggle('text-red-700', !isStockIn);
        stockOutTab.classList.toggle('border-transparent', isStockIn);
        stockOutTab.classList.toggle('text-slate-500', isStockIn);

        // Update accessibility state.
        stockInTab.setAttribute('aria-selected', isStockIn);
        stockOutTab.setAttribute('aria-selected', !isStockIn);
    }

    // Register click events.
    stockInTab.addEventListener('click', function () {
        switchStockTab('in');
    });

    stockOutTab.addEventListener('click', function () {
        switchStockTab('out');
    });
</script>

@endpush
