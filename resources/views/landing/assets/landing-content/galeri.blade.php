@include('landing.assets.navbar-no-scroll')
<section id="galeri-wisata" class="py-20 bg-gradient-to-b from-blue-50 to-white" x-data="galleryData({{ $galeris->toJson() }})" x-init="init()">
    <div class="container mx-auto px-4">
            <div class="container mx-auto px-4">
                <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-20 pt-10">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        Pesona Malang
                    </span>
                </h2>
            </div>

        <!-- Attractive Carousel -->
        <div class="relative mb-20 overflow-hidden rounded-xl shadow-lg">
            <div class="carousel-container" x-ref="carousel">
                <div class="carousel-track flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
                    <template x-for="(item, index) in galeris" :key="index">
                        <div class="carousel-slide flex-shrink-0 w-full">
                            <div class="relative aspect-video overflow-hidden">
                                <img :src="item.foto" :alt="item.judul" class="w-full h-full object-cover transition-transform duration-300 ease-in-out transform hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                    <h3 class="text-2xl font-bold mb-2" x-text="item.judul"></h3>
                                    <p class="text-sm" x-text="item.deskripsi"></p>
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
            <!-- Dot Indicators at the Top -->
            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <template x-for="(item, index) in galeris" :key="index">
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
                    x-show="filter === 'Semua' || item.kategori.toLowerCase() === filter.toLowerCase()"
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
                    <img :src="item.foto" :alt="item.judul" class="w-full h-full object-cover transition duration-300 ease-in-out transform group-hover:scale-110">
                    <div class="absolute inset-0 flex flex-col justify-end p-6">
                        <h3 class="text-xl text-white font-bold mb-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300" x-text="item.judul"></h3>
                        <p class="text-sm text-gray-200 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300" x-text="item.deskripsi"></p>
                    </div>
                </div>
            </template>
        </div>

       <!-- Immersive Modal -->
       <div
            x-show="modalOpen && selectedItem.foto"
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
                class="bg-white rounded-2xl overflow-hidden shadow-2xl w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <div class="relative">
                    <img :src="selectedItem.foto" :alt="selectedItem.judul" class="w-full h-56 object-cover sm:h-72 md:h-96">
                    <button @click="closeModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4 sm:p-6 md:p-8">
                    <h3 class="text-2xl sm:text-3xl font-bold mb-4" x-text="selectedItem.judul"></h3>
                    <p class="text-gray-700 text-base sm:text-lg mb-4" x-text="selectedItem.full_description"></p>
                    <a :href="selectedItem.link_maps" target="_blank" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">View on Map</a>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
function galleryData(galeris) {
    return {
        galeris: galeris,
        categories: ['Semua', ...Array.from(new Set(galeris.map(item => capitalizeFirstLetter(item.kategori))))],
        filter: 'Semua',
        currentSlide: 0,
        modalOpen: false,
        selectedItem: 0, // bug
        filteredItems: [],
        init() {
            this.filteredItems = this.galeris;
        },
        setFilter(category) {
            this.filter = category;
            if (category === 'Semua') {
                this.filteredItems = this.galeris;
            } else {
                this.filteredItems = this.galeris.filter(item => item.kategori.toLowerCase() === category.toLowerCase());
            }
        },
        prevSlide() {
            if (this.currentSlide > 0) {
                this.currentSlide--;
            } else {
                this.currentSlide = this.galeris.length - 1;
            }
        },
        nextSlide() {
            if (this.currentSlide < this.galeris.length - 1) {
                this.currentSlide++;
            } else {
                this.currentSlide = 0;
            }
        },
        goToSlide(index) {
            this.currentSlide = index;
        },
        openModal(item) {
            this.selectedItem = item;
            this.modalOpen = true;
            document.body.style.overflow = 'hidden'; // Prevent scroll on body
        },
        closeModal() {
            this.modalOpen = false;
            this.selectedItem = {}; // Clear selected item
            document.body.style.overflow = ''; // Restore scroll on body
        }
    };
}
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }
</script>
