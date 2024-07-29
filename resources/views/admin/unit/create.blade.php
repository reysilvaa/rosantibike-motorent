@extends('layouts.admin')
@section('title', isset($jenisMotor) ? 'Edit Unit Motor' : 'Tambahkan Unit Motor')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 to-indigo-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 sm:p-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white">
                {{ isset($jenisMotor) ? 'Edit Unit Motor' : 'Tambahkan Unit Motor' }}
            </h1>
            <p class="mt-2 text-blue-100">
                {{ isset($jenisMotor) ? 'Update details for ' . $jenisMotor->merk : 'Tambahkan Unit Baru ke Dalam Penyimpanan' }}
            </p>
        </div>

        <form action="{{ isset($jenisMotor) ? route('admin.jenisMotor.update', $jenisMotor->id) : route('admin.jenisMotor.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6 sm:p-10 space-y-8">
            @csrf
            @if(isset($jenisMotor))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="id_stok" class="block text-sm font-medium text-gray-700">Merk</label>
                    <select name="id_stok" id="id_stok"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300" required>
                        <option value="" disabled selected>Pilih Merk</option>
                        @foreach($stoks as $stok)
                            <option value="{{ $stok->id }}" {{ old('merk', $jenisMotor->stok->id ?? '') == $stok->id ? 'selected' : '' }}>
                                {{ $stok->merk }}
                            </option>
                        @endforeach
                    </select>
                    @error('merk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="nopol" class="block text-sm font-medium text-gray-700">Nopol</label>
                    <input type="text" name="nopol" id="nopol"
                           value="{{ old('nopol', $jenisMotor->nopol ?? '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300" required>
                    @error('nopol')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('admin.jenisMotor.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke list
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ isset($jenisMotor) ? 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12' : 'M12 6v6m0 0v6m0-6h6m-6 0H6' }}"></path>
                    </svg>
                    {{ isset($jenisMotor) ? 'Update' : 'Tambah' }} Unit Motor
                </button>
            </div>
        </form>
    </div>
</div>
@include('admin.unit.script')
@endsection
