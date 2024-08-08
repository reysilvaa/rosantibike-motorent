<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Mengapa Memilih Kami?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-500 hover:scale-105 hover:shadow-2xl" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="bg-blue-100 rounded-full p-3 inline-block mb-4 transform transition duration-500" :class="{ 'scale-110': hover }">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 transition duration-500" :class="{ 'text-blue-600': hover }">Proses Mudah</h3>
                <p class="text-gray-600">Proses pemesanan dan pengambilan motor yang mudah dan efisien.</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-500 hover:scale-105 hover:shadow-2xl" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="bg-blue-100 rounded-full p-3 inline-block mb-4 transform transition duration-500" :class="{ 'scale-110': hover }">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 transition duration-500" :class="{ 'text-blue-600': hover }">Kualitas Terjamin</h3>
                <p class="text-gray-600">Semua motor kami selalu dalam kondisi prima dan terawat.</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 text-center transform transition duration-500 hover:scale-105 hover:shadow-2xl" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="bg-blue-100 rounded-full p-3 inline-block mb-4 transform transition duration-500" :class="{ 'scale-110': hover }">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22a10 10 0 110-20 10 10 0 010 20z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 transition duration-500" :class="{ 'text-blue-600': hover }">Hitungan Sewa 24 Jam</h3>
                <p class="text-gray-600">Kami menghitung sewa 24 jam mulai dari anda menerima Motor</p>
            </div>
        </div>
    </div>
</section>
