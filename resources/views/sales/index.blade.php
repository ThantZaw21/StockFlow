
@extends('layouts.app')

@section('title', 'Sales Management')

@section('content')

<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Sales Management
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage and track your sales transactions.
            </p>
        </div>

        <a href="{{ route('sales.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
            <span class="text-lg leading-none">+</span>
            Create Sale
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Sales</p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $sales->count() }}
                </h2>
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-emerald-50 text-xl text-emerald-600">
                    $
                </div>
            </div>
            <p class="mt-2 text-xs text-slate-400">All recorded transactions</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Revenue</p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ number_format($sales->sum('total_amount'), 2) }}
                </h2>
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-xl text-blue-600">
                    ↗
                </div>
            </div>
            <p class="mt-2 text-xs text-slate-400">Combined sale amounts</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Completed Sales</p>
            <div class="mt-3 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $sales->where('status', 'completed')->count() }}
                </h2>
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-violet-50 text-xl text-violet-600">
                    ✓
                </div>
            </div>
            <p class="mt-2 text-xs text-slate-400">Successfully completed</p>
        </div>

    </div>

    {{-- Sales Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col justify-between gap-2 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="font-semibold text-slate-800">All Sales</h2>
                <p class="mt-1 text-xs text-slate-500">
                    A complete list of your sales transactions.
                </p>
            </div>

            <span class="text-sm text-slate-500">
                {{ $sales->count() }} records
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Sale ID</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Sale Date</th>
                        <th class="px-6 py-4 text-right font-semibold">Total Amount</th>
                        <th class="px-6 py-4 text-center font-semibold">Status</th>
                        <th class="px-6 py-4 text-center font-semibold">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($sales as $sale)
                        <tr class="transition hover:bg-slate-50">

                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-700">
                                {{-- #{{ $sale->id }} --}}
                                {{ $loop->iteration }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="font-medium text-slate-800">
                                    {{ $sale->customer_name ?: 'Walk-in Customer' }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                {{ $sale->sale_date->format('d M Y') }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-slate-800">
                                {{ number_format($sale->total_amount, 2) }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                @if ($sale->status === 'completed')
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Completed
                                    </span>
                                @elseif ($sale->status === 'cancelled')
                                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                        Cancelled
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="text-xs font-medium text-slate-400">
                                    —
                                </span>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-2xl text-slate-400">
                                    $
                                </div>
                                <h3 class="mt-4 font-semibold text-slate-700">
                                    No sales found
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Start by creating your first sale.
                                </p>
                                <a href="{{ route('sales.create') }}"
                                    class="mt-4 inline-flex rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                    Create Your First Sale
                                </a>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
