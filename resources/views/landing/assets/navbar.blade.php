@include('landing.assets.link.link')
<head>
    <meta http-equiv="Content-Security-Policy" content="
    default-src 'self';
    script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net;
    style-src 'self' 'unsafe-inline' https://unpkg.com https://cdn.jsdelivr.net;
    img-src 'self' data: https:;
    connect-src 'self' https:;
    font-src 'self' data: https:;
    frame-src 'self' https://www.google.com;
    object-src 'none';
    base-uri 'self';
    ">
    <meta name="description" content="@yield('meta_description', 'Sewa motor berkualitas di Malang dengan harga bersaing! Temukan berbagai pilihan motor untuk perjalanan Anda di Malang. Layanan pelanggan profesional dan pengalaman rental motor terbaik hanya di Rosantibike Motorent.')">
    <meta name="description" content="Sewa motor di Malang dengan layanan terpercaya dan harga terbaik. Pilih dari berbagai pilihan motor berkualitas di Rosantibike Motorent. Ideal untuk perjalanan Anda di Malang. Hubungi kami untuk layanan pelanggan yang ramah dan efisien!">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <title>@yield('title', 'Motor Matic - Rental Motor Rosanti')</title>
</head>
<body class="font-['Poppins'] bg-gray-50 text-gray-800">
<!-- Header -->
<header class="fixed w-full z-50 transition duration-300 ease-in-out"
        x-data="{ isOpen: false, isScrolled: false }"
        @scroll.window="isScrolled = (window.pageYOffset > 20) ? true : false"
        :class="{
            'bg-white shadow-md py-4': isScrolled,
            'bg-transparent py-4': !isScrolled
        }">
    <nav class="container mx-auto px-10 flex justify-between items-center">
        <!-- Brand -->
        <div class="flex items-center ml-[-10px]"> <!-- Sesuaikan margin-left jika perlu -->
            <img :src="isScrolled ? '{{asset('logo2.png')}}' : '{{asset('logo1.png')}}'"
                 alt="RosantiBike Motorent - Rental Motor Malang"
                 class="logo-image max-w-[180px] max-h-[100px] object-contain"> <!-- Mengatur ukuran maksimum -->
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-6 font-medium">
            <a href="#beranda"
               :class="{'text-black': isScrolled, 'text-white': !isScrolled}"
               class="hover:text-blue-500 transition duration-300 ease-in-out">Beranda</a>
            <a href="{{ route('landing.galeri') }}"
               :class="{'text-black': isScrolled, 'text-white': !isScrolled}"
               class="hover:text-blue-500 transition duration-300 ease-in-out">Rekomendasi</a>
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
                    <a href="{{ route('landing.motor-manual') }}"
                       :class="{'text-black': isScrolled, 'text-gray-800': !isScrolled}"
                       class="block px-4 py-2 text-sm hover:bg-blue-500 hover:text-white">Motor Manual</a>
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
        <a href="{{ route('landing') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Beranda</a>
        <a href="{{ route('landing.galeri') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Rekomendasi</a>
        <a href="{{ route('landing.motor-matic') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Motor Matic</a>
        <a href="{{ route('landing.motor-manual') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Motor Manual</a>
        <a href="{{ route('landing.faqs') }}" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">FAQ'S</a>
        <a href="#kontak" class="block py-2 px-4 text-sm hover:bg-blue-500 hover:text-white">Kontak</a>
    </div>
</header>
