@extends('layouts.admin')

@section('title', 'Invoice Preview')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-lg rounded-lg p-6 relative">
        <!-- PDF Preview -->
        <div class="relative mb-6" style="height: 600px;">
            <iframe id="pdfIframe" class="w-full h-full" frameborder="0"></iframe>
        </div>

        <!-- Language Selection -->
        <div class="flex flex-wrap space-x-4 mb-4">
            <!-- English Version Button -->
            <button onclick="changeLanguage('en')" class="btn btn-primary flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7M3 12h.01" />
                </svg>
                <span class="hidden md:inline">English Version</span>
                <span class="md:hidden">Inggris</span>
            </button>

            <!-- Indonesian Version Button -->
            <button onclick="changeLanguage('id')" class="btn btn-primary flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
                </svg>
                <span class="hidden md:inline">Versi Bahasa Indonesia</span>
                <span class="md:hidden">Indonesia</span>
            </button>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap space-x-4">
            <!-- Download Button -->
            <a href="{{ route('transaksi.invoice.download', ['type' => request()->route('type'), 'id' => $transaksi->id, 'language' => app()->getLocale()]) }}" class="btn btn-primary flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 12h16M4 16h16M10 20l2 2 2-2" />
                </svg>
                <span class="hidden md:inline">Download PDF</span>
                <span class="md:hidden">Download</span>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var pdfData = @json(base64_encode($pdf));
        var pdfBlob = new Blob([Uint8Array.from(atob(pdfData), c => c.charCodeAt(0))], { type: 'application/pdf' });
        var pdfUrl = URL.createObjectURL(pdfBlob);
        document.getElementById('pdfIframe').src = pdfUrl;
    });

    function changeLanguage(language) {
        const url = new URL(window.location.href);
        url.searchParams.set('language', language);
        window.location.href = url.toString();
    }
</script>
@endsection
