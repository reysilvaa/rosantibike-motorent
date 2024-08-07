@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 lg:px-8 py-12">
    <div class="max-w-4xl mx-auto bg-white p-8 border border-gray-200 rounded-lg shadow-xl relative">
        <!-- Badge Category -->
        <div class="absolute top-4 right-4">
            <span class="bg-blue-600 text-white text-xs font-semibold uppercase py-1 px-3 rounded-full shadow-md">
                {{ ucfirst($galeri->kategori) }}
            </span>
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $galeri->judul }}</h1>
        <div class="text-sm text-gray-500 mb-6">
            <span>Published on {{ \Carbon\Carbon::parse($galeri->created_at)->format('F j, Y') }}</span>
        </div>

        <!-- Image -->
        <div class="mb-8">
            <img src="{{ $galeri->foto }}" alt="Galeri Foto" class="w-full max-w-3xl mx-auto rounded-lg shadow-2xl hover:scale-105 transition-transform duration-300 ease-in-out">
        </div>

        <!-- Deskripsi -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Deskripsi</h2>
            <p class="text-gray-700 leading-relaxed">{{ $galeri->deskripsi }}</p>
        </div>

        <!-- Full Description -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Full Description</h2>
            <p x-data="{ open: false }" class="text-gray-700 leading-relaxed">
                <span x-show="!open">{{ Str::limit($galeri->full_description, 300) }}</span>
                <span x-show="open">{{ $galeri->full_description }}</span>
                <button @click="open = !open" class="text-blue-600 hover:underline mt-2 text-sm font-medium">
                    <span x-show="!open">Read More</span>
                    <span x-show="open">Show Less</span>
                </button>
            </p>
        </div>

        <!-- Link Maps -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Link Maps</h2>
            <a href="{{ $galeri->link_maps }}" target="_blank" class="text-blue-600 hover:underline">{{ $galeri->link_maps }}</a>
        </div>

        <!-- Back to List Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('admin.galeri.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection
