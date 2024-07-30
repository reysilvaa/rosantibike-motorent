@extends('layouts.admin')
@if (!Auth::check())
    @include('landing.assets.navbar')
@endif

@section('title', 'Form/Booking')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mx-auto px-4 py-6">
    <div class="text-center mb-6">
        <p class="text-xl font-semibold">Booking Form</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Card Container -->
        <div class="bg-white shadow-md rounded-lg border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h5 class="text-2xl font-semibold">Formulir Booking</h5>
            </div>
            <div class="p-6"> <!-- Padding reduced for compact layout -->
                <form action="{{ route('transaksi.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <div class="mb-4 flex items-center gap-4">
                        <label for="nama_penyewa" class="w-1/3 text-sm font-medium text-gray-700">Nama Penyewa</label>
                        <input type="text" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" id="nama_penyewa" name="nama_penyewa" placeholder="RosantiBike" required>
                    </div>

                    <div class="mb-4 flex items-center gap-4">
                        <label for="wa1" class="w-1/3 text-sm font-medium text-gray-700">WhatsApp 1</label>
                        <input type="tel" id="wa1" name="wa1" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" placeholder="628123456789" required>
                    </div>

                    <div class="mb-4 flex items-center gap-4">
                        <label for="wa2" class="w-1/3 text-sm font-medium text-gray-700">WhatsApp 2 (Optional)</label>
                        <input type="tel" id="wa2" name="wa2" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" placeholder="628123456789">
                    </div>

                    <div class="mb-4 flex items-center gap-4">
                        <label for="wa3" class="w-1/3 text-sm font-medium text-gray-700">WhatsApp 3 (Optional)</label>
                        <input type="tel" id="wa3" name="wa3" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" placeholder="628123456789">
                    </div>

                    <hr class="my-8 border-black-300 border-2">

                    <div id="rentalForms">
                        <div class="rental-form mb-4">
                            <h6 class="text-lg font-medium mb-3">Rental 1</h6>
                            <div class="mb-4 flex items-center gap-4">
                                <label for="tgl_sewa" class="w-1/3 text-sm font-medium text-gray-700">Tanggal Sewa</label>
                                <input type="date" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 tgl_sewa" name="rentals[0][tgl_sewa]" required>
                            </div>

                            <div class="mb-4 flex items-center gap-4">
                                <label for="tgl_kembali" class="w-1/3 text-sm font-medium text-gray-700">Tanggal Kembali</label>
                                <input type="date" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 tgl_kembali" name="rentals[0][tgl_kembali]" required>
                            </div>
                            <div class="mb-4 flex items-center gap-4">
                                <label for="helm" class="w-1/3 text-sm font-medium text-gray-700">Helm </label>
                                <input type="number" id="helm" name="rentals[0][helm]" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" placeholder="2" required>
                            </div>
                            <div class="mb-4 flex items-center gap-4">
                                <label for="jashujan" class="w-1/3 text-sm font-medium text-gray-700">Jas Hujan </label>
                                <input type="number" id="jashujan" name="rentals[0][jashujan]" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" placeholder="2" required>
                            </div>


                            <label for="jenis_motor" class="block text-sm font-medium text-gray-700">Pilih Jenis Motor</label>
                            <label for="jenis_motor" class="block text-xs font-medium text-red-700">(Motor yang ada dipilihan adalah motor yang sedang dalam kondisi terbaik!)</label>
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-6">
                                    @foreach($jenis_motors as $jenis_motor)
                                    <div class="kanban-item p-4 border border-gray-300 rounded-lg cursor-pointer bg-gray-200 hover:bg-blue-300 transition-colors duration-150 ease-in-out w-48 flex flex-col justify-between"
                                         data-value="{{ $jenis_motor->id }}"
                                         data-price="{{ $jenis_motor->stok->harga_perHari }}"
                                         data-stock="{{ $jenis_motor->available_stock }}"
                                         data-all-ids="{{ $jenis_motor->all_ids }}">
                                        <img src="{{ $jenis_motor->stok->foto ? (filter_var($jenis_motor->stok->foto, FILTER_VALIDATE_URL) ? $jenis_motor->stok->foto : asset('storage/' . $jenis_motor->stok->foto)) : 'https://via.placeholder.com/300x200' }}"
                                             alt="{{ $jenis_motor->stok->merk ?: 'Motor Image' }}"
                                             class="w-full h-24 object-cover rounded-md mb-2" loading="lazy">
                                        <div class="text-sm font-medium">{{ $jenis_motor->stok->merk }}</div>
                                        <div class="text-sm text-gray-700">Rp. {{ number_format($jenis_motor->stok->harga_perHari, 0, ',', '.') }}</div>
                                        <div class="text-xs text-gray-600">Stock: <span class="stock-count">{{ $jenis_motor->available_stock }}</span></div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" class="id_jenis" name="rentals[0][id_jenis]" required>
                            </div>

                            <div class="mb-4 flex items-center gap-4">
                                <label for="formatted_total" class="w-1/3 text-sm font-medium text-gray-700">Harga per-unit</label>
                                <input type="text" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 formatted_total" readonly>
                            </div>

                            <input type="hidden" class="total" name="rentals[0][total]">
                        </div>
                    </div>

                    <button type="button" id="addRental" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-4">Add Another Rental</button>
                    {{-- <button type="button" id="removeRental" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-4" hidden>Remove Rental</button> --}}

                    <div id="error-message" class="text-red-600 mb-4 text-sm"></div>

                    <div class="mb-4 flex items-center gap-4">
                        <label for="grand_total" class="w-1/3 text-sm font-medium text-gray-700">Total Keseluruhan</label>
                        <input type="text" id="grand_total" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" readonly>
                    </div>
                    <div class="mb-6 flex items-center gap-3">
                        <input type="checkbox" id="agreement" name="agreement" required class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="agreement" class="text-sm font-medium text-gray-700">
                            Saya Setuju <a href="#" class="text-indigo-600 hover:text-indigo-500">dengan semua syarat dan aturan yang berlaku</a>.
                        </label>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('rental.script')
@endsection
