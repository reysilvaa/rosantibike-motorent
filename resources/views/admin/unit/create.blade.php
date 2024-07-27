@extends('layouts.admin')

@section('title', 'Jenis Motor Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Create Jenis Motor</h1>
    <form action="{{ route('admin.jenisMotor.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-6">
            <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
            <input type="text" name="merk" id="merk" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            @error('merk')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="nopol" class="block text-sm font-medium text-gray-700">Nopol</label>
            <input type="text" name="nopol" id="nopol" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            @error('nopol')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="harga_perHari" class="block text-sm font-medium text-gray-700">Harga per Hari</label>
            <input type="number" name="harga_perHari" id="harga_perHari" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            @error('harga_perHari')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="foto_url" class="block text-sm font-medium text-gray-700">Foto URL</label>
            <input type="text" name="foto_url" id="foto_url" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="https://example.com/image.jpg">
            @error('foto_url')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
            <p class="text-sm text-gray-500 mt-2">Upload a photo or leave blank if you want to use a URL.</p>
            <input type="file" name="foto" id="foto" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            @error('foto')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">Create</button>
    </form>
</div>
@endsection
