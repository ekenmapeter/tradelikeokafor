@extends('admin.layout')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Create New Blog Post</h2>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured Image</label>
            <input type="file" name="image" id="image" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x630px. Max 2MB.</p>
        </div>

        <div class="mb-4">
            <label for="short_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Short Description</label>
            <textarea name="short_description" id="short_description" rows="3" required class="w-full px-4 py-2 border rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('short_description') }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Used for post previews and SEO. Max 500 characters.</p>
        </div>

        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
            <div class="dark:text-gray-900">
                <textarea name="content" id="editor" rows="15" class="w-full px-4 py-2 border rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('content') }}</textarea>
            </div>
        </div>

        <div class="mb-6 flex items-center">
            <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <label for="is_published" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Publish Immediately</label>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.blog.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition duration-200">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 shadow-md">Create Post</button>
        </div>
    </form>
</div>

<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }
    /* Fix for dark mode editor text visibility if needed, but CKEditor usually handles itself. 
       Ensuring the editor container doesn't clash with dark bg */
    .ck.ck-editor__main>.ck-editor__editable {
        background: #fff !important;
        color: #333 !important;
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{ route('admin.blog.upload', ['_token' => csrf_token()]) }}",
            },
            toolbar: [
                'heading', '|', 
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'imageUpload', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            image: {
                toolbar: [
                    'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                    'toggleImageCaption', 'imageTextAlternative'
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
