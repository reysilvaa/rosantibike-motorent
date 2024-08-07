@include('landing.assets.link.link')
    <meta http-equiv="Content-Security-Policy" content="default-src 'self';
    script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net;
    style-src 'self' 'unsafe-inline' https://unpkg.com https://cdn.jsdelivr.net;
    img-src 'self' data: https:;
    connect-src 'self' https:;
    font-src 'self' data: https:;
    frame-src 'self' https://www.google.com;
    object-src 'none';
    base-uri 'self';
    ">

    <title>@yield('title', 'Motor Matic - Rental Motor Rosanti')</title>

<body class="font-['Poppins'] bg-gray-50 text-gray-800">
<header class="bg-white shadow-md py-4 fixed w-full z-50">
    <nav class="container mx-auto px-6 flex justify-between items-center">
        <!-- Brand -->
        <a href="{{ route('landing') }}" class="flex items-center">
            <img src="{{asset('logo2.png')}}" alt="RosantiBike Motorent - Rental Motor Malang"
                 class="logo-image max-w-[180px] h-auto object-contain"> <!-- Mengatur ukuran logo -->
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
                    <a href="{{ route('landing.motor-manual') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-blue-500 hover:text-white">Motor Manual</a>
                </div>
            </div>
            <a href="{{ route('landing.faqs') }}" class="text-gray-800 hover:text-blue-500 transition duration-300">FAQ'S</a>
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
                <a href="{{ route('landing') }}#layanan" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Dokumentasi</a>
                <a href="{{ route('landing.motor-matic') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Motor Matic</a>
                <a href="{{ route('landing') }}#testimoni" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Testimoni</a>
                <a href="{{ route('landing') }}#kontak" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Kontak</a>
            </div>
        </div>
    </nav>
</header>
