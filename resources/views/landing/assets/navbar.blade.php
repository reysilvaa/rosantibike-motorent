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
<!-- Header -->
<header class="fixed w-full z-50 transition duration-300 ease-in-out"
        x-data="{ isOpen: false, isScrolled: false }"
        @scroll.window="isScrolled = (window.pageYOffset > 20) ? true : false"
        :class="{
            'bg-white shadow-md py-5': isScrolled,
            'bg-transparent py-5': !isScrolled
        }">
    <nav class="container mx-auto px-6 flex justify-between items-center">
        <!-- Brand -->
        <div class="text-2xl font-bold tracking-wide transition duration-300 ease-in-out"
            :class="{'text-blue-600': isScrolled, 'text-white': !isScrolled}">
            Rental Motor Rosanti
        </div>
        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-6 font-medium">
            <a href="#beranda"
               :class="{'text-black': isScrolled, 'text-white': !isScrolled}"
               class="hover:text-blue-500 transition duration-300 ease-in-out">Beranda</a>
            <a href="#layanan"
               :class="{'text-black': isScrolled, 'text-white': !isScrolled}"
               class="hover:text-blue-500 transition duration-300 ease-in-out">Layanan</a>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        :class="{'text-black': isScrolled, 'text-white': !isScrolled}"
                        class="flex items-center hover:text-blue-500 transition duration-300 ease-in-out">
                    Armada
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                    <a href="{{ route('landing.motor-matic') }}"
                       :class="{'text-black': isScrolled, 'text-gray-800': !isScrolled}"
                       class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white">Motor Matic</a>
                    <a href="#"
                       :class="{'text-black': isScrolled, 'text-gray-800': !isScrolled}"
                       class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white">Motor Manual</a>
                    <a href="#"
                       :class="{'text-black': isScrolled, 'text-gray-800': !isScrolled}"
                       class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white">Motor Sport</a>
                </div>
            </div>
            <a href="{{ route('landing.faqs') }}"
               :class="{'text-black': isScrolled, 'text-white': !isScrolled}"
               class="hover:text-blue-500 transition duration-300 ease-in-out">FAQ'S</a>
            <a href="#kontak"
               :class="{'text-black': isScrolled, 'text-white': !isScrolled}"
               class="hover:text-blue-500 transition duration-300 ease-in-out">Kontak</a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="md:hidden">
            <button @click="isOpen = !isOpen" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
                <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" :class="{'hidden': isOpen, 'block': !isOpen}">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                </svg>
                <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" :class="{'block': isOpen, 'hidden': !isOpen}">
                    <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </button>
        </div>
    </nav>
    <!-- Mobile Menu -->
    <div class="md:hidden" x-show="isOpen" @click.away="isOpen = false">
        <a href="#beranda" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Beranda</a>
        <a href="#layanan" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Layanan</a>
        <a href="#armada" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Armada</a>
        <a href="#testimoni" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">FAQ'S</a>
        <a href="#kontak" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Kontak</a>
    </div>
</header>
