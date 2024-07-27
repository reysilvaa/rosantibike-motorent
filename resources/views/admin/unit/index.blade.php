@extends('layouts.admin')

@section('title', 'Transaksi Management')

@section('content')
<h1 class="mt-4 text-3xl font-bold text-gray-800">Transaksi</h1>
<ol class="breadcrumb mb-6 flex items-center space-x-2 text-sm text-gray-600">
    <li class="breadcrumb-item">List Transaksi</li>
</ol>

<div class="container mx-auto px-4">
    <a href="{{ route('admin.jenisMotor.create') }}" class="mb-6 inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-300">Add New Jenis Motor</a>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($jenisMotors as $jenisMotor)
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                <img src="{{ $jenisMotor->foto ? (filter_var($jenisMotor->foto, FILTER_VALIDATE_URL) ? $jenisMotor->foto : asset('storage/' . $jenisMotor->foto)) : 'https://via.placeholder.com/600x400' }}" alt="{{ $jenisMotor->merk }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $jenisMotor->merk }}</h2>
                    <p class="text-gray-500 mt-1">Nopol: {{ $jenisMotor->nopol }}</p>
                    <p class="text-gray-500 mt-1">Harga per Hari: {{ number_format($jenisMotor->harga_perHari, 0, ',', '.') }}</p>
                    <div class="flex justify-end space-x-2 mt-4">
                        <a href="{{ route('admin.jenisMotor.show', $jenisMotor->id) }}" class="inline-block px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition duration-300">View</a>
                        <a href="{{ route('admin.jenisMotor.edit', $jenisMotor->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 transition duration-300">Edit</a>
                        <form action="{{ route('admin.jenisMotor.destroy', $jenisMotor->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-300">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
