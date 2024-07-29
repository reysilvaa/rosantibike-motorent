<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Motor Rosanti</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-['Poppins'] bg-gray-50 text-gray-800">
<header class="bg-white shadow-md py-1 fixed w-full z-50">
    <nav class="container mx-auto px-6 flex justify-between items-center">
        <!-- Brand -->
        <a href="{{ route('landing') }}" class="text-2xl font-bold text-blue-600">
            <img src="https://i.ibb.co.com/k6sDTzz/Upscale-Image-1-20240729-removebg.png" alt="Upscale-Image-1-20240729" class="logo-image max-w-[250px] h-auto">
        </a>
        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-6 font-medium">
            <a href="{{ route('landing') }}" class="text-gray-800 hover:text-blue-500 transition duration-300">Beranda</a>
            <a href="{{ route('landing') }}#layanan" class="text-gray-800 hover:text-blue-500 transition duration-300">Layanan</a>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="text-gray-800 hover:text-blue-500 transition duration-300 flex items-center">
                    Armada
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                    <a href="{{ route('landing.motor-matic') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-500 hover:text-white">Motor Matic</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-500 hover:text-white">Motor Manual</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-500 hover:text-white">Motor Sport</a>
                </div>
            </div>
            <a href="{{ route('landing') }}#testimoni" class="text-gray-800 hover:text-blue-500 transition duration-300">Testimoni</a>
            <a href="{{ route('landing') }}#kontak" class="text-gray-800 hover:text-blue-500 transition duration-300">Kontak</a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="md:hidden" x-data="{ isOpen: false }">
            <button @click="isOpen = !isOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
                <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" x-show="!isOpen">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                </svg>
                <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" x-show="isOpen">
                    <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </button>
            <!-- Mobile Menu -->
            <div x-show="isOpen" class="absolute top-full left-0 right-0 bg-white shadow-md mt-2 py-2" @click.away="isOpen = false">
                <a href="{{ route('landing') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Beranda</a>
                <a href="{{ route('landing') }}#layanan" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Layanan</a>
                <a href="{{ route('landing.motor-matic') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Motor Matic</a>
                <a href="{{ route('landing') }}#testimoni" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Testimoni</a>
                <a href="{{ route('landing') }}#kontak" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Kontak</a>
            </div>
        </div>
    </nav>
</header>
