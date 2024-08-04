<!-- Dokumentasi Section -->
<section id="dokumentasi" class="bg-gradient-to-bl from-purple-600 to-blue-500 text-white py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 text-white">Jelajahi Petualangan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="col-span-2">
                <div class="relative overflow-hidden rounded-lg shadow-2xl group cursor-pointer" id="mainImage">
                    <img src="https://radarbanyumas.disway.id/upload/d634d66174e9b70ff4b9aed12aff446a.png" alt="Dokumentasi Utama" class="w-full h-96 object-cover transition duration-500 transform group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-0 group-hover:opacity-75 transition duration-300 flex flex-col justify-end p-6">
                        <h3 class="text-white text-2xl font-bold mb-2 transform translate-y-10 group-hover:translate-y-0 transition duration-300">Pantai Balekambang</h3>
                        <p class="text-white opacity-0 group-hover:opacity-100 transition duration-300 delay-100">Nikmati keindahan pantai dengan motor sewaan kami</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative overflow-hidden rounded-lg shadow-xl cursor-pointer" onclick="changeMainImage(this)">
                    <img src="https://dl.kaskus.id/cdn.statically.io/img/catperku.com/f=auto%2Cq=70/wp-content/uploads/Tips-Touring-Ke-Bromo-Pake-Sepeda-Motor-Matic.jpg" alt="Dokumentasi 2" class="w-full h-44 object-cover transition duration-300 transform hover:scale-110">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                        <p class="text-white text-lg font-semibold">Gunung Bromo</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-lg shadow-xl cursor-pointer" onclick="changeMainImage(this)">
                    <img src="https://asset-2.tstatic.net/travel/foto/bank/images/air-terjun-tumpak-sewu-lumajang-malang.jpg" alt="Dokumentasi 3" class="w-full h-44 object-cover transition duration-300 transform hover:scale-110">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                        <p class="text-white text-lg font-semibold">Tumpak Sewu</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('landing.galeri') }}" class="inline-block bg-white text-blue-600 py-3 px-8 rounded-full text-lg font-semibold hover:bg-blue-100 transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">Lihat Galeri Lengkap</a>
        </div>
    </div>
</section>

<script>
function changeMainImage(element) {
    const mainImage = document.querySelector('#mainImage img');
    const mainTitle = document.querySelector('#mainImage h3');
    const mainDesc = document.querySelector('#mainImage p');

    mainImage.src = element.querySelector('img').src;
    mainTitle.textContent = element.querySelector('p').textContent;
    mainDesc.textContent = "Jelajahi " + element.querySelector('p').textContent + " dengan motor sewaan kami";
}
</script>
