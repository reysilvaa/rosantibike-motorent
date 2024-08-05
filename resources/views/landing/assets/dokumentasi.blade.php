<!-- Dokumentasi Section -->
<section id="dokumentasi" class="bg-gradient-to-bl from-purple-600 to-blue-500 text-white py-20">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 text-white">Jelajahi Petualangan Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $mainImage = $galeris->first() ?? (object)[ 'foto' => 'path/to/default/image.jpg', 'judul' => 'Default Title', 'deskripsi' => 'Default Description' ];
            @endphp
            <div class="col-span-2">
                <div class="relative overflow-hidden rounded-lg shadow-2xl group cursor-pointer" id="mainImage">
                    <img src="{{ $mainImage->foto ?? 'path/to/default/image.jpg' }}" alt="Dokumentasi Utama" class="w-full h-96 object-cover transition duration-500 transform group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-0 group-hover:opacity-75 transition duration-300 flex flex-col justify-end p-6">
                        <h3 class="text-white text-2xl font-bold mb-2 transform translate-y-10 group-hover:translate-y-0 transition duration-300">{{ $mainImage->judul ?? 'Default Title' }}</h3>
                        <p class="text-white opacity-0 group-hover:opacity-100 transition duration-300 delay-100">{{ $mainImage->deskripsi ?? 'Default Description' }}</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                @foreach($galeris as $galeri)
                    @if($galeri !== $mainImage)
                        <div class="relative overflow-hidden rounded-lg shadow-xl cursor-pointer" onclick="changeMainImage(this)">
                            <img src="{{ $galeri->foto ?? 'path/to/default/image.jpg' }}" alt="Dokumentasi" class="w-full h-44 object-cover transition duration-300 transform hover:scale-110">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-300">
                                <p class="text-white text-lg font-semibold">{{ $galeri->judul ?? 'Default Title' }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
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

    mainImage.src = element.querySelector('img').src || 'path/to/default/image.jpg';
    mainTitle.textContent = element.querySelector('p').textContent || 'Default Title';
    mainDesc.textContent = "Jelajahi " + (element.querySelector('p').textContent || 'Default Title') + " dengan motor sewaan kami";
}
</script>
