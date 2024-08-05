@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Ratings</h1>

    <a href="{{ route('admin.rating.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition duration-200">Add New Rating</a>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($ratings as $rating)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rating->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rating->deskripsi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rating->role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rating->rating }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $rating->tanggal->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.rating.edit', $rating->id) }}" class="text-green-600 hover:text-green-900 ml-4">Edit</a>
                            <form action="{{ route('admin.rating.destroy', $rating->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
