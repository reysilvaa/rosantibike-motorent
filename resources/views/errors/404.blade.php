<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden">
<head>
    <title>Halaman Tidak Ditemukan - RosantiBike Motorent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    @include('landing.assets.navbar')
</head>
<body class="overflow-x-hidden bg-gray-50 flex flex-col min-h-screen">

    <!-- Main Content Section -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative bg-cover bg-center text-white pt-32 pb-20 lazy-bg h-screen" 
                 data-bg="https://i.ibb.co.com/QNzQz3f/Upscale-Image-2-20240727.png">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-6 text-center relative z-10">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">404 - Halaman Tidak Ditemukan</h1>
                <p class="text-xl md:text-2xl mb-8 font-light">
                    Maaf, halaman yang Anda cari tidak ditemukan.
                </p>
                <a href="{{ url('/') }}" 
                   class="bg-white text-blue-600 py-3 px-8 rounded-full text-lg font-semibold shadow-md hover:bg-blue-50 transition duration-300 ease-in-out">
                    Kembali ke Beranda
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    @include('landing.assets.footer')

    <script>
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
