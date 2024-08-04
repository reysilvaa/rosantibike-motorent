<section id="armada" class="py-24 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">Armada Kami</h2>
        <div class="relative">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($armada as $unit)
                        <div class="swiper-slide bg-white p-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:shadow-xl hover:-translate-y-1">
                            <img
                                src="{{ $unit->foto ?
                                    (filter_var($unit->foto, FILTER_VALIDATE_URL) ?
                                    $unit->foto : asset('storage/' . $unit->foto)) : 'https://via.placeholder.com/600x400' }}" alt="{{ $unit->merk ?: 'Motor Image' }}"                                alt="{{ $unit->merk }}"
                                class="w-full h-48 object-cover rounded-lg mb-6"
                                loading="lazy"
                            >
                            <h3 class="text-xl font-semibold mb-2 text-gray-800">{{ $unit->merk }}</h3>
                            <p class="text-gray-600 mb-4">Rp {{ number_format($unit->harga_perHari, 0, ',', '.') }}/hari</p>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full transition duration-300 ease-in-out text-sm">Sewa Sekarang</button>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination mt-8"></div>
            </div>
            <div class="hidden md:block">
                <button class="swiper-button-prev w-10 h-10 bg-white rounded-full shadow-md text-blue-600 transition duration-300 hover:bg-blue-50 focus:outline-none absolute top-1/2 -left-5 transform -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="swiper-button-next w-10 h-10 bg-white rounded-full shadow-md text-blue-600 transition duration-300 hover:bg-blue-50 focus:outline-none absolute top-1/2 -right-5 transform -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
