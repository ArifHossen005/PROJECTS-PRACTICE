@extends('layouts.app')

@section('title', 'Edit Author')

@section('content')
    <div class="flex items-center space-x-3 mb-8">
        <a href="{{ route('authors.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Author</h2>
            <p class="text-gray-600">Update author information</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
            <div class="p-6">
                <form method="POST" action="{{ route('authors.update', $author->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Author Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $author->name) }}"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                            placeholder="Author name"/>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Biography <span class="text-red-500">*</span>
                        </label>
                        <textarea name="bio" rows="5"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none {{ $errors->has('bio') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                            placeholder="Author biography...">{{ old('bio', $author->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="{{ route('authors.index') }}"
                           class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
                            Update Author
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
