
@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">
                <span>Procurement</span>
                <span>/</span>
                <span class="font-medium text-emerald-600">Purchases</span>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                Purchase History
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Track and manage all your supplier purchases in one place.
            </p>
        </div>

        <a href="{{ route('purchases.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#10251f] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-950/10 transition hover:bg-emerald-800 hover:shadow-xl">

            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 5v14m-7-7h14"/>
            </svg>

            Create Purchase
        </a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Purchase History Card --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex flex-col justify-between gap-2 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center">
            <div>
                <h2 class="font-bold text-slate-900">All Purchases</h2>
                <p class="mt-1 text-xs text-slate-500">
                    A complete record of your purchase transactions.
                </p>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                {{ $purchases->count() }} {{ $purchases->count() === 1 ? 'Purchase' : 'Purchases' }}
            </span>
        </div>

        {{-- Responsive Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[750px] text-left">

                <thead class="bg-slate-50">
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4">Purchase</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4">Purchase Date</th>
                        <th class="px-6 py-4">Total Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($purchases as $purchase)

                        <tr class="transition hover:bg-slate-50/80">

                            {{-- Purchase ID --}}
                            <td class="px-6 py-5">
                                <a href="{{ route('purchases.show', $purchase->id) }}"
                                   class="font-bold text-emerald-700 transition hover:text-emerald-900 hover:underline">
                                    #{{ $purchase->id }}
                                </a>
                                <p class="mt-1 text-xs text-slate-400">Purchase record</p>
                            </td>

                            {{-- Supplier --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-600">
                                        {{ strtoupper(substr($purchase->supplier->name, 0, 1)) }}
                                    </div>

                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $purchase->supplier->name }}
                                    </span>
                                </div>
                            </td>

                            {{-- Purchase Date --}}
                            <td class="px-6 py-5">
                                <span class="text-sm font-medium text-slate-700">
                                    {{ $purchase->purchase_date->format('d M Y') }}
                                </span>
                            </td>

                            {{-- Total Amount --}}
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-slate-900">
                                    {{ number_format($purchase->total_amount, 2) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5">
                                @if ($purchase->status === 'received')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Received
                                    </span>

                                @elseif ($purchase->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>

                                @elseif ($purchase->status === 'cancelled')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Cancelled
                                    </span>

                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('purchases.show', $purchase->id) }}"
                                   class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">

                                    View Details

                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M3 7h18M5 7l1 13h12l1-13M9 7V4h6v3"/>
                                    </svg>
                                </div>

                                <h3 class="mt-5 text-base font-bold text-slate-800">
                                    No purchases yet
                                </h3>

                                <p class="mt-2 text-sm text-slate-500">
                                    Your purchase records will appear here once you create one.
                                </p>

                                <a href="{{ route('purchases.create') }}"
                                   class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#10251f] px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800">
                                    <span>+</span>
                                    Create Your First Purchase
                                </a>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Table Footer --}}
        @if ($purchases->isNotEmpty())
            <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-4">
                <p class="text-xs text-slate-500">
                    Showing <span class="font-semibold text-slate-700">{{ $purchases->count() }}</span>
                    purchase records.
                </p>
            </div>
        @endif

    </section>

</div>

@endsection
