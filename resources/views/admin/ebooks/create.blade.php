@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Add New Ebook</h2>
        <a href="{{ route('admin.ebooks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded transition duration-200">← Back</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.ebooks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="short_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Short Description *</label>
                <textarea name="short_description" id="short_description" rows="3" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('short_description') }}</textarea>
                @error('short_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price (USD) *</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-end">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500 mr-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active (visible to visitors)</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <p class="mt-1 text-xs text-gray-500">Recommended: High-quality cover image (JPG/PNG, max 2MB)</p>
                @error('cover_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="pdf_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PDF File * <span class="text-red-500">(Required)</span></label>
                <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-xs text-gray-500">Upload the ebook PDF file (max 50MB). This will be sent to customers upon approval.</p>
                @error('pdf_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-sm transition-colors">
                    Create Ebook
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
