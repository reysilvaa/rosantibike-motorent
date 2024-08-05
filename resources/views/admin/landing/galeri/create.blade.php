@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Create Galeri</h1>

    <form action="{{ route('admin.galeri.store') }}" method="POST" class="bg-white p-6 border border-gray-200 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="judul" class="block text-gray-700">Judul</label>
            <input type="text" name="judul" id="judul" class="form-input mt-1 block w-full" maxlength="100" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
            <input type="text" name="deskripsi" id="deskripsi" class="form-input mt-1 block w-full" maxlength="100" required>
        </div>

        <div class="mb-4">
            <label for="full_description" class="block text-gray-700">Full Description</label>
            <textarea name="full_description" id="full_description" class="form-textarea mt-1 block w-full" rows="4" required></textarea>
        </div>

        <div class="mb-4">
            <label for="foto" class="block text-gray-700">Foto URL</label>
            <input type="text" name="foto" id="foto" class="form-input mt-1 block w-full" required>
        </div>

        <div class="mb-4">
            <label for="kategori" class="block text-gray-700">Kategori</label>
            <select name="kategori" id="kategori" class="form-select mt-1 block w-full" required>
                <option value="alam">Alam</option>
                <option value="sejarah">Sejarah</option>
                <option value="kuliner">Kuliner</option>
                <option value="budaya">Budaya</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="link_maps" class="block text-gray-700">Link Maps</label>
            <input type="text" name="link_maps" id="link_maps" class="form-input mt-1 block w-full" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Galeri</button>
        </div>
    </form>
</div>
@endsection
