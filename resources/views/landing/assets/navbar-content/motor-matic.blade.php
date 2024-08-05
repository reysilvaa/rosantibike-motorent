<title>
    @yield('title', 'List Harga Rental Motor Matic - Rental Motor Rosanti')
</title>
<body class="font-['Poppins'] bg-gray-50 text-gray-800">
    @include('landing.assets.navbar-no-scroll')

    <main class="pt-24 pb-16">
        <div class="container mx-auto px-6">
            <h1 class="text-5xl font-bold mb-8 text-center text-blue-600">Motor Matic</h1>
            <p class="text-xl text-center mb-12 text-gray-600">Pilihan terbaik untuk perjalanan nyaman dan praktis di Kota Malang</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="motorGrid">
                @foreach($motors as $motor)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden motor-card">
                    <img
                        src="{{ $motor->foto ?
                            (filter_var($motor->foto, FILTER_VALIDATE_URL) ?
                            $motor->foto : asset('storage/' . $motor->foto)) : 'https://via.placeholder.com/600x400' }}"
                        alt="{{ $motor->merk ?: 'Motor Image' }}"
                        class="w-full h-56 object-cover"
                        loading="lazy">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-2">{{ $motor->merk }}</h2>
                        <p class="text-gray-600 mb-4">{{ $motor->judul }}.</p>
                        <ul class="text-sm text-gray-600 mb-4">
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $motor->deskripsi1 }}</li>
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $motor->deskripsi2 }}</li>
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $motor->deskripsi1 }}</li>
                        </ul>
                        <p class="text-2xl font-bold text-blue-600 mb-4">Rp {{ number_format($motor->harga_perHari, 0, ',', '.') }} / hari</p>
                        <a href="https://wa.me/+628113535122?text=Saya%20tertarik%20untuk%20menyewa%20{{ urlencode($motor->merk) }}.%20Apakah%20ready?" class="block w-full bg-blue-600 text-white text-center py-2 rounded-full hover:bg-blue-700 transition duration-300" target="_blank">Sewa Sekarang</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    @include('landing.assets.footer')

    <script>
        gsap.from("#motorGrid > div", {
            duration: 1,
            opacity: 0,
            y: 50,
            stagger: 0.2,
            ease: "power3.out"
        });
    </script>
</body>
</html>
