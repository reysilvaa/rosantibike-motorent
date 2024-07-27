@extends('layouts.admin')
@if (!Auth::check())
    @include('landing.assets.navbar')
@endif

@section('title', 'Form/Booking')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mx-auto px-8 py-16">
    <div class="text-center mb-10">
        <p class="text-2xl font-semibold">Booking Form</p>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- Card Container -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200 mb-12">
            <div class="px-8 py-6 border-b border-gray-200">
                <h5 class="text-3xl font-semibold">Formulir Booking</h5>
            </div>
            <div class="p-8"> <!-- Padding increased for better spacing -->
                <form action="{{ route('transaksi.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <div class="mb-6 flex items-center gap-6">
                        <label for="nama_penyewa" class="w-1/4 text-base font-medium text-gray-700">Nama Penyewa</label>
                        <input type="text" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4" id="nama_penyewa" name="nama_penyewa" placeholder="John Doe" required>
                    </div>

                    <div class="mb-6 flex items-center gap-6">
                        <label for="wa1" class="w-1/4 text-base font-medium text-gray-700">WhatsApp 1</label>
                        <input type="tel" id="wa1" name="wa1" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4" placeholder="628123456789" required>
                    </div>

                    <div class="mb-6 flex items-center gap-6">
                        <label for="wa2" class="w-1/4 text-base font-medium text-gray-700">WhatsApp 2 (Optional)</label>
                        <input type="tel" id="wa2" name="wa2" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4" placeholder="628123456789">
                    </div>

                    <div class="mb-6 flex items-center gap-6">
                        <label for="wa3" class="w-1/4 text-base font-medium text-gray-700">WhatsApp 3 (Optional)</label>
                        <input type="tel" id="wa3" name="wa3" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4" placeholder="628123456789">
                    </div>

                    <hr class="my-10 border-black-300 border-4">

                    <div id="rentalForms">
                        <div class="rental-form mb-6">
                            <h6 class="text-xl font-medium mb-4">Rental 1</h6>
                            <div class="mb-6 flex items-center gap-6">
                                <label for="tgl_sewa" class="w-1/4 text-base font-medium text-gray-700">Tanggal Sewa</label>
                                <input type="date" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4 tgl_sewa" name="rentals[0][tgl_sewa]" required>
                            </div>

                            <div class="mb-6 flex items-center gap-6">
                                <label for="tgl_kembali" class="w-1/4 text-base font-medium text-gray-700">Tanggal Kembali</label>
                                <input type="date" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4 tgl_kembali" name="rentals[0][tgl_kembali]" required>
                            </div>

                            <label for="jenis_motor" class="block text-base font-medium text-gray-700">Pilih Jenis Motor</label>
                            <label for="jenis_motor" class="block text-base font-small text-sm text-red-700">(Motor yang ada dipilihan adalah motor yang sedang ready stok!)</label>
                            <div class="mb-6">
                                <div class="flex flex-wrap gap-6">
                                    @foreach($jenis_motors as $jenis_motor)
                                        <div class="kanban-item p-6 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-100" data-value="{{ $jenis_motor->id }}" data-price="{{ $jenis_motor->harga_perHari }}">
                                            <div class="text-lg font-medium">{{ $jenis_motor->merk }}</div>
                                            <div class="text-base text-gray-500">Rp. {{ number_format($jenis_motor->harga_perHari, 0, ',', '.') }}</div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" class="id_jenis" name="rentals[0][id_jenis]" required>
                            </div>

                            <div class="mb-6 flex items-center gap-6">
                                <label for="formatted_total" class="w-1/4 text-base font-medium text-gray-700">Harga per-unit</label>
                                <input type="text" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4 formatted_total" readonly>
                            </div>

                            <input type="hidden" class="total" name="rentals[0][total]">
                        </div>
                    </div>

                    <button type="button" id="addRental" class="inline-flex items-center px-4 py-2 border border-transparent text-md font-medium rounded-md text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-4">Add Another Rental</button>
                    <div id="error-message" class="text-red-600 mb-6"></div>

                    <div class="mb-6 flex items-center gap-6">
                        <label for="grand_total" class="w-1/4 text-base font-medium text-gray-700">Total Keseluruhan</label>
                        <input type="text" id="grand_total" class="w-3/4 mt-1 block border-2 border-gray-400 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:text-lg py-3 px-4" readonly>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-md font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('rental.script');
@endsection
