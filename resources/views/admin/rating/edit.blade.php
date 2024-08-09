@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-900">Edit Rating</h1>

    <form action="{{ route('admin.rating.update', $rating->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-lg rounded-lg p-8 space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Field -->
        <div class="flex flex-col space-y-2">
            <label for="nama" class="text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $rating->nama) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('nama')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Role Field -->
        <div class="flex flex-col space-y-2">
            <label for="role" class="text-sm font-medium text-gray-700">Role</label>
            <input type="text" id="role" name="role" value="{{ old('role', $rating->role) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('role')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi Field -->
        <div class="flex flex-col space-y-2">
            <label for="deskripsi" class="text-sm font-medium text-gray-700">Description</label>
            <textarea id="deskripsi" name="deskripsi" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>{{ old('deskripsi', $rating->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Rating Field -->
        <div x-data="{ rating: {{ old('rating', $rating->rating) }} }" class="flex flex-col space-y-2">
            <label for="rating" class="text-sm font-medium text-gray-700">Rating</label>
            <div class="flex space-x-1">
                <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                    <svg @click="rating = star" :class="{'text-yellow-400': star <= rating, 'text-gray-300': star > rating}" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 cursor-pointer transition duration-200 transform hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 17.27l-5.18 3.01 1.36-5.92L2 8.6l6.09-.51L12 2l3.91 6.09 6.09.51-4.18 3.76 1.36 5.92z"/>
                    </svg>
                </template>
            </div>
            <input type="hidden" id="rating" name="rating" :value="rating">
            @error('rating')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Field -->
        <div class="flex flex-col space-y-2">
            <label for="tanggal" class="text-sm font-medium text-gray-700">Date</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $rating->tanggal->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            @error('tanggal')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <!-- Avatar Upload & Preview -->
        <div x-data="{ avatarUrl: '{{ old('avatar_url', Storage::url($rating->avatar)) }}', avatarFile: null }" class="flex flex-col space-y-4">
            <label for="avatar" class="text-sm font-medium text-gray-700">Avatar</label>

            <!-- Avatar Preview -->
            <div class="flex justify-center">
                <template x-if="avatarFile || avatarUrl">
                    <img :src="avatarFile ? URL.createObjectURL(avatarFile) : avatarUrl" alt="Avatar Preview" class="w-32 h-32 rounded-full object-cover shadow-lg border-2 border-gray-300">
                </template>
                <template x-if="!avatarFile && !avatarUrl">
                    <div class="flex items-center justify-center w-32 h-32 bg-gray-100 rounded-full shadow-inner">
                        <span class="text-gray-500">No Avatar</span>
                    </div>
                </template>
            </div>

            <!-- Avatar Upload -->
            <div class="flex flex-col space-y-2">
                <input @change="avatarFile = $event.target.files[0]; avatarUrl = ''" type="file" id="avatar" name="avatar" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('avatar')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror

                <!-- Avatar URL -->
                <input @input="avatarUrl = $event.target.value; avatarFile = null" type="url" id="avatar_url" name="avatar_url" value="{{ old('avatar_url', $rating->avatar_url) }}" placeholder="https://example.com/avatar.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('avatar_url')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 text-white px-8 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
