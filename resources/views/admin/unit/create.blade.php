@extends('layouts.admin')
@section('title', 'Tambah Unit Motor Baru')
@section('content')
<div x-data="{ activeTab: 'unitMotor' }" class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="bg-gray-800 p-6">
                <h1 class="text-3xl font-semibold text-white">
                    Tambah Unit Motor Baru
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
                    <form action="{{ route('admin.jenisMotor.store') }}" method="POST" class="space-y-6">
                        @csrf

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
                                    value="{{ old('nopol') }}"
                                    class="mt-1 block w-full border-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="flex justify-between items-center">
                            <!-- Back to List Button -->
                            <x-back-to-list-button route="{{ route('admin.jenisMotor.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-gray-500" />

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="inline-flex items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tambah Unit Motor
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Stok Motor Form -->
                <div x-show="activeTab === 'stokMotor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <form action="{{ route('admin.stok.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="space-y-4">
                            <label for="merk" class="block text-lg font-medium text-gray-700">Merk</label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk') }}"
                            class="block w-full rounded-lg border-2 border-gray-300 shadow-md focus:border-indigo-600 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg py-3 px-4"
                            required>
                        </div>

                        <div x-data="{ selectedKategori: '{{ old('kategori', 'matic') }}' }" class="space-y-4">
                            <label class="block text-lg font-medium text-gray-700">Jenis Motor</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <div class="relative">
                                    <input type="radio" id="kategori_matic" name="kategori" value="matic" x-model="selectedKategori" class="sr-only">
                                    <label for="kategori_matic" class="block p-6 border-2 rounded-xl cursor-pointer transition-all duration-300 hover:border-indigo-300"
                                        :class="{ 'border-indigo-500 ring-2 ring-indigo-500': selectedKategori === 'matic', 'border-gray-300': selectedKategori !== 'matic' }">
                                        <div class="flex flex-col items-center">
                                            <div class="text-lg font-semibold text-gray-800">Matic</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="kategori_manual" name="kategori" value="manual" x-model="selectedKategori" class="sr-only">
                                    <label for="kategori_manual" class="block p-6 border-2 rounded-xl cursor-pointer transition-all duration-300 hover:border-indigo-300"
                                        :class="{ 'border-indigo-500 ring-2 ring-indigo-500': selectedKategori === 'manual', 'border-gray-300': selectedKategori !== 'manual' }">
                                        <div class="flex flex-col items-center">
                                            <div class="text-lg font-semibold text-gray-800">Manual</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label for="harga_perHari" class="block text-lg font-medium text-gray-700">Harga per Hari</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-lg">Rp</span>
                                </div>
                                <input type="number" name="harga_perHari" id="harga_perHari" value="{{ old('harga_perHari') }}"
                                class="pl-12 block w-full rounded-lg border-2 border-gray-300 shadow-md focus:border-indigo-600 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg py-3 px-4"
                                required>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label for="judul" class="block text-lg font-medium text-gray-700">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                            class="block w-full rounded-lg border-2 border-gray-300 shadow-md focus:border-indigo-600 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg py-3 px-4"
                            required>
                        </div>

                        <div class="space-y-4">
                            <label for="deskripsi1" class="block text-lg font-medium text-gray-700">Deskripsi 1</label>
                            <textarea name="deskripsi1" id="deskripsi1" rows="4"
                            class="block w-full rounded-lg border-2 border-gray-300 shadow-md focus:border-indigo-600 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg py-3 px-4"
                            required>{{ old('deskripsi1') }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <label for="deskripsi2" class="block text-lg font-medium text-gray-700">Deskripsi 2</label>
                            <textarea name="deskripsi2" id="deskripsi2" rows="4"
                            class="block w-full rounded-lg border-2 border-gray-300 shadow-md focus:border-indigo-600 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg py-3 px-4"
                            required>{{ old('deskripsi2') }}</textarea>
                        </div>

                        <div x-data="{
                            imagePreview: '',
                            imageSource: '{{ old('image_source', 'upload') }}',
                            fileName: '',
                            isDragging: false,
                            handleFileChange(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    this.fileName = file.name;
                                    this.imagePreview = URL.createObjectURL(file);
                                }
                            },
                            handleFileDrop(event) {
                                const file = event.dataTransfer.files[0];
                                if (file) {
                                    this.fileName = file.name;
                                    this.imagePreview = URL.createObjectURL(file);
                                    this.$refs.fileInput.files = event.dataTransfer.files;
                                }
                            }
                        }" class="space-y-8 bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-3xl font-bold text-gray-800 mb-6">Foto Motor</h2>

                            <div class="flex space-x-6 mb-8">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="image_source" value="upload" x-model="imageSource"
                                        class="form-radio h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="text-xl text-gray-700 group-hover:text-indigo-600 transition duration-200">Upload Gambar</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="image_source" value="url" x-model="imageSource"
                                        class="form-radio h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="text-xl text-gray-700 group-hover:text-indigo-600 transition duration-200">Gunakan URL</span>
                                </label>
                            </div>

                            <div x-show="imageSource === 'upload'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="isDragging = false; handleFileDrop($event)"
                                @click="$refs.fileInput.click()"
                                class="space-y-4 cursor-pointer">
                                <div class="w-full h-64 border-2 border-dashed rounded-lg flex items-center justify-center bg-gray-50 transition duration-300 ease-in-out"
                                    :class="{ 'border-indigo-600 bg-indigo-50': isDragging, 'border-gray-300 hover:bg-gray-100': !isDragging }">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-sm text-gray-600">
                                            <span class="font-medium text-indigo-600 hover:text-indigo-500">
                                                Klik untuk upload
                                            </span>
                                            atau drag and drop
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                <input x-ref="fileInput" type="file" name="foto" id="foto" accept="image/*" class="hidden" @change="handleFileChange($event)">
                                <p x-show="fileName" x-text="fileName" class="mt-2 text-sm text-gray-500"></p>
                            </div>

                            <div x-show="imageSource === 'url'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="space-y-4">
                                <label for="foto_url" class="block text-lg font-medium text-gray-700">URL Gambar:</label>
                                <div class="relative">
                                    <input type="url" name="foto_url" id="foto_url" placeholder="https://example.com/image.jpg"
                                        @input="imagePreview = $event.target.value"
                                        class="block w-full pr-10 text-gray-700 py-3 px-4 border-2 border-gray-300 rounded-lg shadow-sm focus:border-indigo-600 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 placeholder-gray-400">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 005.656 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div x-show="imagePreview"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="mt-8">
                                <h3 class="text-lg font-medium text-gray-700 mb-2">Preview:</h3>
                                <img :src="imagePreview" alt="Preview" class="max-w-full h-auto max-h-80 rounded-lg shadow-lg border-2 border-gray-300 object-cover">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-full text-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
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
