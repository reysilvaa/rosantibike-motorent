@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Edit Rating</h1>

    <form action="{{ route('admin.rating.update', $rating->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $rating->nama) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
            <input type="text" id="role" name="role" value="{{ old('role', $rating->role) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('role')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi', $rating->deskripsi) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
            <input type="number" id="rating" name="rating" value="{{ old('rating', $rating->rating) }}" min="1" max="5" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('rating')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $rating->tanggal->format('Y-m-d')) }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('tanggal')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.rating.index') }}" class="text-gray-500 hover:text-gray-700 mr-4 transition duration-200">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
        </div>
    </form>
</div>
@endsection
