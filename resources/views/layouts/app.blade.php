<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'RosantiBike Motorent') }}</title>

    <!-- Tambahkan Vite untuk menggabungkan CSS dan JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SEO Metadata -->
    <meta name="description" content="RosantiBike Motorent - Sewa motor terpercaya di Malang dengan layanan antar-jemput.">
    <meta name="keywords" content="sewa motor, motor rental, malang, rosantibike motorent">

    <!-- Organization Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "RosantiBike Motorent",
      "url": "https://rosantibikemotorent.com",
      "logo": "https://rosantibikemotorent.com/logo.png",
      "sameAs": [
        "https://www.instagram.com/rosantibikemotorent",
        "https://www.facebook.com/rosantibikemotorent"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+62-812-3456-7890",
        "contactType": "Customer Service"
      }
    }
    </script>
</head>
</html>
