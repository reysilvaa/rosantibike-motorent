@extends('layouts.admin')

@section('content')

<div x-data="{ showModal: false, selectedMotor: null }" class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-semibold text-gray-900 mb-6">
            Stok Management
        </h1>

        <div class="mb-6">
            <a href="{{ route('admin.stok.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-500 transition-colors duration-300">
                Add New Stok
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($stok as $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden transition-transform duration-300 hover:scale-105">
                    <div class="relative w-full" style="padding-top: 66.67%; max-width: 600px; max-height: 400px;">
                        <img src="{{ $item->foto ? (filter_var($item->foto, FILTER_VALIDATE_URL) ? $item->foto : asset('storage/' . $stok->foto)) : 'https://via.placeholder.com/600x400' }}"
                             alt="{{ $item->merk }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 ease-in-out hover:scale-110"
                             style="max-width: 600px; max-height: 400px;">
                    </div>
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $item->merk }}</h2>
                        <p class="text-gray-700 mb-4">Harga per Hari: Rp {{ number_format($item->harga_perHari, 0, ',', '.') }}</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.stok.show', $item->id) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white font-medium rounded-md shadow-sm hover:bg-blue-500 transition-colors duration-300">
                                View
                            </a>
                            <a href="{{ route('admin.stok.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 bg-yellow-500 text-white font-medium rounded-md shadow-sm hover:bg-yellow-400 transition-colors duration-300">
                                Edit
                            </a>
                            <form action="{{ route('admin.stok.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-500 text-white font-medium rounded-md shadow-sm hover:bg-red-400 transition-colors duration-300">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300" aria-hidden="true"></div>

            <div x-show="showModal"
                 x-transition:enter="transition transform ease-out duration-300"
                 x-transition:enter-start="scale-95 opacity-0"
                 x-transition:enter-end="scale-100 opacity-100"
                 x-transition:leave="transition transform ease-in duration-200"
                 x-transition:leave-start="scale-100 opacity-100"
                 x-transition:leave-end="scale-95 opacity-0"
                 class="bg-white rounded-lg shadow-lg max-w-md mx-auto">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick View: <span x-text="selectedMotor" class="text-blue-600"></span></h3>
                    <p class="text-gray-600">Here you can add more details about the selected motor.</p>
                </div>
                <div class="p-4 flex justify-end">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-800 text-white font-medium rounded-md hover:bg-gray-700 transition-colors duration-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
