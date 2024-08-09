<!-- Fasilitas Section -->
<section id="fasilitas" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Fasilitas Kami</h2>
        <div class="flex flex-wrap justify-center gap-8">
            <!-- Pemesanan Card -->
            <div x-data="{ hover: false }" class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 flex justify-center">
                <div
                    :class="{ 'scale-105': hover }"
                    @mouseenter="hover = true"
                    @mouseleave="hover = false"
                    class="bg-white rounded-lg shadow-lg transition-transform duration-300 ease-in-out transform p-6 max-w-sm w-full"
                >
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Pemesanan</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Pemesanan Mudah dan Fleksibel
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Pembayaran Fleksibel
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Tambahan Card -->
            <div x-data="{ hover: false }" class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8 flex justify-center">
                <div
                    :class="{ 'scale-105': hover }"
                    @mouseenter="hover = true"
                    @mouseleave="hover = false"
                    class="bg-white rounded-lg shadow-lg transition-transform duration-300 ease-in-out transform p-6 max-w-sm w-full"
                >
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Tambahan</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Rekomendasi Wisata
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Helm & Jas Hujan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
