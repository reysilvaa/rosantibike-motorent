<!-- FAQ Section -->
@include('landing.assets.navbar-no-scroll')
<section id="faq" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-12 mt-16">Pertanyaan yang Sering Diajukan</h2>

        <div class="max-w-3xl mx-auto" x-data="{ activeAccordion: null }">
            <!-- FAQ Item 1 -->
            <div class="mb-4">
                <button
                    @click="activeAccordion = (activeAccordion === 1 ? null : 1)"
                    class="flex justify-between items-center w-full p-5 font-medium text-left text-gray-900 bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200"
                >
                    <span>Bagaimana cara memesan motor?</span>
                    <svg :class="{'rotate-180': activeAccordion === 1}" class="w-6 h-6 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
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
                    <p class="text-gray-700">Anda dapat memesan motor dengan menghubungi kami melalui WhatsApp atau mengisi formulir pemesanan di website kami. Kami akan segera merespons dan memproses pesanan Anda.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="mb-4">
                <button
                    @click="activeAccordion = (activeAccordion === 2 ? null : 2)"
                    class="flex justify-between items-center w-full p-5 font-medium text-left text-gray-900 bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200"
                >
                    <span>Apa saja syarat untuk menyewa motor?</span>
                    <svg :class="{'rotate-180': activeAccordion === 2}" class="w-6 h-6 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
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

            <!-- Tambahkan FAQ Item lainnya di sini -->

        </div>
    </div>
</section>
