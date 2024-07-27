@extends('layouts.admin')

@section('title', 'Edit Jenis Motor')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Edit Jenis Motor</h1>

    <form action="{{ route('admin.jenisMotor.update', $jenisMotor->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md flex">
        @csrf
        @method('PUT')

        <!-- Form Inputs -->
        <div class="flex-1 pr-6">
            <div class="mb-6">
                <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
                <input type="text" name="merk" id="merk" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('merk', $jenisMotor->merk) }}" required>
                @error('merk')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="nopol" class="block text-sm font-medium text-gray-700">Nopol</label>
                <input type="text" name="nopol" id="nopol" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('nopol', $jenisMotor->nopol) }}" required>
                @error('nopol')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="harga_perHari" class="block text-sm font-medium text-gray-700">Harga per Hari</label>
                <input type="number" name="harga_perHari" id="harga_perHari" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('harga_perHari', $jenisMotor->harga_perHari) }}" required>
                @error('harga_perHari')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo URL Input -->
            <div class="mb-6">
                <label for="foto_url" class="block text-sm font-medium text-gray-700">Photo URL</label>
                <p class="text-sm text-gray-500 mt-2">Enter a URL if you want to use an external photo. Leave blank if you are uploading a file.</p>
                <input type="text" name="foto_url" id="foto_url" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('foto_url', $jenisMotor->foto_url) }}">
                @error('foto_url')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Upload Input -->
            <div class="mb-6">
                <label for="foto" class="block text-sm font-medium text-gray-700">Upload Photo</label>
                <p class="text-sm text-gray-500 mt-2">Leave blank if you do not want to upload a new photo.</p>
                <input type="file" name="foto" id="foto" class="form-input mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">Update</button>
        </div>

        <!-- Photo Preview -->
        <div class="flex-none w-1/4 ml-6">
            @if ($jenisMotor->foto_url)
                <div class="mb-4">
                    <img src="{{ $jenisMotor->foto_url }}" alt="{{ $jenisMotor->merk }}" class="w-full h-auto object-cover rounded-lg border border-gray-300 shadow-sm">
                </div>
            @elseif ($jenisMotor->foto)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $jenisMotor->foto) }}" alt="{{ $jenisMotor->merk }}" class="w-full h-auto object-cover rounded-lg border border-gray-300 shadow-sm">
                </div>
            @else
                <p class="text-gray-500 mb-2">No photo available.</p>
            @endif
        </div>
    </form>
    <x-back-to-list-button route="{{ route('admin.jenisMotor.index') }}" />
</div>
@endsection
