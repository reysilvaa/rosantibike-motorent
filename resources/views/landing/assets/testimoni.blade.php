<!-- Testimoni Section -->
<section id="testimoni" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12">Suara Pelanggan Kami</h2>
        <div class="relative">
            <div class="swiper-container overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach ($reviews as $review)
                        <x-review-card :reviewId="$review->id" />
                    @endforeach
                </div>
                <div class="swiper-pagination mt-12"></div>
            </div>
            <div class="swiper-button-next absolute top-1/2 -right-4 transform -translate-y-1/2 bg-white rounded-full shadow-md p-4 focus:outline-none"></div>
            <div class="swiper-button-prev absolute top-1/2 -left-4 transform -translate-y-1/2 bg-white rounded-full shadow-md p-4 focus:outline-none"></div>
        </div>
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
