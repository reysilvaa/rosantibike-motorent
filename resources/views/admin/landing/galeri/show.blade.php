@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Galeri Details</h1>

    <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-md">
        <div class="mb-4">
            <strong class="text-gray-700">Judul:</strong>
            <p class="mt-1">{{ $galeri->judul }}</p>
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Deskripsi:</strong>
            <p class="mt-1">{{ $galeri->deskripsi }}</p>
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Full Description:</strong>
            <p class="mt-1">{{ $galeri->full_description }}</p>
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Foto:</strong>
            <div class="mt-1">
                <img src="{{ $galeri->foto }}" alt="Galeri Foto" class="w-full max-w-xs rounded-lg shadow-md">
            </div>
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Kategori:</strong>
            <p class="mt-1">{{ ucfirst($galeri->kategori) }}</p>
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Link Maps:</strong>
            <p class="mt-1"><a href="{{ $galeri->link_maps }}" target="_blank" class="text-blue-500 hover:underline">{{ $galeri->link_maps }}</a></p>
        </div>

        <a href="{{ route('galeri.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to List</a>
    </div>
</div>
@endsection
