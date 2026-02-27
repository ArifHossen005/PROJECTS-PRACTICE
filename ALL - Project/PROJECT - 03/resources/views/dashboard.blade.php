@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">My Dashboard</h2>
            <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    {{-- Profile Section --}}
    <div class="max-w-4xl">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center text-3xl font-bold text-indigo-600">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-6 flex-1">
                        <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border rounded-lg bg-gray-50">
                        <p class="text-gray-500 text-sm">Email</p>
                        <p class="font-medium text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div class="p-4 border rounded-lg bg-gray-50">
                        <p class="text-gray-500 text-sm">Member Since</p>
                        <p class="font-medium text-gray-800">{{ $user->created_at->format('d M, Y') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition-colors">Edit Profile</a>
                    <a href="{{ route('books.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm rounded-lg hover:border-indigo-400 hover:text-indigo-600 transition-colors">Manage Books</a>
                </div>
            </div>
        </div>
    </div>
@endsection
