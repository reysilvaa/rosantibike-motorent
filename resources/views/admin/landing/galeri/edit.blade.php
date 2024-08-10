@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 text-center">Edit Galeri</h1>

    <form x-data="{
        judul: '{{ old('judul', $galeri->judul) }}',
        deskripsi: '{{ old('deskripsi', $galeri->deskripsi) }}',
        full_description: '{{ old('full_description', $galeri->full_description) }}',
        foto: '{{ old('foto', $galeri->foto) }}',
        category: '{{ old('kategori', $galeri->kategori) }}',
        link_maps: '{{ old('link_maps', $galeri->link_maps) }}',
        localFoto: ''
    }" action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 border border-gray-200 rounded-lg shadow-lg">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Form Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="judul" id="judul" x-model="judul" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" maxlength="100" required>
                    @error('judul')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" x-model="deskripsi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" maxlength="100" required>
                    @error('deskripsi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="full_description" class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                <textarea name="full_description" id="full_description" x-model="full_description" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3" required></textarea>
                @error('full_description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto URL</label>
                <input type="text" name="foto" id="foto" x-model="foto" @input="previewImage" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter image URL">
                @error('foto')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="local_foto" class="block text-sm font-medium text-gray-700 mb-1">Upload Foto</label>
                <input type="file" name="local_foto" id="local_foto" @change="previewLocalImage" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('local_foto')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div x-show="foto || localFoto" class="mt-2">
                <img :src="localFoto ? localFoto : foto" alt="Preview" class="max-w-full h-auto rounded-lg shadow-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <div class="grid grid-cols-2 gap-2">
                    <template x-for="cat in ['alam', 'sejarah', 'kuliner', 'budaya']" :key="cat">
                        <button type="button"
                                @click="category = cat"
                                :class="{
                                    'bg-indigo-600 text-white': category === cat,
                                    'bg-gray-100 text-gray-700 hover:bg-gray-200': category !== cat,
                                    'border rounded-md py-2 px-3 text-sm font-medium transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50': true
                                }">
                            <span x-text="cat"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="kategori" x-model="category" required>
                @error('kategori')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="link_maps" class="block text-sm font-medium text-gray-700 mb-1">Link Maps</label>
                <input type="text" name="link_maps" id="link_maps" x-model="link_maps" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('link_maps')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.galeri.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Back to List
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Update
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage() {
        const input = document.querySelector('#foto');
        this.foto = input.value;
    }

    function previewLocalImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            this.localFoto = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            this.localFoto = '';
        }
    }
</script>
@endsection
