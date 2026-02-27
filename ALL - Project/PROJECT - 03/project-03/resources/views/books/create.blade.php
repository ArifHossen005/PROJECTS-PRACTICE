@extends('layouts.app')

@section('title', 'Create Book')

@section('content')
    <div class="flex items-center space-x-3 mb-8">
        <a href="{{ route('books.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Create Book</h2>
            <p class="text-gray-600">Add a new book to the collection</p>
        </div>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
            <div class="p-6">
                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Cover Image Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Book Cover</label>
                        <div class="flex items-start space-x-6">
                            <div class="flex-shrink-0">
                                {{-- Image Preview --}}
                                <div id="imagePreview"
                                     class="w-28 h-40 rounded-lg bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-300" id="previewIcon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                    <img id="previewImg" src="" alt="" class="w-full h-full object-cover hidden"/>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-all"
                                     onclick="document.getElementById('cover_image').click()">
                                    <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/jpg"
                                           class="hidden" onchange="previewImage(event)"/>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400 mx-auto mb-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <span class="font-medium text-indigo-600">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">JPEG, PNG, JPG up to 2MB</p>
                                </div>
                                @error('cover_image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Title & ISBN --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Book Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                                placeholder="Enter book title"/>
                            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                ISBN <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}"
                                class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all {{ $errors->has('isbn') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                                placeholder="978-0-7475-3269-9"/>
                            @error('isbn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Author & Category Dropdowns --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Author <span class="text-red-500">*</span>
                            </label>
                            <select name="author_id"
                                class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all {{ $errors->has('author_id') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                                <option value="">Select an author</option>
                                @foreach($authors as $id => $name)
                                    <option value="{{ $id }}" {{ old('author_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id"
                                class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                                <option value="">Select a category</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Published Date --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Published Date</label>
                        <input type="date" name="published_at" value="{{ old('published_at') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"/>
                        @error('published_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none"
                            placeholder="Enter book description...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="{{ route('books.index') }}"
                           class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
                            Create Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // ব্যাখ্যা: JavaScript দিয়ে image preview করা হচ্ছে।
    // File select করলে সাথে সাথে ছবি দেখাবে।
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('previewImg');
                const icon = document.getElementById('previewIcon');
                img.src = e.target.result;
                img.classList.remove('hidden');
                icon.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
