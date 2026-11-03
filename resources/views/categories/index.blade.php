
@extends('layouts.app')

@section('title', 'Category Management')

@section('content')

<div class="mx-auto max-w-7xl space-y-7">

    {{-- Page Header --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>
            <p class="text-sm font-medium text-indigo-600">
                Inventory Management
            </p>

            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                Categories
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Organize and manage your product categories.
            </p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">

            <span class="text-lg leading-none">+</span>
            Add Category
        </a>

    </div>


    {{-- Success Message --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-5 py-4">
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


    {{-- Statistics --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">

        {{-- Total Categories --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Total Categories
            </p>

            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                {{ $categories->count() }}
            </p>

            <p class="mt-2 text-xs text-slate-400">
                All registered categories
            </p>
        </div>


        {{-- Active Categories --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Active Categories
            </p>

            <p class="mt-3 text-3xl font-bold tracking-tight text-emerald-600">
                {{ $categories->where('is_active', true)->count() }}
            </p>

            <p class="mt-2 text-xs text-slate-400">
                Currently active
            </p>
        </div>


        {{-- Inactive Categories --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Inactive Categories
            </p>

            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-500">
                {{ $categories->where('is_active', false)->count() }}
            </p>

            <p class="mt-2 text-xs text-slate-400">
                Currently inactive
            </p>
        </div>

    </div>


    {{-- Categories Table --}}
    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex flex-col justify-between gap-2 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center">

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    All Categories
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    A complete list of your inventory categories.
                </p>
            </div>

            <span class="text-sm font-medium text-slate-500">
                {{ $categories->count() }} records
            </span>

        </div>


        {{-- Empty State --}}
        @if ($categories->isEmpty())

            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.7" stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </div>

                <h3 class="mt-5 text-base font-semibold text-slate-900">
                    No categories found
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Get started by creating your first category.
                </p>

                <a href="{{ route('categories.create') }}"
                   class="mt-5 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    + Create Category
                </a>

            </div>

        @else

            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full whitespace-nowrap text-left">

                    <thead class="bg-slate-50">

                        <tr class="text-xs font-semibold uppercase tracking-wider text-slate-500">

                            <th class="px-6 py-4">ID</th>

                            <th class="px-6 py-4">Category Name</th>

                            <th class="px-6 py-4">Description</th>

                            <th class="px-6 py-4">Status</th>

                            <th class="px-6 py-4">Created At</th>

                            <th class="px-6 py-4 text-right">Actions</th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach ($categories as $category)

                            <tr class="transition hover:bg-slate-50">

                                {{-- ID --}}
                                <td class="px-6 py-5 text-sm font-medium text-slate-500">
                                    {{-- #{{ $category->id }} --}}
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Category Name --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-sm font-bold text-indigo-600">
                                            {{ strtoupper(substr($category->name, 0, 1)) }}
                                        </div>

                                        <span class="text-sm font-semibold text-slate-900">
                                            {{ $category->name }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Description --}}
                                <td class="max-w-xs truncate px-6 py-5 text-sm text-slate-500">
                                    {{ $category->description ?: 'No description' }}
                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-5">

                                    @if ($category->is_active)

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- Created Date --}}
                                <td class="px-6 py-5 text-sm text-slate-500">
                                    {{ $category->created_at?->format('d M Y') ?? 'N/A' }}
                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-end gap-2">

                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                                            Edit
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this category?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif


        {{-- Table Footer --}}
        @if ($categories->isNotEmpty())

            <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                <p class="text-xs text-slate-500">
                    Showing
                    <span class="font-semibold text-slate-700">{{ $categories->count() }}</span>
                    categories.
                </p>
            </div>

        @endif

    </section>

</div>

@endsection
