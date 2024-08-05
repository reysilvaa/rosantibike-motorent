@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-4xl font-bold mb-8 text-gray-800 text-center">Create Galeri</h1>

    <!-- Display Error Messages -->
    @if ($errors->any())
        <div class="mb-4">
            @foreach ($errors->all() as $error)
                <div class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium">
                        {{ $error }}
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" aria-label="Close">
                        <span class="sr-only">Dismiss</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Display Success Message -->
    @if (session('success'))
        <div class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <form action="{{ route('admin.galeri.store') }}" method="POST" class="bg-white p-8 border border-gray-200 rounded-xl shadow-2xl">
        @csrf

        <div class="space-y-8">
            <!-- Form Fields -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="judul" class="text-gray-700 font-semibold">Judul</label>
                <input type="text" name="judul" id="judul" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" maxlength="100" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="deskripsi" class="text-gray-700 font-semibold">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" maxlength="100" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <label for="full_description" class="text-gray-700 font-semibold pt-2">Full Description</label>
                <textarea name="full_description" id="full_description" class="col-span-2 form-textarea rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" rows="4" required></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="foto" class="text-gray-700 font-semibold">Foto URL</label>
                <input type="text" name="foto" id="foto" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start" x-data="{ category: '' }">
                <label class="text-gray-700 font-semibold pt-2">Kategori</label>
                <div class="col-span-2 grid grid-cols-2 gap-4">
                    <template x-for="cat in ['alam', 'sejarah', 'kuliner', 'budaya']" :key="cat">
                        <button type="button"
                                @click="category = cat"
                                :class="{
                                    'bg-indigo-600 text-white border border-indigo-600': category === cat,
                                    'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200': category !== cat,
                                    'focus:outline-none focus:ring-4 focus:ring-indigo-300': true
                                }"
                                class="py-3 px-4 rounded-lg transition duration-150 ease-in-out focus:ring-opacity-50 text-sm font-medium uppercase">
                            <span x-text="cat"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="kategori" x-model="category" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="link_maps" class="text-gray-700 font-semibold">Link Maps</label>
                <input type="text" name="link_maps" id="link_maps" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" required>
            </div>

            <div class="flex justify-between mt-8">
                <x-back-to-list-button route="{{ route('admin.galeri.index') }}" />
                <button type="submit" class="bg-indigo-600 text-white rounded-lg px-6 py-3 font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Create</button>
            </div>
        </div>
    </form>
</div>
@endsection
