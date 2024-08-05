@extends('layouts.admin')
@section('title', 'Manajemen Unit Motor')
@section('content')
<div x-data="{ activeTab: 'unitMotor' }" class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="bg-gray-800 p-6">
                <h1 class="text-3xl font-semibold text-white">
                    Manajemen Unit Motor
                </h1>
            </div>

            <div class="p-6">
                <!-- Tab Navigation -->
                <div class="mb-6 border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="activeTab = 'unitMotor'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'unitMotor', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'unitMotor' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Unit Motor
                        </button>
                        <button @click="activeTab = 'stokMotor'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'stokMotor', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'stokMotor' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Stok Motor
                        </button>
                    </nav>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6" role="alert">
                    <p class="font-medium text-red-800">Terdapat kesalahan pada inputan Anda:</p>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Unit Motor Form -->
                <div x-show="activeTab === 'unitMotor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <form action="{{ route('admin.jenisMotor.update', $jenisMotor->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="id_stok" class="block text-sm font-medium text-gray-700 mb-2">Pilih Merk Motor</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($stoks as $stok)
                                    <div class="relative">
                                        <input type="radio" id="merk_{{ $stok->id }}" name="id_stok" value="{{ $stok->id }}"
                                                class="sr-only peer" x-model="selectedMerk">
                                        <label for="merk_{{ $stok->id }}"
                                                class="flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:border-transparent">
                                            <img src="{{ $stok->foto ? (filter_var($stok->foto, FILTER_VALIDATE_URL) ? $stok->foto : asset('storage/' . $stok->foto)) : 'https://via.placeholder.com/150' }}"
                                                    alt="{{ $stok->merk }}" class="w-full h-32 object-cover rounded-md mb-2"
                                                    loading="lazy">
                                            <span class="text-sm font-medium text-gray-900">{{ $stok->merk }}</span>
                                            <p class="text-xs font-semibold text-indigo-600 mt-1">Rp {{ number_format($stok->harga_perHari, 0, ',', '.') }}/hari</p>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label for="nopol" class="block text-sm font-medium text-gray-700">Nomor Polisi</label>
                            <input type="text" name="nopol" id="nopol"
                                    value="{{ old('nopol', $jenisMotor->nopol) }}"
                                    class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex justify-between items-center">
                            <!-- Back to List Button -->
                            <x-back-to-list-button route="{{ route('admin.jenisMotor.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-gray-500" />

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="inline-flex items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Unit Motor
                            </button>
                        </div>

                    </form>
                </div>

                <!-- Stok Motor Form -->
                <div x-show="activeTab === 'stokMotor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <form action="{{ route('admin.stok.update', $stok->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk', $stok->merk) }}"
                                class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="harga_perHari" class="block text-sm font-medium text-gray-700">Harga per Hari</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga_perHari" id="harga_perHari" value="{{ old('harga_perHari', $stok->harga_perHari) }}"
                                    class="pl-10 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $stok->judul) }}"
                                class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="deskripsi1" class="block text-sm font-medium text-gray-700">Deskripsi 1</label>
                            <input type="text" name="deskripsi1" id="deskripsi1" value="{{ old('deskripsi1', $stok->deskripsi1) }}"
                                class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="deskripsi2" class="block text-sm font-medium text-gray-700">Deskripsi 2</label>
                            <input type="text" name="deskripsi2" id="deskripsi2" value="{{ old('deskripsi2', $stok->deskripsi2) }}"
                                class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="deskripsi3" class="block text-sm font-medium text-gray-700">Deskripsi 3</label>
                            <input type="text" name="deskripsi3" id="deskripsi3" value="{{ old('deskripsi3', $stok->deskripsi3) }}"
                                class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori" id="kategori" class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="" disabled>Pilih Kategori</option>
                                <option value="matic" {{ old('kategori', $stok->kategori) === 'matic' ? 'selected' : '' }}>Matic</option>
                                <option value="manual" {{ old('kategori', $stok->kategori) === 'manual' ? 'selected' : '' }}>Manual</option>
                                <!-- Add other options as needed -->
                            </select>
                        </div>

                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                            <input type="file" name="foto" id="foto"
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100">
                        </div>

                        <div class="flex justify-between items-center">
                            <x-back-to-list-button route="{{ route('admin.jenisMotor.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-gray-500" />
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 mb-0 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Stok Motor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
