@extends('layouts.admin')
@section('title', 'Manajemen Unit Motor')
@section('content')
<div x-data="{ activeTab: '{{ $errors->has('merk') || $errors->has('harga_perHari') || $errors->has('judul') || $errors->has('deskripsi1') || $errors->has('deskripsi2') || $errors->has('foto') ? 'stokMotor' : 'unitMotor' }}' }" class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-8">
                <h1 class="text-4xl font-bold text-white text-center">
                    Manajemen Unit Motor
                </h1>
            </div>

            <div class="p-8">
                <!-- Tab Navigation -->
                <div class="mb-8 flex justify-center space-x-6">
                    <button @click="activeTab = 'unitMotor'" :class="{ 'bg-indigo-600 text-white': activeTab === 'unitMotor', 'bg-gray-200 text-gray-700': activeTab !== 'unitMotor' }" class="px-6 py-3 rounded-full text-lg font-medium transition-all duration-300">
                        Unit Motor
                    </button>
                    <button @click="activeTab = 'stokMotor'" :class="{ 'bg-indigo-600 text-white': activeTab === 'stokMotor', 'bg-gray-200 text-gray-700': activeTab !== 'stokMotor' }" class="px-6 py-3 rounded-full text-lg font-medium transition-all duration-300">
                        Stok Motor
                    </button>
                </div>

                <!-- Unit Motor Form -->
                <div x-show="activeTab === 'unitMotor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <form action="{{ route('admin.jenisMotor.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="space-y-6">
                            <label for="id_stok" class="block text-lg font-medium text-gray-700">Merk</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" x-data="{ selectedMerk: '' }">
                                @foreach($stoks as $stok)
                                <div class="relative">
                                    <input type="radio" id="merk_{{ $stok->id }}" name="id_stok" value="{{ $stok->id }}" class="sr-only" x-model="selectedMerk">
                                    <label for="merk_{{ $stok->id }}" class="block p-6 border-2 rounded-xl cursor-pointer transition-all duration-300 hover:border-indigo-300" :class="{ 'border-indigo-500 ring-2 ring-indigo-500': selectedMerk == '{{ $stok->id }}', 'border-gray-300': selectedMerk != '{{ $stok->id }}' }">
                                        <div class="flex flex-col items-center">
                                            <img src="{{ $stok->foto ? (filter_var($stok->foto, FILTER_VALIDATE_URL) ? $stok->foto : asset('storage/' . $stok->foto)) : 'https://via.placeholder.com/600x400' }}" alt="{{ $stok->merk }}" class="w-full h-32 object-cover rounded-md mb-3" loading="lazy">
                                            <span class="text-lg font-medium">{{ $stok->merk }}</span>
                                            <p class="text-sm font-bold text-indigo-600 mt-1">Rp {{ number_format($stok->harga_perHari, 0, ',', '.') }}/hari</p>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Display Errors -->
                        @if ($errors->has('id_stok'))
                            <div class="text-red-500 text-sm mb-4">
                                <strong>Terjadi kesalahan:</strong> {{ $errors->first('id_stok') }}
                            </div>
                        @endif


                        <div class="space-y-4">
                            <label for="nopol" class="block text-lg font-medium text-gray-700">Nopol</label>
                            <input type="text" name="nopol" id="nopol" value="{{ old('nopol') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                        </div>
                        <!-- Display Errors -->
                        @if ($errors->has('nopol'))
                            <div class="text-red-500 text-sm mb-4">
                                {{ $errors->first('nopol') }}
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-full text-lg font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                Tambah Unit Motor
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Stok Motor Form -->
                <div x-show="activeTab === 'stokMotor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <form action="{{ route('admin.stok.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="space-y-4">
                            <label for="merk" class="block text-lg font-medium text-gray-700">Merk</label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                        </div>

                                                <!-- Display Errors -->
                                                @if ($errors->has('merk'))
                                                    <div class="text-red-500 text-sm mb-4">
                                                        {{ $errors->first('merk') }}
                                                    </div>
                                                @endif


                        <div class="space-y-4">
                            <label for="harga_perHari" class="block text-lg font-medium text-gray-700">Harga per Hari</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-lg">Rp</span>
                                </div>
                                <input type="number" name="harga_perHari" id="harga_perHari" value="{{ old('harga_perHari') }}" class="pl-12 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                            </div>
                        </div>
                        <!-- Display Errors -->
                        @if ($errors->has('harga_perHari'))
                            <div class="text-red-500 text-sm mb-4">
                                {{ $errors->first('harga_perHari') }}
                            </div>
                        @endif

                        <div class="space-y-4">
                            <label for="judul" class="block text-lg font-medium text-gray-700">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                        </div>

                                                <!-- Display Errors -->
                                                @if ($errors->has('judul'))
                                                    <div class="text-red-500 text-sm mb-4">
                                                        {{ $errors->first('judul') }}
                                                    </div>
                                                @endif


                        <div class="space-y-4">
                            <label for="deskripsi1" class="block text-lg font-medium text-gray-700">Deskripsi 1</label>
                            <input type="text" name="deskripsi1" id="deskripsi1" value="{{ old('deskripsi1') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                        </div>

                        <!-- Display Errors -->
                        @if ($errors->has('deskripsi1'))
                            <div class="text-red-500 text-sm mb-4">
                                {{ $errors->first('deskripsi1') }}
                            </div>
                        @endif

                        <div class="space-y-4">
                            <label for="deskripsi2" class="block text-lg font-medium text-gray-700">Deskripsi 2</label>
                            <input type="text" name="deskripsi2" id="deskripsi2" value="{{ old('deskripsi2') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                        </div>

                        <!-- Display Errors -->
                        @if ($errors->has('deskripsi2'))
                            <div class="text-red-500 text-sm mb-4">
                                {{ $errors->first('deskripsi2') }}
                            </div>
                        @endif

                        <div class="space-y-4">
                            <label for="foto" class="block text-lg font-medium text-gray-700">Foto</label>
                            <input type="file" name="foto" id="foto" class="block w-full text-gray-800 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300">
                        </div>
                        <!-- Display Errors -->
                        @if ($errors->has('foto'))
                            <div class="text-red-500 text-sm mb-4">
                                {{ $errors->first('foto') }}
                            </div>
                        @endif


                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-full text-lg font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                Tambah Stok Motor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
