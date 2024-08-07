@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6 max-w-4xl" x-data="{ category: '{{ $galeri->kategori }}' }">
    <h1 class="text-4xl font-bold mb-8 text-gray-800 text-center">Edit Galeri</h1>
    <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" class="bg-white p-8 border border-gray-200 rounded-xl shadow-2xl">
        @csrf
        @method('PUT')
        <div class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="judul" class="text-gray-700 font-semibold">Judul</label>
                <input type="text" name="judul" id="judul" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" value="{{ $galeri->judul }}" maxlength="100" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="deskripsi" class="text-gray-700 font-semibold">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" value="{{ $galeri->deskripsi }}" maxlength="100" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <label for="full_description" class="text-gray-700 font-semibold pt-2">Full Description</label>
                <textarea name="full_description" id="full_description" class="col-span-2 form-textarea rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" rows="4" required>{{ $galeri->full_description }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="foto" class="text-gray-700 font-semibold">Foto URL</label>
                <input type="text" name="foto" id="foto" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" value="{{ $galeri->foto }}" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <label class="text-gray-700 font-semibold pt-2">Kategori</label>
                <div class="col-span-2 grid grid-cols-2 gap-4">
                    <template x-for="cat in ['alam', 'sejarah', 'kuliner', 'budaya']" :key="cat">
                        <button type="button"
                                @click="category = cat"
                                :class="{
                                    'bg-indigo-600 text-white border border-indigo-600': category === cat,
                                    'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200': category !== cat,
                                    'focus:outline-none focus:ring-4 focus:ring-indigo-300': true
                                }"
                                class="py-3 px-4 rounded-lg transition duration-150 ease-in-out focus:ring-opacity-50 text-sm font-medium uppercase">
                            <span x-text="cat"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="kategori" x-model="category">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <label for="link_maps" class="text-gray-700 font-semibold">Link Maps</label>
                <input type="text" name="link_maps" id="link_maps" class="col-span-2 form-input rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" value="{{ $galeri->link_maps }}" required>
            </div>


            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.galeri.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kembali
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Ubah
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
