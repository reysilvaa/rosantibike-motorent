@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Galeri List</h1>

    <a href="{{ route('galeri.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add New Galeri</a>

    <div class="mt-4">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600">ID</th>
                    <th class="px-4 py-2 text-left text-gray-600">Judul</th>
                    <th class="px-4 py-2 text-left text-gray-600">Deskripsi</th>
                    <th class="px-4 py-2 text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($galeris as $galeri)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $galeri->id }}</td>
                        <td class="px-4 py-2 border-b">{{ $galeri->judul }}</td>
                        <td class="px-4 py-2 border-b">{{ $galeri->deskripsi }}</td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('galeri.show', $galeri) }}" class="text-blue-500 hover:text-blue-600">View</a>
                            <a href="{{ route('galeri.edit', $galeri) }}" class="text-yellow-500 hover:text-yellow-600 ml-2">Edit</a>
                            <form action="{{ route('galeri.destroy', $galeri) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
