@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold mb-4">Galeri List</h1>

        <a href="{{ route('admin.galeri.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-transform transform hover:scale-105">Add New Galeri</a>

        <div class="mt-4 flex flex-wrap -m-2">
            @foreach($galeris as $galeri)
                <div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 p-2" x-data="{ open: false }">
                    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 transition-transform transform hover:scale-105 hover:shadow-xl">
                        <h2 class="text-lg font-semibold mb-2">{{ $galeri->judul }}</h2>
                        <p class="text-gray-700 mb-4">{{ Str::limit($galeri->deskripsi, 30) }}</p>
                        <div class="flex justify-between items-center">
                            <!-- Toggle button -->
                            <button @click="open = !open" class="text-blue-500 hover:text-blue-600 transition-colors duration-300 hover:underline">
                                <!-- Show or hide details based on 'open' -->
                                <span x-text="open ? 'Hide Details' : 'Show Details'"></span>
                            </button>
                            <div class="flex space-x-2">
                                <!-- Action buttons -->
                                <a href="{{ route('admin.galeri.show', $galeri) }}" class="text-blue-500 hover:text-blue-600 transition-colors duration-300 hover:underline">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.galeri.edit', $galeri) }}" class="text-yellow-500 hover:text-yellow-600 transition-colors duration-300 hover:underline">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.galeri.destroy', $galeri) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 transition-colors duration-300 hover:underline">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Conditional details display with animation -->
                        <div x-show="open" x-transition:enter="transition-opacity duration-500" x-transition:enter-start="opacity-0" x-transition:leave="transition-opacity duration-500" x-transition:leave-end="opacity-0" class="mt-4">
                            <p class="text-gray-600">{{ $galeri->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
