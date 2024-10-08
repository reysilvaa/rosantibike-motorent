@extends('layouts.admin')

@section('title', 'Detail Jenis Motor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8 text-gray-800">Detail Jenis Motor</h1>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Photo Section -->
            <div class="md:w-1/2">
                <img
                    src="{{ $stok->foto ? (filter_var($stok->foto, FILTER_VALIDATE_URL) ? $stok->foto : asset('storage/' . $stok->foto)) : 'https://via.placeholder.com/600x400' }}"
                    alt="{{ $stok->merk }}"
                    class="w-full h-80 object-cover"
                >
            </div>

            <!-- Details Section -->
            <div class="md:w-1/2 p-6 md:p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $stok->merk }}</h2>
                    <p class="text-sm text-gray-600">Banyak Unit: {{ $qty }}</p>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Harga per Hari</h3>
                    <p class="text-3xl font-bold text-indigo-600">Rp {{ number_format($stok->harga_perHari, 0, ',', '.') }}</p>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Deskripsi 1</h3>
                    <p class="text-3xl font-bold text-indigo-600"> {{ $stok->deskripsi1 }}</p>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Deskripsi 2</h3>
                    <p class="text-3xl font-bold text-indigo-600"> {{ $stok->deskripsi2 }}</p>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Deskripsi 3</h3>
                    <p class="text-3xl font-bold text-indigo-600"> {{ $stok->deskripsi3 }}</p>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Kategori</h3>
                    <p class="text-3xl font-bold text-indigo-600"> {{ $stok->kategori }}</p>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.stok.edit', $stok->id) }}" class="flex-1 px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 transition duration-300 text-center">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>

                    <form action="{{ route('admin.stok.destroy', $stok->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-300" onclick="return confirm('Are you sure you want to delete this item?')">
                            <i class="fas fa-trash-alt mr-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-back-to-list-button route="{{ route('admin.stok.index') }}" />

</div>
@endsection
