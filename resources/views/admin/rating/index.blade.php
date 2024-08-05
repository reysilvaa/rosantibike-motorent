@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 overflow-hidden">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-900">Ratings</h1>

    <!-- Improved Add New Rating Button -->
    <a href="{{ route('admin.rating.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg mb-4 inline-block hover:bg-blue-700 transition duration-300 transform hover:scale-105 flex items-center justify-center space-x-2 shadow-md hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        <span class="font-medium">Add New Rating</span>
    </a>

    <div class="flex flex-wrap -mx-4">
        @foreach ($ratings as $rating)
            <div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 px-4 mb-6">
                <div x-data="{ open: false }" class="relative bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200 transition-transform transform hover:scale-105 hover:shadow-xl hover:border-gray-300">
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <!-- Display stars based on rating -->
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 17.27l-5.18 3.01 1.36-5.92L2 8.6l6.09-.51L12 2l3.91 6.09 6.09.51-4.18 3.76 1.36 5.92z"/>
                                    </svg>
                                @endfor
                            </div>
                            <div class="ml-4 text-gray-600 text-sm">{{ $rating->rating }} / 5</div>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ $rating->nama }}</h2>
                        <p class="text-gray-700 mb-4">{{ Str::limit($rating->deskripsi, 100) }}</p>
                        <p class="text-gray-500 text-sm mb-4">{{ $rating->tanggal->format('F j, Y') }}</p>
                        <div class="flex items-center space-x-4">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.rating.edit', $rating->id) }}" class="text-green-600 hover:text-green-800 transition duration-300 flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3l4 4m0 0l-4 4m4-4H8m1 1l4 4-4 4"/>
                                </svg>
                                <span>Edit</span>
                            </a>

                            <!-- Details Button -->
                            <button @click="open = !open" class="text-blue-500 hover:text-blue-700 transition duration-300 flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 19l-7-7 7-7 7 7-7 7z"/>
                                </svg>
                                <span>Details</span>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.rating.destroy', $rating->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition duration-300 flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18M6 6v12h12V6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2M5 6v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6H5z"/>
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                        <!-- Details Section -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-full" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 max-h-full" x-transition:leave-end="opacity-0 max-h-0" class="mt-4 p-4 bg-gray-100 rounded-lg overflow-hidden">
                            <p class="text-gray-800">{{ $rating->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
