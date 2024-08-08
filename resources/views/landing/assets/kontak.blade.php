<section id="kontak" class="bg-gray-100 py-16" x-data="contactForm()">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Hubungi Kami</h2>
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2 p-6 bg-blue-600 text-white">
                    <h3 class="text-2xl font-semibold mb-4">Informasi Kontak</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Jl. Bauksit No.90C, RT.4/RW.9, Purwantoro, Kec. Blimbing, Kota Malang, Jawa Timur 65122
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 811-3535-122
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            rosantibikemotorent@gmail.com
                        </li>
                    </ul>
                </div>
                <div class="md:w-1/2 p-6">
                    <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Nama</label>
                            <input type="text" id="name" x-model="form.name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="asal" class="block text-gray-700 font-semibold mb-2">Asal</label>
                            <input type="asal" id="asal" x-model="form.asal" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 font-semibold mb-2">Pesan</label>
                            <textarea id="message" x-model="form.message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function contactForm() {
        return {
            form: {
                name: '',
                asal: '',
                message: ''
            },
            submitForm() {
                let url = `https://api.whatsapp.com/send?phone=628113535122&text=Nama:%20${encodeURIComponent(this.form.name)}%0AAsal:%20${encodeURIComponent(this.form.asal)}%0AMessage:%20${encodeURIComponent(this.form.message)}`;

                window.open(url, '_blank');

                Swal.fire({
                    icon: 'success',
                    title: 'Terima kasih!',
                    text: 'Pesan Anda telah terkirim.',
                    confirmButtonColor: '#4a76a8',
                });

                this.form = { name: '', asal: '', message: '' };
            }
        }
    }
</script>
