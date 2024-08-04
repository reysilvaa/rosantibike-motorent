@extends('layouts.admin')

@section('title', 'Invoice Preview')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-lg rounded-lg p-6 relative">
        <!-- PDF Preview -->
        <div class="relative mb-6" style="height: 600px;">
            <iframe src="data:application/pdf;base64,{{ base64_encode($pdf) }}" class="w-full h-full" frameborder="0"></iframe>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4">
            <!-- Download Button -->
            <a href="{{ route('transaksi.invoice.download', $transaksi->id) }}" class="btn btn-primary flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 12h16M4 16h16M10 20l2 2 2-2" />
                </svg>
                <span>Download PDF</span>
            </a>

            <!-- English Preview Button -->
            @if (app()->getLocale() !== 'id' && Route::has('transaksi.invoice.EnglishPreview'))
                <a href="{{ route('transaksi.invoice.EnglishPreview', $transaksi->id) }}" class="btn btn-primary flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7M3 12h.01" />
                    </svg>
                    <span>English Version</span>
                </a>
            @endif

            <!-- Indonesian Preview Button -->
            <a href="{{ route('transaksi.invoice.preview', $transaksi->id) }}" class="btn btn-primary flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
                </svg>
                <span>Versi Bahasa Indonesia</span>
            </a>
        </div>
    </div>
</div>
@endsection
