@extends('layouts.app')

@section('title', 'Authors')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Authors</h2>
            <p class="text-gray-600">Manage book authors</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('authors.create') }}"
               class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>Add Author</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
        <div class="p-6">
            @if($authors->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500">No authors yet. <a href="{{ route('authors.create') }}" class="text-indigo-600 font-medium">Add one!</a></p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">#</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Name</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Bio</th>
                                <th class="text-right py-3 px-4 font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($authors as $author)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4">
                                        <span class="font-medium text-gray-800">{{ $author->name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-600 max-w-xs">
                                        {{ \Illuminate\Support\Str::limit($author->bio, 80) }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('authors.edit', $author->id) }}"
                                               class="px-3 py-1.5 text-xs bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors font-medium">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('authors.destroy', $author->id) }}"
                                                  onsubmit="return confirm('Delete this author? Books linked to this author may also be affected.')">
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
                    {{ $authors->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
