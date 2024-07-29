@extends('layouts.admin')
@section('title', 'Manajemen Unit Motor')
@section('content')
<div x-data="{ activeTab: 'unitMotor' }" class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
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
                    <form action="{{ route('admin.jenisMotor.update', $jenisMotor->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <label for="id_stok" class="block text-lg font-medium text-gray-700">Merk</label>
                            <div class="grid grid-cols-3 gap-6" x-data="{ selectedMerk: '{{ $jenisMotor->id_stok }}' }">
                                @foreach($stoks as $stok)
                                <div class="relative">
                                    <input type="radio" id="merk_{{ $stok->id }}" name="id_stok" value="{{ $stok->id }}" class="sr-only" x-model="selectedMerk">
                                    <label for="merk_{{ $stok->id }}" class="block p-6 border-2 rounded-xl cursor-pointer transition-all duration-300" :class="{ 'border-indigo-500 ring-2 ring-indigo-500': selectedMerk == {{ $stok->id }}, 'border-gray-300 hover:border-indigo-300': selectedMerk != {{ $stok->id }} }">
                                        <span class="text-lg font-medium">{{ $stok->merk }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label for="nopol" class="block text-lg font-medium text-gray-700">Nopol</label>
                            <input type="text" name="nopol" id="nopol" value="{{ old('nopol', $jenisMotor->nopol) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-full text-lg font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                Update Unit Motor
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Stok Motor Form -->
                <div x-show="activeTab === 'stokMotor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <form action="{{ route('admin.stok.update', $stok->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <label for="merk" class="block text-lg font-medium text-gray-700">Merk</label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk', $stok->merk) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                        </div>

                        <div class="space-y-4">
                            <label for="harga_perHari" class="block text-lg font-medium text-gray-700">Harga per Hari</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-lg">Rp</span>
                                </div>
                                <input type="number" name="harga_perHari" id="harga_perHari" value="{{ old('harga_perHari', $stok->harga_perHari) }}" class="pl-12 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" required>
                            </div>
                        </div>

                        <div x-data="{ photoPreview: '{{ $stok->foto_url ? $stok->foto_url : ($stok->foto ? asset('storage/' . $stok->foto) : '') }}', photoUrl: '' }" class="space-y-6">
                            <label class="block text-lg font-medium text-gray-700">Foto Motor</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-8m36-8H36m4 0v-4a4 4 0 00-4-4h-4l-6-6H14a4 4 0 00-4 4v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="foto" name="foto" type="file" class="sr-only" @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="foto_url" class="block text-lg font-medium text-gray-700">Atau masukkan URL foto</label>
                                <input type="text" name="foto_url" id="foto_url" x-model="photoUrl" @input="photoPreview = photoUrl" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg" placeholder="https://example.com/image.jpg">
                            </div>
                            <div x-show="photoPreview" class="mt-4">
                                <img :src="photoPreview" alt="Preview" class="object-cover rounded-lg h-64 w-full">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-full text-lg font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                Update Stok Motor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection
