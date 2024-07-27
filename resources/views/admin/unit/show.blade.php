@extends('layouts.admin')

@section('title', 'Transaksi Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Detail Jenis Motor</h1>

    <div class="flex flex-col md:flex-row items-start">
        <!-- Photo Section -->
        <div class="md:w-1/2 mb-6 md:mb-0 md:pr-6">
            <img src="{{ $jenisMotor->foto ? (filter_var($jenisMotor->foto, FILTER_VALIDATE_URL) ? $jenisMotor->foto : asset('storage/' . $jenisMotor->foto)) : 'https://via.placeholder.com/600x400' }}" alt="{{ $jenisMotor->merk }}" class="w-full h-64 object-cover rounded-lg shadow-md">
        </div>

        <!-- Details Section -->
        <div class="md:w-1/2">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Merk:</label>
                <p class="mt-1 text-gray-900 text-lg">{{ $jenisMotor->merk }}</p>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Nopol:</label>
                <p class="mt-1 text-gray-900 text-lg">{{ $jenisMotor->nopol }}</p>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Harga per Hari:</label>
                <p class="mt-1 text-gray-900 text-lg">{{ number_format($jenisMotor->harga_perHari, 0, ',', '.') }}</p>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('admin.jenisMotor.edit', $jenisMotor->id) }}" class="inline-block px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 transition duration-300">Edit</a>

                <form action="{{ route('admin.jenisMotor.destroy', $jenisMotor->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-block px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-300" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
