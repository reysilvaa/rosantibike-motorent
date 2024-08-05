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
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">Terdapat kesalahan pada inputan Anda.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.jenisMotor.update', $jenisMotor->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <label for="id_stok" class="block text-lg font-medium text-gray-700">Merk</label>
                            <div class="grid grid-cols-3 gap-6" x-data="{ selectedMerk: '{{ $jenisMotor->id_stok }}' }">
                                @foreach($stoks as $stok)
                                <div class="relative">
                                    <input type="radio" id="merk_{{ $stok->id }}" name="id_stok" value="{{ $stok->id }}" class="sr-only" x-model="selectedMerk">
                                    <label for="merk_{{ $stok->id }}" class="block p-6 border-2 rounded-xl cursor-pointer transition-all duration-300 hover:border-indigo-300"
                                        :class="{ 'border-indigo-500 ring-2 ring-indigo-500': selectedMerk == '{{ $stok->id }}', 'border-gray-300': selectedMerk != '{{ $stok->id }}' }">
                                        <div class="flex flex-col items-center">
                                            <img src="{{ $stok->foto ? (filter_var($stok->foto, FILTER_VALIDATE_URL) ? $stok->foto : asset('storage/' . $stok->foto)) : 'https://via.placeholder.com/600x400' }}" alt="{{ $stok->merk }}" class="w-full h-32 object-cover rounded-md mb-3" loading="lazy">
                                            <span class="text-lg font-medium">{{ $stok->merk }}</span>
                                            <p class="text-sm font-bold text-indigo-600 mt-1">Rp {{ number_format($stok->harga_perHari, 0, ',', '.') }}/hari</p>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('id_stok')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="nopol" class="block text-lg font-medium text-gray-700">Nopol</label>
                            <input type="text" name="nopol" id="nopol" value="{{ old('nopol', $jenisMotor->nopol) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('nopol') border-red-500 @enderror">
                            @error('nopol')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.stok.update', $stok->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <label for="merk" class="block text-lg font-medium text-gray-700">Merk</label>
                            <input type="text" name="merk" id="merk" value="{{ old('merk', $stok->merk) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('merk') border-red-500 @enderror">
                            @error('merk')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="harga_perHari" class="block text-lg font-medium text-gray-700">Harga per Hari</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-lg">Rp</span>
                                </div>
                                <input type="number" name="harga_perHari" id="harga_perHari" value="{{ old('harga_perHari', $stok->harga_perHari) }}"
                                    class="pl-12 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                    @error('harga_perHari') border-red-500 @enderror">
                                @error('harga_perHari')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label for="judul" class="block text-lg font-medium text-gray-700">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $stok->judul) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('judul') border-red-500 @enderror">
                            @error('judul')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="deskripsi1" class="block text-lg font-medium text-gray-700">Deskripsi 1</label>
                            <input type="text" name="deskripsi1" id="deskripsi1" value="{{ old('deskripsi1', $stok->deskripsi1) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('deskripsi1') border-red-500 @enderror">
                            @error('deskripsi1')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="deskripsi2" class="block text-lg font-medium text-gray-700">Deskripsi 2</label>
                            <input type="text" name="deskripsi2" id="deskripsi2" value="{{ old('deskripsi2', $stok->deskripsi2) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('deskripsi2') border-red-500 @enderror">
                            @error('deskripsi2')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="deskripsi3" class="block text-lg font-medium text-gray-700">Deskripsi 3</label>
                            <input type="text" name="deskripsi3" id="deskripsi3" value="{{ old('deskripsi3', $stok->deskripsi3) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('deskripsi3') border-red-500 @enderror">
                            @error('deskripsi3')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="kategori" class="block text-lg font-medium text-gray-700">Kategori</label>
                            <select name="kategori" id="kategori" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('kategori') border-red-500 @enderror">
                                <option value="" disabled>Select Kategori</option>
                                <option value="manual" {{ old('kategori', $stok->kategori) == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="matic" {{ old('kategori', $stok->kategori) == 'matic' ? 'selected' : '' }}>Matic</option>
                            </select>
                            @error('kategori')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="foto" class="block text-lg font-medium text-gray-700">Foto</label>
                            <input type="file" name="foto" id="foto"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 text-lg
                                @error('foto') border-red-500 @enderror">
                            @error('foto')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
@endsection
