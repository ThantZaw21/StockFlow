```blade
@extends('layouts.app')

@section('title', 'Purchase Details')

@section('content')

<div class="mx-auto max-w-7xl space-y-6 p-6">

    {{-- Success Message --}}
    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Page Heading --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>
            <p class="mb-2 text-sm font-medium text-slate-500">
                Purchases / Purchase Details
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Purchase #{{ $purchase->id }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View purchase information and purchased products.
            </p>
        </div>

        <a href="{{ route('purchases.index') }}"
           class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            &larr; Back to Purchases
        </a>

    </div>


    {{-- Purchase Information --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Purchase Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                General information about this purchase.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Supplier --}}
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Supplier
                </p>

                <p class="mt-2 text-base font-semibold text-slate-900">
                    {{ $purchase->supplier->name }}
                </p>
            </div>

            {{-- Purchase Date --}}
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Purchase Date
                </p>

                <p class="mt-2 text-base font-semibold text-slate-900">
                    {{ $purchase->purchase_date->format('d M Y') }}
                </p>
            </div>

            {{-- Status --}}
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Status
                </p>

                <div class="mt-2">
                    @if ($purchase->status === 'received')
                        <span class="inline-flex rounded-md bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700">
                            Received
                        </span>

                    @elseif ($purchase->status === 'pending')
                        <span class="inline-flex rounded-md bg-amber-50 px-3 py-1.5 text-sm font-semibold text-amber-700">
                            Pending
                        </span>

                    @elseif ($purchase->status === 'cancelled')
                        <span class="inline-flex rounded-md bg-red-50 px-3 py-1.5 text-sm font-semibold text-red-700">
                            Cancelled
                        </span>

                    @else
                        <span class="inline-flex rounded-md bg-slate-100 px-3 py-1.5 text-sm font-semibold text-slate-700">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Total Amount --}}
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Total Amount
                </p>

                <p class="mt-2 text-xl font-bold text-slate-900">
                    {{ number_format($purchase->total_amount, 2) }}
                </p>
            </div>

            {{-- Receive Purchase Button --}}
            @if ($purchase->status === 'pending')
                <div class="sm:col-span-2 lg:col-span-4">

                    <form
                        action="{{ route('purchases.receive', $purchase->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to receive this purchase?');"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                        >
                            Receive Purchase
                        </button>
                    </form>

                    <p class="mt-2 text-xs text-slate-500">
                        Receiving this purchase will add the purchased quantities to your inventory.
                    </p>

                </div>
            @endif

        </div>

    </div>


    {{-- Purchase Items --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Section Header --}}
        <div class="flex flex-col justify-between gap-2 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center">

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Purchase Items
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Products included in this purchase.
                </p>
            </div>

            <span class="text-sm font-medium text-slate-500">
                {{ $purchase->items->count() }}
                {{ $purchase->items->count() === 1 ? 'item' : 'items' }}
            </span>

        </div>


        {{-- Items Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-50">

                    <tr class="text-xs font-semibold uppercase tracking-wider text-slate-500">

                        <th class="px-6 py-4">#</th>

                        <th class="px-6 py-4">Product</th>

                        <th class="px-6 py-4 text-center">Quantity</th>

                        <th class="px-6 py-4 text-right">Unit Price</th>

                        <th class="px-6 py-4 text-right">Subtotal</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($purchase->items as $index => $item)

                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-4">

                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $item->product->name }}
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    SKU: {{ $item->product->sku }}
                                </p>

                            </td>

                            <td class="px-6 py-4 text-center text-sm font-medium text-slate-700">
                                {{ number_format($item->quantity) }}
                            </td>

                            <td class="px-6 py-4 text-right text-sm text-slate-600">
                                {{ number_format($item->unit_price, 2) }}
                            </td>

                            <td class="px-6 py-4 text-right text-sm font-semibold text-slate-900">
                                {{ number_format($item->subtotal, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                                No purchase items found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>


                {{-- Grand Total --}}
                @if ($purchase->items->isNotEmpty())

                    <tfoot class="bg-slate-50">

                        <tr>
                            <td colspan="4" class="px-6 py-5 text-right text-sm font-semibold text-slate-600">
                                Grand Total
                            </td>

                            <td class="px-6 py-5 text-right text-lg font-bold text-slate-900">
                                {{ number_format($purchase->total_amount, 2) }}
                            </td>
                        </tr>

                    </tfoot>

                @endif

            </table>

        </div>

    </div>

</div>

@endsection
```