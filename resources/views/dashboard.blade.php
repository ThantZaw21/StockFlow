@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mx-auto max-w-[1600px] space-y-8 p-5 sm:p-8 lg:p-10">

    {{-- Page Header --}}
    <header class="flex flex-wrap items-center justify-between gap-5">
        <div>
            <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-emerald-700">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                BUSINESS OVERVIEW
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                Dashboard
            </h1>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Monitor your inventory, sales, and business performance.
            </p>
        </div>

        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#102a24] text-sm font-bold text-emerald-300">
                SF
            </div>

            <div>
                <p class="text-sm font-bold text-slate-800">StockFlow Admin</p>
                <p class="mt-1 text-xs text-slate-500">Administrator</p>
            </div>

            <span class="ml-2 h-2 w-2 rounded-full bg-emerald-500"></span>
        </div>
    </header>


    {{-- Summary Cards --}}
    <section>
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">
                    Business Overview
                </h2>
                <p class="mt-1 text-xs text-slate-500">
                    Your business statistics at a glance.
                </p>
            </div>

            <span class="rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                All time
            </span>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Products --}}
            <article class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Products
                        </p>

                        <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">
                            {{ number_format($totalProducts) }}
                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21 8-9-5-9 5 9 5 9-5Z"/>
                            <path d="m3 8 9 5 9-5"/>
                            <path d="M3 8v8l9 5 9-5V8"/>
                            <path d="M12 13v8"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                    <p class="text-xs text-slate-500">
                        Products in your catalog
                    </p>

                    <a href="{{ route('products.index') }}"
                       class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">
                        View products →
                    </a>
                </div>
            </article>


            {{-- Inventory Value --}}
            <article class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Inventory Value
                        </p>

                        <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">
                            {{ number_format($inventoryValue, 2) }}
                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 text-sky-700 transition group-hover:bg-sky-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 10h18"/>
                            <path d="M7 15h3"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 border-t border-slate-100 pt-4">
                    <p class="text-xs text-slate-500">
                        Current stock × purchase price
                    </p>
                </div>
            </article>


            {{-- Total Sales --}}
            <article class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Sales
                        </p>

                        <p class="mt-4 text-3xl font-bold tracking-tight text-slate-900">
                            {{ number_format($totalSales) }}
                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-700 transition group-hover:bg-violet-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 3h8l4 4v14H4V3h4Z"/>
                            <path d="M8 3v5h8V3"/>
                            <path d="M8 13h8"/>
                            <path d="M8 17h5"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                    <p class="text-xs text-slate-500">
                        Sales recorded in the system
                    </p>

                    <a href="{{ route('sales.index') }}"
                       class="text-xs font-semibold text-violet-700 hover:text-violet-800">
                        View sales →
                    </a>
                </div>
            </article>


            {{-- Low Stock --}}
            <article class="group rounded-2xl border border-amber-200 bg-amber-50/50 p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-amber-800">
                            Low Stock Items
                        </p>

                        <p class="mt-4 text-3xl font-bold tracking-tight text-amber-950">
                            {{ number_format($lowStockItems) }}
                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-800 transition group-hover:bg-amber-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m10.3 3.9-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.7-3.1l-8-14a2 2 0 0 0-3.4 0Z"/>
                            <path d="M12 9v4"/>
                            <path d="M12 17h.01"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 border-t border-amber-200/70 pt-4">
                    <p class="text-xs text-amber-800">
                        Products that need restocking
                    </p>
                </div>
            </article>

        </div>
    </section>


    {{-- Main Dashboard Content --}}
    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Welcome Panel --}}
        <div class="relative overflow-hidden rounded-2xl bg-[#102a24] p-7 text-white shadow-sm xl:col-span-2 sm:p-9">

            <div class="relative z-10 max-w-xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1.5 text-xs font-semibold text-emerald-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    STOCKFLOW MANAGEMENT
                </span>

                <h2 class="mt-6 text-2xl font-bold tracking-tight sm:text-3xl">
                    Manage your inventory
                    <span class="text-emerald-400">with confidence.</span>
                </h2>

                <p class="mt-4 max-w-lg text-sm leading-7 text-slate-300">
                    Keep track of your products, monitor stock levels,
                    manage purchases, and record sales from one place.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('products.create') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-3 text-sm font-bold text-[#102a24] transition hover:bg-emerald-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Add Product
                    </a>

                    <a href="{{ route('sales.create') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-white/20 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Create Sale
                        <span>→</span>
                    </a>
                </div>
            </div>

            {{-- Decorative circles --}}
            <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full border border-emerald-400/10"></div>
            <div class="pointer-events-none absolute -right-8 -top-12 h-56 w-56 rounded-full border border-emerald-400/10"></div>
            <div class="pointer-events-none absolute -bottom-32 right-24 h-64 w-64 rounded-full bg-emerald-400/5 blur-3xl"></div>

            <div class="pointer-events-none absolute bottom-7 right-8 hidden text-emerald-300/10 sm:block">
                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21 8-9-5-9 5 9 5 9-5Z"/>
                    <path d="m3 8 9 5 9-5"/>
                    <path d="M3 8v8l9 5 9-5V8"/>
                    <path d="M12 13v8"/>
                </svg>
            </div>
        </div>


        {{-- Quick Overview --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">
                <h2 class="text-base font-bold text-slate-900">
                    Quick Overview
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Your inventory at a glance.
                </p>
            </div>

            <div class="space-y-5 p-6">

                {{-- Product Overview --}}
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21 8-9-5-9 5 9 5 9-5Z"/>
                            <path d="m3 8 9 5 9-5"/>
                            <path d="M3 8v8l9 5 9-5V8"/>
                        </svg>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">
                            Product Catalog
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ number_format($totalProducts) }} products registered
                        </p>
                    </div>
                </div>

                <div class="h-px bg-slate-100"></div>

                {{-- Sales Overview --}}
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 3h8l4 4v14H4V3h4Z"/>
                            <path d="M8 3v5h8V3"/>
                            <path d="M8 13h8"/>
                        </svg>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">
                            Sales Activity
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ number_format($totalSales) }} sales recorded
                        </p>
                    </div>
                </div>

                <div class="h-px bg-slate-100"></div>

                {{-- Stock Warning --}}
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m10.3 3.9-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.7-3.1l-8-14a2 2 0 0 0-3.4 0Z"/>
                            <path d="M12 9v4"/>
                            <path d="M12 17h.01"/>
                        </svg>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">
                            Stock Alerts
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ number_format($lowStockItems) }} products need attention
                        </p>
                    </div>
                </div>

                {{-- Bottom Information --}}
                <div class="rounded-xl bg-[#102a24] p-5 text-white">
                    <p class="text-sm font-semibold">
                        Keep your stock healthy
                    </p>

                    <p class="mt-2 text-xs leading-5 text-slate-300">
                        Regularly monitor your stock levels to avoid running out of products.
                    </p>

                    <a href="{{ route('stock-movements.index') }}"
                       class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-emerald-300 hover:text-emerald-200">
                        View stock movements →
                    </a>
                </div>

            </div>
        </div>

    </section>


    {{-- Quick Actions --}}
    <section>
        <div class="mb-5">
            <h2 class="text-base font-bold text-slate-900">
                Quick Actions
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Quickly access frequently used features.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <a href="{{ route('products.create') }}"
               class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800">
                        Add Product
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Register a new product
                    </p>
                </div>
            </a>


            <a href="{{ route('purchases.create') }}"
               class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-sky-200 hover:shadow-md">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-700 transition group-hover:bg-sky-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14"/>
                        <rect x="3" y="3" width="18" height="18" rx="3"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800">
                        Create Purchase
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Record a new purchase
                    </p>
                </div>
            </a>


            <a href="{{ route('sales.create') }}"
               class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-violet-200 hover:shadow-md">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-700 transition group-hover:bg-violet-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3h2l2.4 12.4a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 8H6"/>
                        <circle cx="10" cy="21" r="1"/>
                        <circle cx="18" cy="21" r="1"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800">
                        Create Sale
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Record a customer sale
                    </p>
                </div>
            </a>


            <a href="{{ route('stock-movements.index') }}"
               class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-amber-200 hover:shadow-md">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700 transition group-hover:bg-amber-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14"/>
                        <path d="m19 12-7 7-7-7"/>
                        <path d="M5 3h14"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-800">
                        Stock Movements
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Manage stock operations
                    </p>
                </div>
            </a>

        </div>
    </section>


    {{-- Footer --}}
    <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 pt-5 text-xs text-slate-400">
        <p>StockFlow Inventory Management</p>
        <p>Dashboard · Overview</p>
    </footer>

</div>
@endsection