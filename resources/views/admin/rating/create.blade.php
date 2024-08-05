@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-900">Add New Rating</h1>

    <form action="{{ route('admin.rating.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-6 flex items-center">
            <label for="nama" class="block text-sm font-medium text-gray-700 w-1/4">Name</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('nama')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center">
            <label for="role" class="block text-sm font-medium text-gray-700 w-1/4">Role</label>
            <input type="text" id="role" name="role" value="{{ old('role') }}" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('role')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 w-1/4">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ rating: {{ old('rating', 0) }} }" class="mb-6 flex items-center">
            <label for="rating" class="block text-sm font-medium text-gray-700 w-1/4">Rating</label>
            <div class="flex items-center w-3/4">
                <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                    <svg @click="rating = star" :class="{'text-yellow-400': star <= rating, 'text-gray-300': star > rating}" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 cursor-pointer" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 17.27l-5.18 3.01 1.36-5.92L2 8.6l6.09-.51L12 2l3.91 6.09 6.09.51-4.18 3.76 1.36 5.92z"/>
                    </svg>
                </template>
                <input type="hidden" id="rating" name="rating" :value="rating">
            </div>
            @error('rating')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 w-1/4">Date</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('tanggal')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.rating.index') }}" class="text-gray-500 hover:text-gray-700 transition duration-200">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Save</button>
        </div>
    </form>
</div>
@endsection
