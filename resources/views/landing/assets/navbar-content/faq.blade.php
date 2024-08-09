<!-- FAQ Section -->
@include('landing.assets.navbar-no-scroll')
<title>
    @yield('title', 'FAQ&rsquo;s - Rental Motor Rosanti')
</title>
<section id="faq" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center text-blue-600 mb-12 mt-16">
            Pertanyaan yang Sering Diajukan
        </h2>

        <div class="flex flex-col md:flex-row items-center justify-center">
            <!-- Image Section using Font Awesome -->
            <div class="hidden md:block md:w-1/3 flex justify-center items-center mb-8 md:mb-0">
                <i class="fas fa-question-circle text-gray-400 text-9xl"></i>
            </div>

            <!-- Image Section using W3Schools SVG -->
            <!--
            <div class="hidden md:block md:w-1/3 flex justify-center items-center mb-8 md:mb-0">
                <svg width="128" height="128" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-gray-400">
                    <path d="M12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM11 10H13V7H11V10ZM11 17H13V12H11V17Z" fill="currentColor"/>
                </svg>
            </div>
            -->

            <!-- FAQ Section -->
            <div class="max-w-3xl mx-auto md:w-2/3" x-data="{ activeAccordion: null }">
                <!-- FAQ Item 1 -->
                <div class="mb-4">
                    <button
                        @click="activeAccordion = (activeAccordion === 1 ? null : 1)"
                        class="flex justify-between items-center w-full p-5 font-medium text-left text-gray-900 bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition duration-300"
                    >
                        <span>Bagaimana cara memesan motor?</span>
                        <svg :class="{'rotate-180': activeAccordion === 1}" class="w-6 h-6 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div
                        x-show="activeAccordion === 1"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="p-5 bg-white rounded-b-lg shadow-md"
                    >
                        <p class="text-gray-700">Anda dapat memesan motor dengan menghubungi kami melalui WhatsApp lalu mengisi formulir pemesanan di website kami. Kami akan segera merespons dan memproses pesanan Anda.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="mb-4">
                    <button
                        @click="activeAccordion = (activeAccordion === 2 ? null : 2)"
                        class="flex justify-between items-center w-full p-5 font-medium text-left text-gray-900 bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition duration-300"
                    >
                        <span>Apa saja syarat untuk menyewa motor?</span>
                        <svg :class="{'rotate-180': activeAccordion === 2}" class="w-6 h-6 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div
                        x-show="activeAccordion === 2"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="p-5 bg-white rounded-b-lg shadow-md"
                    >
                        <p class="text-gray-700">Syarat utama untuk menyewa motor adalah memiliki SIM yang masih berlaku, KTP, dan deposit sebagai jaminan. Usia minimal penyewa adalah 18 tahun.</p>
                    </div>
                </div>

                <!-- Add more FAQ items here -->

            </div>
        </div>
    </div>
</section>
@include('landing.assets.footer')
