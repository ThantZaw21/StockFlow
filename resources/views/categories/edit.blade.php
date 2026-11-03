@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="mx-auto max-w-4xl space-y-8">

        {{-- Page heading --}}
        <div>
            <a href="{{ route('categories.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 transition hover:text-indigo-800">
                ← Back to Categories
            </a>

            <div class="mt-5">
                <p class="text-sm font-medium text-indigo-600">
                    Category Management
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                    Edit Category
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Update your category information and status.
                </p>
            </div>
        </div>

        {{-- Category information card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            {{-- Card heading --}}
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-xl font-bold text-indigo-600">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Category Information
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Editing: {{ $category->name }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Edit form --}}
            <form action="{{ route('categories.update', $category->id) }}"
                method="POST"
                class="space-y-8 p-6">

                @csrf
                @method('PUT')

                {{-- Category name --}}
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">
                        Category Name
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $category->name) }}"
                        placeholder="e.g. Electronics"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-gray-700">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Write a short description about this category..."
                        class="w-full resize-y rounded-xl border border-gray-300 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">{{ old('description', $category->description) }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="is_active" class="mb-2 block text-sm font-semibold text-gray-700">
                        Category Status
                    </label>

                    <select
                        id="is_active"
                        name="is_active"
                        required
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                        <option value="1"
                            {{ old('is_active', $category->is_active) == '1' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('is_active', $category->is_active) == '0' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                    @error('is_active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-gray-500">
                        Inactive categories won't appear in the product category dropdown.
                    </p>
                </div>

                {{-- Category metadata --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Category Information
                    </p>

                    <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs text-gray-500">Category ID</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">
                                #{{ $category->id }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Created At</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $category->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">

                    <a href="{{ route('categories.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                        Save Changes
                    </button>

                </div>

            </form>
        </div>
    </div>
@endsection