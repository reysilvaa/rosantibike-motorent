<!-- Testimoni Section -->
<section id="testimoni" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12">Suara Pelanggan Kami</h2>
        <div class="relative">
            <div class="swiper-container overflow-hidden">
                <div class="swiper-wrapper">
                    <x-review-card
                        avatar="https://lh3.googleusercontent.com/a-/ALV-UjUagSwJ8uvyLK0unN-bvLzI2hGU_9S3VXD6iZLRaShUbOsZvK3p=w45-h45-p-rp-mo-ba6-br100"
                        name="Muhammad Rosyid"
                        role="Local Guide"
                        review="pelayanan mantap, ramah dan responsif, kondisi motor oke, include helm dan jas hujan, harga terjangkau, lokasi mudah ditengah kota, mudah diakses, proses cepat"
                        rating="5"
                        timeAgo="5 bulan yang lalu"
                    />
                <!-- Add more swiper-slide elements for additional testimonials -->
                <x-review-card
                        avatar="https://lh3.googleusercontent.com/a-/ALV-UjUn_5YJOLPMhTrNOZ_tc5cZTS-Rloh6udz-WlX7kzZTZGdtel-L=w75-h75-p-rp-mo-br100"
                        name="rifdah audia"
                        role="Wisatawan"
                        review="Pelayanan ramah, bisa di order lebih cepat dari perkiraan di gform, dan bisa req 2 helm dg 2 jas hujan, terima kasihh kak sdh di bantu sukses selalu."
                        rating="5"
                        timeAgo="6 bulan yang lalu"
                    />
                <x-review-card
                    avatar="https://lh3.googleusercontent.com/a-/ALV-UjXULjQEmj0Xli9PiXAIMLVSB3PUuiMnnmaOWbvYQS329iwoQ1m_=w45-h45-p-rp-mo-ba5-br100"
                    name="Firdaus Manah"
                    role="Local Guide"
                    review="saya menggunakan motor Yamaha Lexi, Terima kasih Rosantibike Motorent 🙏 semoga selalu amanah kedepannya. …"
                    rating="5"
                    timeAgo="7 bulan yang lalu"
                />
                <x-review-card
                avatar="https://lh3.googleusercontent.com/a/ACg8ocKXqwT2NF64dhGvLYO0rQBKH2Zx-gurzVODGGrSk3mU6uyOEQ=w45-h45-p-rp-mo-br100"
                name="Pengusaha Bisnis"
                role="Pengunjung"
                review="Sangat membantu saya dan istri  untuk keliling kota, kabupaten malang dan batu. respon cepat, helem 2 bersih, ada jas hujan  juga dua dalam jok, stnk lengkap, motor kuat, urusan rental tidak ribet, Terpercaya, bisa ambil di tempat maupun di antar dan jemput. suatu saat nanti akan kesini kalau liburan dari kalimantan ke malang lagi. sukses dan sehat selalu bpk ibu rosanti, By. Ahmad Irfan Kalimantan"
                rating="5"
                timeAgo="1 bulan yang lalu"
                />
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
