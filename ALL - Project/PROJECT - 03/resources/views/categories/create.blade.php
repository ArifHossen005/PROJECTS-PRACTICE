@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="flex items-center space-x-3 mb-8">
        <a href="{{ route('categories.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Create Category</h2>
            <p class="text-gray-600">Add a new book category</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
            <div class="p-6">
                <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                            placeholder="e.g. Fiction, Science, History"/>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="{{ route('categories.index') }}"
                           class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
