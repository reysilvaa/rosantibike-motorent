@extends('layouts.admin')
@section('title', isset($stok) ? 'Edit Unit Motor' : 'Tambahkan Unit Motor')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 to-indigo-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 sm:p-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white">
                {{ isset($stok) ? 'Edit Unit Motor' : 'Tambahkan Unit Motor' }}
            </h1>
            <p class="mt-2 text-blue-100">
                {{ isset($stok) ? 'Update details for ' . $stok->merk : 'Tambahkan Unit Baru ke Dalam Penyimpanan' }}
            </p>
        </div>

        <form action="{{ isset($stok) ? route('admin.stok.update', $stok->id) : route('admin.stok.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6 sm:p-10 space-y-8">
            @csrf
            @if(isset($stok))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
                        <input type="text" name="merk" id="merk"
                               value="{{ old('merk', $stok->merk ?? '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300" required>
                        @error('merk')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="harga_perHari" class="block text-sm font-medium text-gray-700">Harga per Hari</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga_perHari" id="harga_perHari"
                                   value="{{ old('harga_perHari', $stok->harga_perHari ?? '') }}"
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300" required>
                        </div>
                        @error('harga_perHari')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="foto_url" class="block text-sm font-medium text-gray-700">Foto URL</label>
                        <input type="text" name="foto_url" id="foto_url"
                               value="{{ old('foto_url', $stok->foto_url ?? '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300"
                               placeholder="https://example.com/image.jpg">
                        <p class="mt-2 text-sm text-gray-500">Masukkan URL atau Upload foto dibawah.</p>
                        @error('foto_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700">Upload Foto</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition duration-300">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload sebuah Foto</span>
                                        <input id="foto" name="foto" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB</p>
                            </div>
                        </div>
                        @error('foto')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900">Pratinjau</h3>
                <div class="mt-4 bg-gray-100 p-4 rounded-lg">
                    <div id="imagePreview" class="aspect-w-16 aspect-h-9">
                        @if(isset($stok) && ($stok->foto_url || $stok->foto))
                            <img src="{{ $stok->foto_url ?: asset('storage/' . $stok->foto) }}"
                                 alt="{{ $stok->merk }}"
                                 class="w-full h-full object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 rounded-lg">
                                <p class="text-gray-500">Tidak Ada Foto</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('admin.stok.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke list
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ isset($stok) ? 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12' : 'M12 6v6m0 0v6m0-6h6m-6 0H6' }}"></path>
                    </svg>
                    {{ isset($stok) ? 'Update' : 'Tambah' }} Unit Motor
                </button>
            </div>
        </form>
    </div>
</div>
@include('admin.unit.script')
@endsection
