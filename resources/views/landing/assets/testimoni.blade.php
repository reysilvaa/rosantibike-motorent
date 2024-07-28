<!-- Testimoni Section -->
<section id="testimoni" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12">Suara Pelanggan Kami</h2>
        <div class="relative">
            <div class="swiper-container overflow-hidden">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="bg-white rounded-lg p-8 shadow-lg transform transition duration-300 hover:scale-105">
                            <div class="flex items-center mb-6">
                                <img src="https://example.com/avatar1.jpg" alt="Avatar" class="w-20 h-20 rounded-full border-4 border-blue-500 mr-4">
                                <div>
                                    <h3 class="text-2xl font-semibold text-gray-800">John Doe</h3>
                                    <p class="text-blue-600">Adventurer dari Jakarta</p>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-6 italic">"Pengalaman luar biasa! Motor yang disewakan dalam kondisi sempurna, dan staf sangat membantu dalam merekomendasikan rute terbaik di Malang. Pasti akan kembali lagi!"</p>
                            <div class="flex justify-between items-center">
                                <div class="flex text-yellow-400">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                </div>
                                <span class="text-gray-500">2 hari yang lalu</span>
                            </div>
                        </div>
                    </div>
                    <!-- Add more swiper-slide elements for additional testimonials -->
                </div>
            </div>
            <div class="swiper-button-next absolute top-1/2 -right-12 transform -translate-y-1/2 bg-white rounded-full shadow-md p-4 focus:outline-none"></div>
            <div class="swiper-button-prev absolute top-1/2 -left-12 transform -translate-y-1/2 bg-white rounded-full shadow-md p-4 focus:outline-none"></div>
        </div>
        <div class="swiper-pagination mt-12"></div>
    </div>
</section>

<script>
var testimoniSwiper = new Swiper('#testimoni .swiper-container', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: '#testimoni .swiper-button-next',
        prevEl: '#testimoni .swiper-button-prev',
    },
    pagination: {
        el: '#testimoni .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        640: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
});
</script>
