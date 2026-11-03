@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
    <div class="space-y-6">

        {{-- Page heading and create button --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                    Supplier Management
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Manage your suppliers and their contact information.
                </p>
            </div>

            <a href="{{ route('suppliers.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                + Add Supplier
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Supplier statistics --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Suppliers</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $suppliers->count() }}
                </p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Active Suppliers</p>
                <p class="mt-2 text-3xl font-bold text-green-600">
                    {{ $suppliers->where('is_active', true)->count() }}
                </p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Inactive Suppliers</p>
                <p class="mt-2 text-3xl font-bold text-gray-500">
                    {{ $suppliers->where('is_active', false)->count() }}
                </p>
            </div>
        </div>

        {{-- Supplier table --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">All Suppliers</h2>
                <p class="mt-1 text-sm text-gray-500">
                    A list of all registered suppliers.
                </p>
            </div>

            @if ($suppliers->isEmpty())
                <div class="px-6 py-16 text-center">
                    <h3 class="text-lg font-semibold text-gray-900">
                        No suppliers found
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Get started by adding your first supplier.
                    </p>
                    <a href="{{ route('suppliers.create') }}"
                        class="mt-4 inline-flex rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Add Supplier
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">#</th>
                                <th class="px-6 py-4 font-semibold">Supplier</th>
                                <th class="px-6 py-4 font-semibold">Contact Person</th>
                                <th class="px-6 py-4 font-semibold">Email / Phone</th>
                                <th class="px-6 py-4 font-semibold">Address</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Created</th>
                                <th class="px-6 py-4 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($suppliers as $supplier)
                                <tr class="transition hover:bg-gray-50">
                                    {{-- Row number --}}
                                    <td class="whitespace-nowrap px-6 py-5 text-sm text-gray-400">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $supplier->name }}
                                        </div>
                                        {{-- <div class="mt-1 text-xs text-gray-400">
                                            ID: #{{ $supplier->id }}
                                        </div> --}}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                        {{ $supplier->contact_person ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-gray-700">
                                            {{ $supplier->email ?? 'N/A' }}
                                        </div>
                                        <div class="mt-1 text-xs text-gray-400">
                                            {{ $supplier->phone ?? 'No phone' }}
                                        </div>
                                    </td>

                                    <td class="max-w-xs px-6 py-4 text-gray-600">
                                        {{ $supplier->address ?: 'N/A' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($supplier->is_active)
                                            <span
                                                class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-gray-500">
                                        {{ $supplier->created_at?->format('d M Y') ?? 'N/A' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                                class="font-medium text-indigo-600 transition hover:text-indigo-800">
                                                Edit
                                            </a>

                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this supplier?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="font-medium text-red-600 transition hover:text-red-800">
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
        </div>
    </div>
@endsection
