@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-900">Edit Rating</h1>

    <form action="{{ route('admin.rating.update', $rating->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-6 flex items-center">
            <label for="name" class="block text-sm font-medium text-gray-700 w-1/4">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $rating->nama) }}" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center">
            <label for="role" class="block text-sm font-medium text-gray-700 w-1/4">Role</label>
            <input type="text" id="role" name="role" value="{{ old('role', $rating->role) }}" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('role')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 w-1/4">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>{{ old('deskripsi', $rating->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 w-1/4">Date</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $rating->tanggal->format('Y-m-d')) }}" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('tanggal')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center space-x-4">
            <div class="flex">
                <x-back-to-list-button route="{{ route('admin.rating.index') }}" />
            </div>
            <div class="flex">
                <button type="submit" class="bg-blue-500 text-white px-10 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                    Save
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
