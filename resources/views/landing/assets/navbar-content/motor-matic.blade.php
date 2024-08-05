{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motor Matic - Rental Motor Rosanti</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <style>
        .motor-card {
            transition: transform 0.3s ease-in-out;
        }
        .motor-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body class="font-['Poppins'] bg-gray-50 text-gray-800">
    @include('landing.assets.navbar-no-scroll')

    <main class="pt-24 pb-16">
        <div class="container mx-auto px-6">
            <h1 class="text-5xl font-bold mb-8 text-center text-blue-600">Motor Matic</h1>
            <p class="text-xl text-center mb-12 text-gray-600">Pilihan terbaik untuk perjalanan nyaman dan praktis di Kota Malang</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="motorGrid">
                <!-- Motor Matic Item 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden motor-card">
                    <img src="https://example.com/honda-beat.jpg" alt="Honda BeAT" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-2">Honda BeAT</h2>
                        <p class="text-gray-600 mb-4">Motor matic ringan dan irit bahan bakar, cocok untuk perjalanan dalam kota.</p>
                        <ul class="text-sm text-gray-600 mb-4">
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Kapasitas Mesin: 110cc</li>
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Konsumsi BBM: 59.1 km/liter</li>
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Fitur: CBS (Combi Brake System)</li>
                        </ul>
                        <p class="text-2xl font-bold text-blue-600 mb-4">Rp 75.000 / hari</p>
                        <a href="#" class="block w-full bg-blue-600 text-white text-center py-2 rounded-full hover:bg-blue-700 transition duration-300">Sewa Sekarang</a>
                    </div>
                </div>

                <!-- Motor Matic Item 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden motor-card">
                    <img src="https://example.com/yamaha-nmax.jpg" alt="Yamaha NMAX" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-2">Yamaha NMAX</h2>
                        <p class="text-gray-600 mb-4">Skuter matik premium dengan performa tinggi dan kenyamanan maksimal.</p>
                        <ul class="text-sm text-gray-600 mb-4">
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Kapasitas Mesin: 155cc</li>
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Fitur: ABS, Smart Key System</li>
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Bagasi: Luas, muat helm full-face</li>
                        </ul>
                        <p class="text-2xl font-bold text-blue-600 mb-4">Rp 125.000 / hari</p>
                        <a href="#" class="block w-full bg-blue-600 text-white text-center py-2 rounded-full hover:bg-blue-700 transition duration-300">Sewa Sekarang</a>
                    </div>
                </div>

                <!-- Add more motor matic items as needed -->
            </div>
        </div>
    </main>

    @include('landing.assets.footer')

    <script>
        // Animation for motor cards
        gsap.from("#motorGrid > div", {
            duration: 1,
            opacity: 0,
            y: 50,
            stagger: 0.2,
            ease: "power3.out"
        });
    </script>
</body>
</html> --}}
<title>
    @yield('title', 'Motor Matic - Rental Motor Rosanti')
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
                    <img src="{{ $motor->foto }}" alt="{{ $motor->merk }}" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-2">{{ $motor->merk }}</h2>
                        <p class="text-gray-600 mb-4">{{ $motor->judul }}.</p>
                        <ul class="text-sm text-gray-600 mb-4">
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $motor->deskripsi1 }}</li>
                            <li class="flex items-center mb-1"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $motor->deskripsi2 }}</li>
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>{{ $motor->deskripsi3 }}</li>
                        </ul>
                        <p class="text-2xl font-bold text-blue-600 mb-4">Rp {{ number_format($motor->harga_perHari, 0, ',', '.') }} / hari</p>
                        <a href="https://wa.me/082331044747?text=Saya%20tertarik%20untuk%20menyewa%20{{ urlencode($motor->merk) }}.%20Apakah%20ready?" class="block w-full bg-blue-600 text-white text-center py-2 rounded-full hover:bg-blue-700 transition duration-300" target="_blank">Sewa Sekarang</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    @include('landing.assets.footer')

    <script>
        // Animation for motor cards
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
