<!-- Galeri Wisata Section -->
@include('landing.assets.navbar-no-scroll')
<section id="galeri-wisata" class="py-20 bg-gradient-to-b from-blue-50 to-white" x-data="galleryData()" x-init="init()">
    <div class="container mx-auto px-4">
        <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-12">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                <span class="block mt-6">Jelajahi</span>
                Pesona Malang
            </span>
        </h2>

        <!-- Attractive Carousel -->
        <div class="relative mb-20 overflow-hidden rounded-xl shadow-lg">
            <div class="carousel-container" x-ref="carousel">
                <div class="carousel-track flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
                    <template x-for="(story, index) in stories" :key="index">
                        <div class="carousel-slide flex-shrink-0 w-full">
                            <div class="relative aspect-video overflow-hidden">
                                <img :src="story.image" :alt="story.title" class="w-full h-full object-cover transition-transform duration-300 ease-in-out transform hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                    <h3 class="text-2xl font-bold mb-2" x-text="story.title"></h3>
                                    <p class="text-sm" x-text="story.description"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <button @click="prevSlide" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="nextSlide" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <template x-for="(story, index) in stories" :key="index">
                    <button @click="goToSlide(index)" class="w-3 h-3 rounded-full transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400" :class="currentSlide === index ? 'bg-white scale-125' : 'bg-gray-400 hover:bg-gray-300'"></button>
                </template>
            </div>
        </div>

        <!-- Interactive Category Filters -->
        <div class="flex justify-center mb-12 space-x-2 sm:space-x-4 flex-wrap">
            <template x-for="cat in categories" :key="cat">
                <button
                    @click="setFilter(cat)"
                    :class="{'bg-gradient-to-r from-blue-600 to-purple-600 text-white': filter === cat,
                             'bg-white text-gray-800 hover:bg-gray-100': filter !== cat}"
                    class="px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-lg font-semibold shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 mb-4"
                    x-text="cat"
                ></button>
            </template>
        </div>

        <!-- Uniform Grid Gallery with Masonry-like effect -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-fr">
            <template x-for="item in filteredItems" :key="item.id">
                <div
                    x-show="filter === 'Semua' || item.category === filter"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="relative rounded-xl overflow-hidden shadow-lg cursor-pointer group"
                    @click="openModal(item)"
                >
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <img :src="item.image" :alt="item.title" class="w-full h-full object-cover transition duration-300 ease-in-out transform group-hover:scale-110">
                    <div class="absolute inset-0 flex flex-col justify-end p-6">
                        <h3 class="text-xl text-white font-bold mb-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300" x-text="item.title"></h3>
                        <p class="text-sm text-gray-200 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300" x-text="item.description"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Immersive Modal -->
        <div
            x-show="modalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-90"
            @click.away="closeModal()"
            @keydown.escape.window="closeModal()"
        >
            <div
                class="bg-white rounded-2xl overflow-hidden max-w-5xl w-full shadow-2xl"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <div class="relative">
                    <img :src="selectedItem.image" :alt="selectedItem.title" class="w-full h-96 object-cover">
                    <button @click="closeModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-8">
                    <h3 class="text-3xl font-bold mb-4" x-text="selectedItem.title"></h3>
                    <p class="text-gray-600 mb-6 text-lg leading-relaxed" x-text="selectedItem.fullDescription"></p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500" x-text="`Kategori: ${selectedItem.category}`"></span>
                        <a :href="selectedItem.mapLink" target="_blank" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300">
                            Lihat di Peta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function galleryData() {
    return {
        filter: 'Semua',
        modalOpen: false,
        selectedItem: {},
        currentSlide: 0,
        categories: ['Semua', 'Alam', 'Sejarah', 'Kuliner', 'Budaya'],
        stories: [
            {
                title: "Gunung Bromo",
                image: "https://asset.kompas.com/crops/6vjzgChZBTAAhwLJE3gDJ9j3pV0=/0x0:750x500/750x500/data/photo/2023/05/09/645a0567b9afc.jpeg",
                description: "Pemandangan matahari terbit yang memukau di Gunung Bromo"
            },
            {
                title: "Candi Singosari",
                image: "https://upload.wikimedia.org/wikipedia/commons/1/15/Candi_Singosari_B.JPG",
                description: "Warisan sejarah Kerajaan Singosari yang megah"
            },
            {
                title: "Pasar Besar Malang",
                image: "https://tugumalang.id/wp-content/uploads/2021/03/WhatsApp-Image-2021-03-06-at-10.42.42-1.jpeg",
                description: "Pusat kuliner tradisional Malang yang ramai"
            },
        ],
        items: [
            {
                id: 1,
                title: 'Gunung Bromo',
                description: 'Pemandangan matahari terbit yang menakjubkan',
                fullDescription: 'Gunung Bromo adalah salah satu gunung berapi paling ikonik di Indonesia. Terkenal dengan pemandangan matahari terbitnya yang spektakuler, lautan pasir yang luas, dan upacara Kasada yang unik dari suku Tengger.',
                image: 'https://asset.kompas.com/crops/6vjzgChZBTAAhwLJE3gDJ9j3pV0=/0x0:750x500/750x500/data/photo/2023/05/09/645a0567b9afc.jpeg',
                category: 'Alam',
                mapLink: 'https://goo.gl/maps/BromoLocation'
            },
            {
                id: 2,
                title: 'Candi Singosari',
                description: 'Warisan sejarah Kerajaan Singosari',
                fullDescription: 'Candi Singosari adalah peninggalan bersejarah dari masa kejayaan Kerajaan Singosari. Dibangun pada abad ke-13, candi ini memiliki arsitektur yang megah dan nilai historis yang tinggi, menjadi bukti kejayaan masa lalu.',
                image: 'https://upload.wikimedia.org/wikipedia/commons/1/15/Candi_Singosari_B.JPG',
                category: 'Sejarah',
                mapLink: 'https://goo.gl/maps/SingosariLocation'
            },
            {
                id: 3,
                title: 'Pasar Besar Malang',
                description: 'Surganya pecinta kuliner tradisional',
                fullDescription: 'Pasar Besar Malang adalah surga bagi pencinta kuliner. Di sini, Anda dapat menemukan berbagai makanan khas Malang seperti Bakso Malang yang legendaris, Sate Kambing Madura, dan aneka jajanan tradisional yang menggugah selera.',
                image: 'https://tugumalang.id/wp-content/uploads/2021/03/WhatsApp-Image-2021-03-06-at-10.42.42-1.jpeg',
                category: 'Kuliner',
                mapLink: 'https://goo.gl/maps/PasarBesarLocation'
            },
        ],
        get filteredItems() {
            return this.filter === 'Semua'
                ? this.items
                : this.items.filter(item => item.category === this.filter);
        },
        setFilter(category) {
            this.filter = category;
        },
        openModal(item) {
            this.selectedItem = item;
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.stories.length;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.stories.length) % this.stories.length;
        },
        goToSlide(index) {
            this.currentSlide = index;
        },
        startCarousel() {
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        init() {
            this.startCarousel();
        }
    }
}
</script>
