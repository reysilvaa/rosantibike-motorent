<!-- resources/views/components/review-card.blade.php -->

<div class="swiper-slide">
    <div class="bg-white rounded-lg p-8 shadow-lg transform transition duration-300 hover:scale-105 h-96">
        <div class="flex items-center mb-6">
            <img src="{{ $review->avatar ? Storage::url($review->avatar) : asset('default-avatar.png') }}" alt="Avatar" class="w-20 h-20 rounded-full border-4 border-blue-500 mr-4">
            <div>
                <h3 class="text-2xl font-semibold text-gray-800">{{ $review->nama }}</h3>
                <p class="text-blue-600">{{ $review->role }}</p>
            </div>
        </div>
        <p class="text-gray-700 mb-6 italic line-clamp-4">
            "{{ $review->deskripsi }}"
        </p>
        <div class="flex justify-between items-center">
            <div class="flex text-yellow-400">
                @for ($i = 0; $i < $review->rating; $i++)
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                @endfor
            </div>
            <span class="text-gray-500">{{ \Carbon\Carbon::parse($review->tanggal)->diffForHumans() }}</span>
        </div>
    </div>
</div>
