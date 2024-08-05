@extends('layouts.admin')
@section('title', 'Manajemen Unit Motor')
@section('content')
<div x-data="{ activeTab: 'unitMotor' }" class="min-h-screen bg-gradient-to-br from-blue-100 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform hover:scale-101 transition-all duration-300">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-10">
                <h1 class="text-5xl font-extrabold text-white text-center tracking-wide">
                    Manajemen Unit Motor
                </h1>
            </div>

            <div class="p-10">
                <!-- Tab Navigation -->
                <div class="mb-10 flex justify-center space-x-8">
                    <button @click="activeTab = 'unitMotor'" :class="{ 'bg-indigo-600 text-white shadow-lg': activeTab === 'unitMotor', 'bg-gray-200 text-gray-700': activeTab !== 'unitMotor' }" class="px-8 py-4 rounded-full text-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Unit Motor
                    </button>
                    <button @click="activeTab = 'stokMotor'" :class="{ 'bg-indigo-600 text-white shadow-lg': activeTab === 'stokMotor', 'bg-gray-200 text-gray-700': activeTab !== 'stokMotor' }" class="px-8 py-4 rounded-full text-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Stok Motor
                    </button>
                </div>

                <!-- Unit Motor Form -->
                <div x-show="activeTab === 'unitMotor'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100">

                    @if ($errors->any())
                    <div class="bg-red-100 border-2 border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-inner mb-8" role="alert">
                        <strong class="font-bold text-lg">Whoops!</strong>
                        <p class="text-base mt-2">Terdapat kesalahan pada inputan Anda.</p>
                        <ul class="mt-3 list-disc list-inside pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.jenisMotor.update', $jenisMotor->id) }}" method="POST" class="space-y-10">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <label for="id_stok" class="block text-2xl font-bold text-gray-800 mb-4">Pilih Merk Motor</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($stoks as $stok)
                                <div class="relative transform hover:scale-105 transition-all duration-300">
                                    <input type="radio" id="merk_{{ $stok->id }}" name="id_stok" value="{{ $stok->id }}"
                                            class="sr-only" x-model="selectedMerk">
                                    <label for="merk_{{ $stok->id }}"
                                            class="block p-6 border-3 rounded-2xl cursor-pointer transition-all duration-300 hover:border-indigo-400 hover:shadow-xl"
                                            :class="{ 'border-indigo-500 ring-4 ring-indigo-300': selectedMerk == '{{ $stok->id }}', 'border-gray-300': selectedMerk != '{{ $stok->id }}' }">
                                        <div class="flex flex-col items-center">
                                            <img src="{{ $stok->foto ? (filter_var($stok->foto, FILTER_VALIDATE_URL) ? $stok->foto : asset('storage/' . $stok->foto)) : 'https://via.placeholder.com/600x400' }}"
                                                    alt="{{ $stok->merk }}" class="w-full h-48 object-cover rounded-lg mb-4 shadow-md"
                                                    loading="lazy">
                                            <span class="text-xl font-semibold text-gray-900">{{ $stok->merk }}</span>
                                            <p class="text-lg font-bold text-indigo-600 mt-2">Rp {{ number_format($stok->harga_perHari, 0, ',', '.') }}/hari</p>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('id_stok')
                            <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-6">
                        <label for="nopol" class="block text-2xl font-bold text-gray-800">Nomor Polisi</label>
                        <input type="text" name="nopol" id="nopol"
                                value="{{ old('nopol', $jenisMotor->nopol) }}"
                                class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                @error('nopol') border-red-500 @enderror">
                        @error('nopol')
                            <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-8 py-4 bg-indigo-600 border border-transparent rounded-xl text-xl font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105">
                            Update Unit Motor
                        </button>
                    </div>
                    </form>
                </div>

                <!-- Stok Motor Form -->
                <div x-show="activeTab === 'stokMotor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    @if ($errors->any())
                        <div class="bg-red-100 border-2 border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-inner mb-8" role="alert">
                            <strong class="font-bold text-lg">Whoops!</strong>
                            <p class="text-base mt-2">Terdapat beberapa masalah dengan input Anda.</p>
                            <ul class="mt-3 list-disc list-inside pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.stok.update', $stok->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <label for="merk" class="block text-2xl font-bold text-gray-800">Merk</label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk', $stok->merk) }}"
                                class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                @error('merk') border-red-500 @enderror">
                            @error('merk')
                                <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-6">
                            <label for="harga_perHari" class="block text-2xl font-bold text-gray-800">Harga per Hari</label>
                            <div class="mt-1 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-xl">Rp</span>
                                </div>
                                <input type="number" name="harga_perHari" id="harga_perHari" value="{{ old('harga_perHari', $stok->harga_perHari) }}"
                                    class="pl-16 block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                    @error('harga_perHari') border-red-500 @enderror">
                                @error('harga_perHari')
                                    <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-6">
                            <label for="judul" class="block text-2xl font-bold text-gray-800">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $stok->judul) }}"
                                class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                @error('judul') border-red-500 @enderror">
                            @error('judul')
                                <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-6">
                            <label for="deskripsi1" class="block text-2xl font-bold text-gray-800">Deskripsi 1</label>
                            <input type="text" name="deskripsi1" id="deskripsi1" value="{{ old('deskripsi1', $stok->deskripsi1) }}"
                                class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                @error('deskripsi1') border-red-500 @enderror">
                            @error('deskripsi1')
                                <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-6">
                            <label for="deskripsi2" class="block text-2xl font-bold text-gray-800">Deskripsi 2</label>
                            <input type="text" name="deskripsi2" id="deskripsi2" value="{{ old('deskripsi2', $stok->deskripsi2) }}"
                                class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                @error('deskripsi2') border-red-500 @enderror">
                            @error('deskripsi2')
                                <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-6">
                            <label for="deskripsi3" class="block text-2xl font-bold text-gray-800">Deskripsi 3</label>
                            <input type="text" name="deskripsi3" id="deskripsi3" value="{{ old('deskripsi3', $stok->deskripsi3) }}"
                                class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                @error('deskripsi3') border-red-500 @enderror">
                            @error('deskripsi3')
                                <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-6">
                            <label for="kategori" class="block text-2xl font-bold text-gray-800">Kategori</label>
                            <select name="kategori" id="kategori" class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                                @error('kategori') border-red-500 @enderror">
                                <option value="" disabled>Pilih Kategori</option>
                                <option value="manual" {{ old('kategori', $stok->kategori) == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="matic" {{ old('kategori', $stok->kategori) == 'matic' ? 'selected' : '' }}>Matic</option>
                            </select>
                            @error('kategori')
                                <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-6">
                            <label for="foto" class="block text-2xl font-bold text-gray-800">Foto</label>
                            <input type="file" name="foto" id="foto"
                                class="block w-full rounded-xl border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-xl py-4 px-4
                            @error('foto') border-red-500 @enderror">
                            @error('foto')
                                <p class="text-red-500 text-base mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-10 py-5 bg-indigo-600 border border-transparent rounded-xl text-2xl font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Update Stok Motor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add this script to enhance the file input field
    document.getElementById('foto').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var label = document.querySelector('label[for="foto"]');
        label.textContent = 'Foto: ' + fileName;
    });
</script>

@endsection
