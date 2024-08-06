@include('landing.assets.navbar-no-scroll')
<section id="galeri-wisata" class="py-20 bg-gradient-to-b from-blue-50 to-white" x-data="galleryData({{ $galeris->toJson() }})" x-init="init()">
    <div class="container mx-auto px-4">
            <div class="container mx-auto px-4">
                <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-7 pt-10">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        Pesona Malang
                    </span>
                </h2>
            </div>

            <!-- Adjusted Carousel -->
            <div class="relative mb-20 overflow-hidden rounded-3xl shadow-lg max-w-8xl mx-auto"> <!-- Increased width -->
                <div class="carousel-container" x-ref="carousel">
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
                        <template x-for="(item, index) in galeris" :key="index">
                            <div class="carousel-slide flex-shrink-0 w-full" style="height: 490px;"> <!-- Example height -->
                                <div class="relative h-full overflow-hidden">
                                    <img :src="item.foto" :alt="item.judul" class="w-full h-full object-cover transition-transform duration-300 ease-in-out transform hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                        <h3 class="text-lg font-bold mb-2" x-text="item.judul"></h3>
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
        <div class="flex justify-center mb-12 space-x-2 sm:space-x-4 flex-wrap -mt-10"> <!-- Added negative margin-top -->
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

        <!-- Uniform Grid Gallery with fixed-size items and hover vignette effect -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="item in filteredItems" :key="item.id">
                <div
                    x-show="filter === 'Semua' || item.kategori.toLowerCase() === filter.toLowerCase()"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="relative rounded-xl overflow-hidden shadow-lg cursor-pointer group h-64 w-full"
                    @click="openModal(item)"
                >
                    <div class="h-full w-full overflow-hidden">
                        <img :src="item.foto" :alt="item.judul" class="w-full h-full object-cover object-center transition duration-300 ease-in-out transform group-hover:scale-110">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-4">
                        <h3 class="text-lg text-white font-bold mb-1 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300" x-text="item.judul"></h3>
                        <p class="text-xs text-gray-200 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 line-clamp-3" x-text="item.deskripsi"></p>
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
            class="bg-white rounded-2xl overflow-hidden shadow-2xl w-full max-w-lg sm:max-w-xl"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
        >
            <div class="relative">
                <img :src="selectedItem.foto" :alt="selectedItem.judul" class="w-full h-48 sm:h-56 object-cover">
                <button @click="closeModal()" class="absolute top-2 right-2 text-white bg-black bg-opacity-50 rounded-full p-1 hover:bg-opacity-75 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-4">
                <h3 class="text-xl sm:text-2xl font-bold mb-2" x-text="selectedItem.judul"></h3>
                <div class="text-gray-700 text-sm sm:text-base mb-4 max-h-32 overflow-y-auto pr-2 custom-scrollbar">
                    <p x-text="selectedItem.full_description"></p>
                </div>
                <div class="flex justify-end">
                    <a
                        :href="selectedItem.link_maps"
                        target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition duration-300 ease-in-out transform hover:scale-105"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        View on Map
                    </a>
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
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@include('landing.assets.footer')
