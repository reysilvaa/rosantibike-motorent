<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden">
<head>

    {{-- Navbar --}}
    @include('landing.assets.navbar')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="overflow-x-hidden">
    <x-loading-spinner />

    <!-- Hero Section -->
    <section id="beranda" class="relative bg-cover bg-center text-white pt-32 pb-20 lazy-bg" data-bg="https://i.ibb.co.com/QNzQz3f/Upscale-Image-2-20240727.png" x-data="{ typingText: '', fullText: 'Jelajahi Malang dengan Mudah', index: 0, loadingComplete: false }" x-init="() => {
        function typeEffect() {
            if (index < fullText.length) {
                typingText += fullText[index];
                index++;
                setTimeout(typeEffect, 100);
            }
        }

        function init() {
            setTimeout(() => {
                const spinner = document.getElementById('loading-spinner');
                if (spinner) {
                    spinner.style.display = 'none';
                }
                loadingComplete = true;
                typeEffect();
            }, 3000);
        }

        init();
    }">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight" x-text="typingText"></h1>
            <p class="text-xl md:text-2xl mb-8 font-light">
                Sewa motor berkualitas untuk petualangan Anda di Kota Malang
            </p>
            <a href="https://wa.me/628113535122" id="pesan-now" class="bg-white text-blue-600 py-3 px-8 rounded-full text-lg font-semibold shadow-md hover:bg-blue-50 transition duration-300 ease-in-out" target="_blank">
                Pesan Sekarang
            </a>
        </div>
    </section>

    <!-- Keunggulan Section -->
    @include('landing.assets.keunggulan')

    <!-- Maps Section -->
    @include('landing.assets.promo')

    <!-- Layanan Section -->
    @include('landing.assets.layanan')

    <!-- Armada Section -->
    @include('landing.assets.armada')

    <!-- Syarat Rental Section -->
    @include('landing.assets.syarat')

    <!-- Fasilitas Section -->
    @include('landing.assets.fasilitas')

    <!-- Alur Sewa Section -->
    @include('landing.assets.alursewa')

    <!-- Testimoni Section -->
    @include('landing.assets.testimoni')

    <!-- Dokumentasi Section -->
    @include('landing.assets.dokumentasi')

    <!-- Call-to-Action Section -->
    <section id="cta" class="bg-gradient-to-br from-blue-500 to-purple-600 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Siap untuk Petualangan Anda?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Jangan tunggu lebih lama! Segera sewa motor berkualitas dan nikmati perjalanan Anda di Malang.</p>
            <a href="https://wa.me/628113535122?text=Halo%20kak!%20Saya%20tertarik%20untuk%20sewa%20" id="pesan-now" class="bg-white text-blue-600 py-3 px-8 rounded-full text-lg font-semibold shadow-lg hover:bg-blue-50 transition transform duration-300 ease-in-out" target="_blank" x-data="{ bounce: false }" @mouseenter="bounce = true" @animationend="bounce = false" :class="{ 'animate-bounce': bounce }">
                Pesan Sekarang
            </a>
        </div>
    </section>

    <!-- Kontak Section -->
    @include('landing.assets.kontak')

    <!-- Footer -->
    @include('landing.assets.footer')

    <script>
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                var header = document.querySelector('header');
                header.classList.toggle('bg-white', window.scrollY > 0);
                header.classList.toggle('shadow-md', window.scrollY > 0);
            });

            // Lazy loading for background images
            const lazyBgElements = document.querySelectorAll('.lazy-bg');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const lazyBg = entry.target;
                        const bgUrl = lazyBg.getAttribute('data-bg');
                        lazyBg.style.backgroundImage = `url('${bgUrl}')`;
                        observer.unobserve(lazyBg);
                    }
                });
            });

            lazyBgElements.forEach(element => {
                observer.observe(element);
            });
    </script>
</body>
</html>
