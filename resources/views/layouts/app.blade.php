<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') | StockFlow</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f4f7f5] text-slate-800 antialiased">

    <div class="min-h-screen lg:flex">

        {{-- Sidebar --}}
        <aside
            class="relative flex w-full shrink-0 flex-col overflow-hidden bg-[#10251f] text-white lg:sticky lg:top-0 lg:h-screen lg:w-72">

            {{-- Decorative background --}}
            <div
                class="pointer-events-none absolute -right-24 -top-24 h-64 w-64 rounded-full bg-emerald-400/10 blur-3xl">
            </div>
            <div class="pointer-events-none absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-teal-400/10 blur-3xl">
            </div>

            {{-- Brand --}}
            <div class="relative flex h-[90px] shrink-0 items-center gap-3 border-b border-white/[0.08] px-7">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-400 text-[#10251f] shadow-lg shadow-emerald-950/30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 3h7v7H3z" />
                        <path d="M14 3h7v7h-7z" />
                        <path d="M14 14h7v7h-7z" />
                        <path d="M3 14h7v7H3z" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold tracking-tight">
                        Stock<span class="text-emerald-400">Flow</span>
                    </a>

                    <p class="mt-1 text-[10px] font-semibold tracking-[0.2em] text-slate-400">
                        INVENTORY MANAGEMENT
                    </p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav
                class="relative flex-1 space-y-8 overflow-y-auto px-5 py-7 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                {{-- Overview --}}
                <div>
                    <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        Overview
                    </p>

                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'bg-emerald-400/15 text-emerald-300 ring-1 ring-inset ring-emerald-400/20 shadow-lg shadow-black/10' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }} group flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all duration-200">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="9" rx="1.5" />
                            <rect x="14" y="3" width="7" height="5" rx="1.5" />
                            <rect x="14" y="12" width="7" height="9" rx="1.5" />
                            <rect x="3" y="16" width="7" height="5" rx="1.5" />
                        </svg>

                        <span>Dashboard</span>

                        @if (request()->routeIs('dashboard'))
                            <span
                                class="ml-auto h-2 w-2 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.8)]"></span>
                        @endif
                    </a>
                </div>

                {{-- Inventory --}}
                <div>
                    <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        Inventory
                    </p>

                    <div class="space-y-1.5">

                        {{-- Products --}}
                        <a href="{{ route('products.index') }}"
                            class="{{ request()->routeIs('products.*') ? 'bg-emerald-400/15 text-emerald-300 ring-1 ring-inset ring-emerald-400/20' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }} group flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m21 8-9-5-9 5 9 5 9-5Z" />
                                <path d="m3 8 9 5 9-5" />
                                <path d="M3 8v8l9 5 9-5V8" />
                                <path d="M12 13v8" />
                            </svg>

                            <span class="text-sm font-medium">Products</span>

                            @if (request()->routeIs('products.*'))
                                <span class="ml-auto h-2 w-2 rounded-full bg-emerald-400"></span>
                            @endif
                        </a>

                        {{-- Categories --}}
                        <a href="{{ route('categories.index') }}"
                            class="{{ request()->routeIs('categories.*') ? 'bg-emerald-400/15 text-emerald-300 ring-1 ring-inset ring-emerald-400/20' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }} group flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M4 7h16" />
                                <path d="M4 12h16" />
                                <path d="M4 17h16" />
                                <circle cx="8" cy="7" r="1" />
                                <circle cx="16" cy="12" r="1" />
                                <circle cx="10" cy="17" r="1" />
                            </svg>

                            <span class="text-sm font-medium">Categories</span>

                            @if (request()->routeIs('categories.*'))
                                <span class="ml-auto h-2 w-2 rounded-full bg-emerald-400"></span>
                            @endif
                        </a>

                        {{-- Stock Movements --}}
                        <a href="{{ route('stock-movements.index') }}"
                            class="{{ request()->routeIs('stock-movements.*') ? 'bg-emerald-400/15 text-emerald-300 ring-1 ring-inset ring-emerald-400/20' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }} group flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 3v18h18" />
                                <path d="m19 9-5 5-4-4-5 5" />
                            </svg>

                            <span class="text-sm font-medium">Stock Movements</span>

                            @if (request()->routeIs('stock-movements.*'))
                                <span class="ml-auto h-2 w-2 rounded-full bg-emerald-400"></span>
                            @endif
                        </a>

                    </div>
                </div>

                {{-- Procurement --}}
                <div>
                    <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        Procurement
                    </p>

                    <div class="space-y-1.5">

                        {{-- Suppliers --}}
                        <a href="{{ route('suppliers.index') }}"
                            class="{{ request()->routeIs('suppliers.*') ? 'bg-emerald-400/15 text-emerald-300 ring-1 ring-inset ring-emerald-400/20' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }} group flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="10" cy="7" r="4" />
                                <path d="M20 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>

                            <span class="text-sm font-medium">Suppliers</span>

                            @if (request()->routeIs('suppliers.*'))
                                <span class="ml-auto h-2 w-2 rounded-full bg-emerald-400"></span>
                            @endif
                        </a>

                        {{-- Purchases --}}
                        <a href="{{ route('purchases.index') }}"
                            class="{{ request()->routeIs('purchases.*') ? 'bg-emerald-400/15 text-emerald-300 ring-1 ring-inset ring-emerald-400/20' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }} group flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2h12v20H6z" />
                                <path d="M9 6h6" />
                                <path d="M9 10h6" />
                                <path d="M9 14h6" />
                                <path d="M9 18h6" />
                            </svg>

                            <span class="text-sm font-medium">Purchases</span>

                            @if (request()->routeIs('purchases.*'))
                                <span class="ml-auto h-2 w-2 rounded-full bg-emerald-400"></span>
                            @endif
                        </a>

                    </div>
                </div>

                {{-- Sales --}}
                <div>
                    <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                        Sales
                    </p>

                    <div class="space-y-1.5">

                        {{-- Orders --}}
                        <a href="{{ route('sales.index') }}"
                            class="{{ request()->routeIs('sales.*') ? 'bg-emerald-400/15 text-emerald-300 ring-1 ring-inset ring-emerald-400/20' : 'text-slate-400 hover:bg-white/[0.06] hover:text-white' }} group flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3h2l2.4 12.4a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 7H6" />
                                <circle cx="10" cy="21" r="1" />
                                <circle cx="19" cy="21" r="1" />
                            </svg>

                            <span class="text-sm font-medium">Sales</span>
                            @if (request()->routeIs('sales.*'))
                                <span class="ml-auto h-2 w-2 rounded-full bg-emerald-400"></span>
                            @endif
                        </a>



                    </div>
                </div>

            </nav>

            {{-- Sidebar Footer --}}
            <div class="relative shrink-0 border-t border-white/[0.08] p-5">

                <div class="flex items-center gap-3 rounded-2xl border border-white/[0.06] bg-white/[0.04] p-3.5">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-400/15 text-sm font-bold text-emerald-300">
                        SF
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-white">
                            StockFlow Admin
                        </p>

                        <p class="mt-1 text-[11px] text-slate-500">
                            Inventory workspace
                        </p>
                    </div>

                    <span
                        class="h-2 w-2 shrink-0 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>

                </div>

                <p class="mt-4 text-center text-[10px] tracking-wide text-slate-600">
                    STOCKFLOW MANAGEMENT SYSTEM
                </p>

            </div>

        </aside>

        {{-- Main Content --}}
        <main class="min-w-0 flex-1">

            <div class="min-h-screen px-4 py-6 sm:px-6 lg:px-8 xl:px-10">

                {{-- Page Content --}}
                @yield('content')

            </div>

        </main>

    </div>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>

</html>
