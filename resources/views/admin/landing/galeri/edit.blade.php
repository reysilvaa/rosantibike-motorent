@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Edit Galeri</h1>

    <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" class="bg-white p-6 border border-gray-200 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="id_user" class="block text-gray-700">User ID</label>
            <input type="number" name="id_user" id="id_user" class="form-input mt-1 block w-full" value="{{ $galeri->id_user }}" required>
        </div>

        <div class="mb-4">
            <label for="judul" class="block text-gray-700">Judul</label>
            <input type="text" name="judul" id="judul" class="form-input mt-1 block w-full" value="{{ $galeri->judul }}" maxlength="100" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
            <input type="text" name="deskripsi" id="deskripsi" class="form-input mt-1 block w-full" value="{{ $galeri->deskripsi }}" maxlength="100" required>
        </div>

        <div class="mb-4">
            <label for="full_description" class="block text-gray-700">Full Description</label>
            <textarea name="full_description" id="full_description" class="form-textarea mt-1 block w-full" rows="4" required>{{ $galeri->full_description }}</textarea>
        </div>

        <div class="mb-4">
            <label for="foto" class="block text-gray-700">Foto URL</label>
            <input type="text" name="foto" id="foto" class="form-input mt-1 block w-full" value="{{ $galeri->foto }}" required>
        </div>

        <div class="mb-4">
            <label for="kategori" class="block text-gray-700">Kategori</label>
            <select name="kategori" id="kategori" class="form-select mt-1 block w-full" required>
                <option value="alam" {{ $galeri->kategori === 'alam' ? 'selected' : '' }}>Alam</option>
                <option value="sejarah" {{ $galeri->kategori === 'sejarah' ? 'selected' : '' }}>Sejarah</option>
                <option value="kuliner" {{ $galeri->kategori === 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                <option value="budaya" {{ $galeri->kategori === 'budaya' ? 'selected' : '' }}>Budaya</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="link_maps" class="block text-gray-700">Link Maps</label>
            <input type="text" name="link_maps" id="link_maps" class="form-input mt-1 block w-full" value="{{ $galeri->link_maps }}" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Galeri</button>
        </div>
    </form>
</div>
@endsection
