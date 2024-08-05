@extends('layouts.admin')

@section('content')

<div x-data="{ showModal: false, selectedMotor: null }" class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">
            Jenis Motor Management
        </h1>

        <div class="mb-8 text-right">
            <a href="{{ route('admin.jenisMotor.create') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg shadow-md hover:bg-blue-500 transition-colors duration-300">
                Add New Jenis Motor
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($jenisMotors as $jenisMotor)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="relative w-full h-48">
                        <img src="{{ $jenisMotor->stok->foto ? (filter_var($jenisMotor->stok->foto, FILTER_VALIDATE_URL) ? $jenisMotor->stok->foto : asset('storage/' . $jenisMotor->stok->foto)) : 'https://via.placeholder.com/600x400' }}"
                             alt="{{ $jenisMotor->stok->merk }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 ease-in-out hover:scale-105">
                    </div>
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $jenisMotor->stok->merk }}</h2>
                        <p class="text-gray-600 mb-1">Nopol: {{ $jenisMotor->nopol }}</p>
                        <p class="text-gray-600 mb-4">Harga per Hari: Rp {{ number_format($jenisMotor->stok->harga_perHari, 0, ',', '.') }}</p>
                        <div class="flex justify-between space-x-4">
                            <a href="{{ route('admin.jenisMotor.show', $jenisMotor->id) }}" class="text-blue-600 hover:underline">
                                View
                            </a>
                            <a href="{{ route('admin.jenisMotor.edit', $jenisMotor->id) }}" class="text-yellow-500 hover:underline">
                                Edit
                            </a>
                            <form action="{{ route('admin.jenisMotor.destroy', $jenisMotor->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <x-back-to-list-button route="{{ route('dashboard') }}" />
    </div>
</div>

@endsection
