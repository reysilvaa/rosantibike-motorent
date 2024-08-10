<!-- Dokumentasi Section -->
<section id="dokumentasi" class="bg-gradient-to-bl from-purple-600 to-blue-500 text-white py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 text-white">Rekomendasi Wisata Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $mainImage = $galeris->first() ?? (object)[ 'foto' => 'path/to/default/image.jpg', 'judul' => 'Default Title', 'deskripsi' => 'Default Description' ];
                $otherGalleries = $galeris->reject(fn($item) => $item->foto === $mainImage->foto)->shuffle()->take(2);
            @endphp
            <div class="col-span-2">
                <div class="relative overflow-hidden rounded-lg shadow-2xl group cursor-pointer" id="mainImageContainer">
                    <img src="{{ $mainImage->foto ?? 'path/to/default/image.jpg' }}" alt="Dokumentasi Utama" class="w-full h-96 object-cover transition duration-500 transform group-hover:scale-110" id="mainImage">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-0 group-hover:opacity-75 transition duration-300 flex flex-col justify-end p-6">
                        <h3 class="text-white text-2xl font-bold mb-2 transform translate-y-10 group-hover:translate-y-0 transition duration-300" id="mainTitle">{{ $mainImage->judul ?? 'Default Title' }}</h3>
                        <p class="text-white opacity-0 group-hover:opacity-100 transition duration-300 delay-100" id="mainDesc">{{ $mainImage->deskripsi ?? 'Default Description' }}</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                @foreach($otherGalleries as $galeri)
                    <div class="relative overflow-hidden rounded-lg shadow-xl cursor-pointer" onclick="changeMainImage(this)">
                        <img src="{{ $galeri->foto ?? 'path/to/default/image.jpg' }}" alt="Dokumentasi" class="w-full h-44 object-cover transition duration-300 transform hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                            <p class="text-white text-lg font-semibold">{{ $galeri->judul ?? 'Default Title' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('landing.galeri') }}" class="inline-block bg-white text-blue-600 py-3 px-8 rounded-full text-lg font-semibold hover:bg-blue-100 transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">Lihat Galeri Lengkap</a>
        </div>
    </div>
</section>

<script>
let originalMainImage = document.querySelector('#mainImage').src;
let originalMainTitle = document.querySelector('#mainTitle').textContent;
let originalMainDesc = document.querySelector('#mainDesc').textContent;

function changeMainImage(element) {
    const newMainImage = document.querySelector('#mainImage');
    const newMainTitle = document.querySelector('#mainTitle');
    const newMainDesc = document.querySelector('#mainDesc');

    const clickedImage = element.querySelector('img').src;
    const clickedTitle = element.querySelector('p').textContent;

    newMainImage.src = clickedImage || 'path/to/default/image.jpg';
    newMainTitle.textContent = clickedTitle || 'Default Title';
    newMainDesc.textContent = "Jelajahi " + (clickedTitle || 'Default Title') + " dengan motor sewaan kami";

    element.querySelector('img').src = originalMainImage;
    element.querySelector('p').textContent = originalMainTitle;

    // Update original main image details
    originalMainImage = newMainImage.src;
    originalMainTitle = newMainTitle.textContent;
    originalMainDesc = newMainDesc.textContent;
}
</script>
