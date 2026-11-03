@extends('layouts.app')

@section('title', 'Create Sale')

@section('content')

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Page Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Create Sale</h1>
            <p class="mt-1 text-sm text-slate-500">
                Select products and enter quantities to create a new sale.
            </p>
        </div>

        <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
            @csrf
            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                    <h3 class="text-sm font-semibold text-red-700">
                        Unable to complete sale
                    </h3>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Sale Information --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-800">Sale Information</h2>
                <p class="mt-1 text-sm text-slate-500">Enter the basic transaction details.</p>

                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <div>
                        <label for="customer_name" class="mb-2 block text-sm font-medium text-slate-700">
                            Customer Name <span class="text-slate-400">(Optional)</span>
                        </label>

                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                            placeholder="Enter customer name"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">

                        @error('customer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sale_date" class="mb-2 block text-sm font-medium text-slate-700">
                            Sale Date
                        </label>

                        <input type="date" name="sale_date" id="sale_date"
                            value="{{ old('sale_date', now()->format('Y-m-d')) }}" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">

                        @error('sale_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Sale Products --}}
            <div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="flex flex-col justify-between gap-3 border-b border-slate-200 p-6 sm:flex-row sm:items-center">
                    <div>
                        <h2 class="font-semibold text-slate-800">Sale Products</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Add the products purchased by the customer.
                        </p>
                    </div>

                    <button type="button" id="addProduct"
                        class="rounded-lg border border-emerald-600 px-4 py-2 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-50">
                        + Add Product
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[750px] text-left text-sm">

                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-4 font-semibold">Product</th>
                                <th class="px-5 py-4 font-semibold">Unit Price</th>
                                <th class="px-5 py-4 font-semibold">Quantity</th>
                                <th class="px-5 py-4 text-right font-semibold">Subtotal</th>
                                <th class="px-5 py-4 text-center font-semibold">Action</th>
                            </tr>
                        </thead>

                        <tbody id="productRows" class="divide-y divide-slate-100">
                        </tbody>

                    </table>
                </div>

                <div id="emptyProducts" class="px-6 py-12 text-center">
                    <p class="font-medium text-slate-600">No products added yet</p>
                    <p class="mt-1 text-sm text-slate-400">
                        Click Add Product to select a product.
                    </p>
                </div>

                @error('items')
                    <p class="px-6 pb-4 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @error('items.*.product_id')
                    <p class="px-6 pb-4 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @error('items.*.quantity')
                    <p class="px-6 pb-4 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- Total --}}
                <div class="flex justify-end border-t border-slate-200 bg-slate-50 px-6 py-5">
                    <div class="w-full sm:w-72">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500">Total Amount</span>
                            <span id="saleTotal" class="text-2xl font-bold text-emerald-700">
                                0.00
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('sales.index') }}"
                    class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    Cancel
                </a>

                <button type="submit"
                    class="rounded-lg bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                    Complete Sale
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
    <script>
        const products = {{ Illuminate\Support\Js::from($productsForJs) }};

        const productRows = document.getElementById('productRows');
        const addProductButton = document.getElementById('addProduct');
        const emptyProducts = document.getElementById('emptyProducts');
        const saleTotal = document.getElementById('saleTotal');

        let rowIndex = 0;

        function formatMoney(amount) {
            return Number(amount).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function updateTotal() {
            let total = 0;

            productRows.querySelectorAll('tr').forEach(row => {
                const quantity = Number(row.querySelector('.quantity-input').value) || 0;
                const price = Number(row.querySelector('.product-select').selectedOptions[0]?.dataset.price) || 0;

                const subtotal = quantity * price;

                row.querySelector('.subtotal').textContent = formatMoney(subtotal);

                total += subtotal;
            });

            saleTotal.textContent = formatMoney(total);
            emptyProducts.classList.toggle('hidden', productRows.children.length > 0);
        }

        function addProductRow() {
            const row = document.createElement('tr');
            row.className = 'product-row';

            const productOptions = products.map(product => `
            <option value="${product.id}"
                data-price="${product.price}">
                ${product.name} (${product.sku})
            </option>
        `).join('');

            row.innerHTML = `
            <td class="px-5 py-4">
                <select name="items[${rowIndex}][product_id]"
                    class="product-select w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-emerald-500"
                    required>
                    <option value="">Select product</option>
                    ${productOptions}
                </select>
            </td>

            <td class="px-5 py-4 whitespace-nowrap text-slate-600">
                <span class="unit-price">0.00</span>
            </td>

            <td class="px-5 py-4">
                <input type="number"
                    name="items[${rowIndex}][quantity]"
                    min="1"
                    value="1"
                    class="quantity-input w-24 rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-emerald-500"
                    required>
            </td>

            <td class="px-5 py-4 text-right font-semibold text-slate-800 whitespace-nowrap">
                <span class="subtotal">0.00</span>
            </td>

            <td class="px-5 py-4 text-center">
                <button type="button"
                    class="remove-product rounded-lg px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                    Remove
                </button>
            </td>
        `;

            productRows.appendChild(row);
            rowIndex++;

            updateTotal();
        }

        addProductButton.addEventListener('click', addProductRow);

        productRows.addEventListener('change', function(event) {
            if (event.target.classList.contains('product-select')) {
                const row = event.target.closest('tr');
                const selectedOption = event.target.selectedOptions[0];
                const price = Number(selectedOption.dataset.price) || 0;

                row.querySelector('.unit-price').textContent = formatMoney(price);

                updateTotal();
            }
        });

        productRows.addEventListener('input', function(event) {
            if (event.target.classList.contains('quantity-input')) {
                updateTotal();
            }
        });

        productRows.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-product')) {
                event.target.closest('tr').remove();
                updateTotal();
            }
        });

        // Start with one empty product row.
        if (products.length > 0) {
            addProductRow();
        } else {
            addProductButton.disabled = true;
            addProductButton.classList.add('cursor-not-allowed', 'opacity-50');
        }
    </script>
@endpush
