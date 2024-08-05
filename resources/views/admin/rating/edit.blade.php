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

        <@extends('layouts.admin')

        @section('content')
            <div class="container mx-auto px-4 py-8">
                <h1 class="text-3xl font-bold mb-6 text-center">Add New Rating</h1>

                <form action="{{ route('admin.rating.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <label for="nama" class="w-1/4 text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="ml-4 block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <label for="role" class="w-1/4 text-sm font-medium text-gray-700">Role</label>
                        <input type="text" id="role" name="role" value="{{ old('role') }}" class="ml-4 block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <label for="deskripsi" class="w-1/4 text-sm font-medium text-gray-700">Deskripsi</label>
                        <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" class="ml-4 block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <label for="rating" class="w-1/4 text-sm font-medium text-gray-700">Rating</label>
                        <div class="ml-4 flex items-center">
                            <template x-for="(star, index) in 5" :key="index">
                                <svg
                                    @click="rating = index + 1"
                                    :class="{'text-yellow-500': rating > index, 'text-gray-300': rating <= index}"
                                    class="h-6 w-6 cursor-pointer"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.193 6.736h7.065c.969 0 1.371 1.24.588 1.81l-5.708 4.14 2.193 6.736c.3.921-.755 1.688-1.54 1.12l-5.708-4.14-5.708 4.14c-.784.568-1.84-.199-1.54-1.12l2.193-6.736-5.708-4.14c-.784-.57-.381-1.81.588-1.81h7.065l2.193-6.736z"/>
                                </svg>
                            </template>
                            <input type="hidden" name="rating" x-model="rating">
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <label for="tanggal" class="w-1/4 text-sm font-medium text-gray-700">Date</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" class="ml-4 block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('tanggal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.rating.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('ratingComponent', () => ({
                        rating: 0
                    }));
                });
            </script>
        @endsection
        <div class="mb-6 flex items-center">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 w-1/4">Date</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $rating->tanggal->format('Y-m-d')) }}" class="block w-3/4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('tanggal')
                <p class="text-red-500 text-xs mt-1 w-3/4 ml-auto">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.rating.index') }}" class="text-gray-500 hover:text-gray-700 transition duration-200">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
        </div>
    </form>
</div>
@endsection
