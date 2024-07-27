@extends('layouts.admin')

{{-- @section('title', 'Transaksi Management') --}}

@section('content')

<div x-data="{ showModal: false, selectedMotor: null }" class="bg-gray-100 min-h-screen p-8">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2" x-data="{ show: false }" x-intersect="show = true">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-teal-400"
                  x-show="show"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 transform translate-y-4"
                  x-transition:enter-end="opacity-100 transform translate-y-0">
            </span>
        </h1>
        <ol class="breadcrumb mb-6 flex items-center space-x-2 text-sm text-gray-600">
            {{-- <li class="breadcrumb-item">List Transaksi</li> --}}
        </ol>

        <div class="container mx-auto px-4">
            <a href="{{ route('admin.jenisMotor.create') }}"
               class="mb-6 inline-block px-6 py-3 bg-gradient-to-r from-green-500 to-yellow-400 text-white font-semibold rounded-lg shadow hover:from-green-600 hover:to-yellow-500 transition duration-300 transform hover:scale-105 underline">
                Add New Jenis Motor
            </a>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($jenisMotors as $jenisMotor)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105"
                         x-data="{ hover: false }"
                         @mouseenter="hover = true"
                         @mouseleave="hover = false">
                        <div class="relative overflow-hidden">
                            <img src="{{ $jenisMotor->foto ? (filter_var($jenisMotor->foto, FILTER_VALIDATE_URL) ? $jenisMotor->foto : asset('storage/' . $jenisMotor->foto)) : 'https://via.placeholder.com/600x400' }}"
                                 alt="{{ $jenisMotor->merk }}"
                                 loading="lazy"
                                 class="w-full h-64 object-cover transition duration-500 ease-in-out transform hover:scale-110">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 transition duration-500 ease-in-out"
                                 :class="{ 'opacity-100': hover }">
                                <button @click="showModal = true; selectedMotor = $event.target.closest('div').querySelector('h2').textContent"
                                        class="px-4 py-2 bg-white text-gray-800 rounded-lg font-semibold hover:bg-gray-200 transition duration-300">
                                    Quick View
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $jenisMotor->merk }}</h2>
                            <p class="text-gray-600 mb-1"><i class="fas fa-motorcycle mr-2"></i>Nopol: {{ $jenisMotor->nopol }}</p>
                            <p class="text-gray-600 mb-4"><i class="fas fa-tag mr-2"></i>Harga per Hari: Rp {{ number_format($jenisMotor->harga_perHari, 0, ',', '.') }}</p>
                            <div class="flex justify-end space-x-2 mt-4">
                                <a href="{{ route('admin.jenisMotor.show', $jenisMotor->id) }}" class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 transition duration-300 transform hover:scale-105 underline">View</a>
                                <a href="{{ route('admin.jenisMotor.edit', $jenisMotor->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 transition duration-300 transform hover:scale-105 underline">Edit</a>
                                <form action="{{ route('admin.jenisMotor.destroy', $jenisMotor->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition duration-300 transform hover:scale-105 underline">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Quick View: <span x-text="selectedMotor"></span>
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Here you can add more details about the selected motor.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="showModal = false" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm underline">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
