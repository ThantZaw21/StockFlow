
@extends('layouts.app')

@section('title', 'Create Supplier')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Page heading --}}
        <div>
            <a href="{{ route('suppliers.index') }}"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                &larr; Back to Suppliers
            </a>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-gray-900">
                Add New Supplier
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Enter the supplier's information to register them in your system.
            </p>
        </div>

        {{-- Supplier form card --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-gray-900">
                    Supplier Information
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Fields marked with * are required.
                </p>
            </div>

            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                    {{-- Supplier Name --}}
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                            Supplier Name <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter supplier name"
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >

                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contact Person --}}
                    <div>
                        <label for="contact_person" class="mb-2 block text-sm font-medium text-gray-700">
                            Contact Person
                        </label>

                        <input
                            type="text"
                            id="contact_person"
                            name="contact_person"
                            value="{{ old('contact_person') }}"
                            placeholder="Enter contact person's name"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >

                        @error('contact_person')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="supplier@example.com"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >

                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter phone number"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >

                        @error('phone')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="md:col-span-2">
                        <label for="address" class="mb-2 block text-sm font-medium text-gray-700">
                            Business Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="4"
                            placeholder="Enter supplier's business address"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >{{ old('address') }}</textarea>

                        @error('address')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="md:col-span-2">
                        <label for="is_active" class="mb-2 block text-sm font-medium text-gray-700">
                            Supplier Status <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="is_active"
                            name="is_active"
                            required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                        <p class="mt-1.5 text-xs text-gray-500">
                            Active suppliers can be used in your inventory operations.
                        </p>

                        @error('is_active')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Form actions --}}
                <div class="flex flex-col-reverse justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:flex-row">
                    <a href="{{ route('suppliers.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Create Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
