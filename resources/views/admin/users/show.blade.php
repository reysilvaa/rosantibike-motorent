@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-extrabold mb-4 text-gray-800">Detail Pengguna</h1>

        <div class="mb-6 border-b border-gray-200 pb-4">
            <p class="text-xl font-semibold text-gray-700">Username:</p>
            <p class="text-lg text-gray-600">{{ $user->uname }}</p>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M12 4v16"></path></svg>
                Edit
            </a>

            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                    Hapus
                </button>
            </form>
        </div>

        <div class="mt-6">
            <x-back-to-list-button route="{{ route('admin.users.index') }}" />
        </div>
    </div>
</div>
@endsection
