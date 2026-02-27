@extends('layouts.app')

@section('title', 'Books')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Books</h2>
            <p class="text-gray-600">Manage your book collection</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('books.create') }}"
               class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Add Book</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
        <div class="p-6">
            @if($books->isEmpty())
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-300 mx-auto mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <p class="text-gray-500">No books yet. <a href="{{ route('books.create') }}" class="text-indigo-600 font-medium">Add your first book!</a></p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Cover</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Title</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">ISBN</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Author</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Category</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Published</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($books as $book)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                 alt="{{ $book->title }}"
                                                 class="w-10 h-14 object-cover rounded-lg shadow"/>
                                        @else
                                            <div class="w-10 h-14 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-indigo-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="font-medium text-gray-800">{{ $book->title }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $book->isbn }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-600">{{ $book->author_name }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-600 text-xs rounded-full font-medium">{{ $book->category_name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-500">
                                        {{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('d M, Y') : '—' }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('books.edit', $book->id) }}"
                                               class="px-3 py-1.5 text-xs bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors font-medium">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('books.destroy', $book->id) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete this book?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-xs bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors font-medium">
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

                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
