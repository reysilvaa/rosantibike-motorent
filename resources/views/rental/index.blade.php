@extends('layouts.admin')
@if (!Auth::check())
    @include('landing.assets.navbar')
@endif

@section('title', 'Form/Booking')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Booking Form</h1>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800">Formulir Booking</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('transaksi.store') }}" method="POST" id="bookingForm" x-data="{ canAgree: false }">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_penyewa" class="block text-sm font-medium text-gray-700 mb-1">Nama Penyewa</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" id="nama_penyewa" name="nama_penyewa" placeholder="RosantiBike" required>
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Domisili</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" id="alamat" name="alamat" placeholder="Rosanti Homestay, Jl RosantiBike No 90 Malang" required>
                            </div>

                            <div>
                                <label for="wa1" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp 1</label>
                                <input type="tel" id="wa1" name="wa1" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="628123456789 (Saya sendiri)" required>
                            </div>

                            <div>
                                <label for="wa2" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp 2</label>
                                <input type="tel" id="wa2" name="wa2" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="628123456789 (Mbak Rosantibike)" required>
                            </div>

                            <div>
                                <label for="wa3" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp 3</label>
                                <input type="tel" id="wa3" name="wa3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="628123456789 (Mas Motorent)" required>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200">

                        <div id="rentalForms">
                            <div class="rental-form mb-8">
                                <h3 class="text-xl font-semibold mb-4 text-gray-800">Rental 1</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="tgl_sewa" class="block text-sm font-medium text-gray-700 mb-1">Tanggal dan Jam Sewa</label>
                                        <input type="datetime-local" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 tgl_sewa" name="rentals[0][tgl_sewa]" required>
                                        <small class="text-gray-500">Masukkan tanggal dan jam mulai penyewaan. Tanggal ini tidak boleh kurang dari hari ini.</small>
                                    </div>

                                    <div>
                                        <label for="tgl_kembali" class="block text-sm font-medium text-gray-700 mb-1">Tanggal dan Jam Kembali</label>
                                        <input type="datetime-local" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 tgl_kembali" name="rentals[0][tgl_kembali]" required>
                                        <small class="text-gray-500">Masukkan tanggal dan jam akhir penyewaan. Harus sama atau setelah tanggal sewa.</small>
                                    </div>

                                    <div>
                                        <label for="helm" class="block text-sm font-medium text-gray-700 mb-1">Helm</label>
                                        <input type="number" id="helm" name="rentals[0][helm]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="2" required>
                                        <small class="text-gray-500">Jumlah helm yang ingin disewa. Isi 0 jika tidak diperlukan.</small>
                                    </div>

                                    <div>
                                        <label for="jashujan" class="block text-sm font-medium text-gray-700 mb-1">Jas Hujan</label>
                                        <input type="number" id="jashujan" name="rentals[0][jashujan]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="2" required>
                                        <small class="text-gray-500">Jumlah jas hujan yang ingin disewa. Isi 0 jika tidak diperlukan.</small>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label for="jenis_motor" class="block text-lg font-semibold text-gray-800 mb-2">Pilih Jenis Motor</label>
                                    <p class="text-sm text-red-600 mb-4">(Pastikan pilihan anda dengan benar!)</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                        @foreach($jenis_motors as $jenis_motor)
                                        <div class="kanban-item border border-gray-200 rounded-lg cursor-pointer bg-white hover:shadow-lg transition-all duration-300 ease-in-out flex flex-col justify-between overflow-hidden relative group"
                                             data-value="{{ $jenis_motor->id }}"
                                             data-price="{{ $jenis_motor->stok->harga_perHari }}"
                                             data-stock="{{ $jenis_motor->available_stock }}"
                                             data-all-ids="{{ $jenis_motor->all_ids }}">
                                            <div class="aspect-w-16 aspect-h-9">
                                                <img src="{{ $jenis_motor->stok->foto ? (filter_var($jenis_motor->stok->foto, FILTER_VALIDATE_URL) ? $jenis_motor->stok->foto : asset('storage/' . $jenis_motor->stok->foto)) : 'https://via.placeholder.com/300x200' }}"
                                                     alt="{{ $jenis_motor->stok->merk ?: 'Motor Image' }}"
                                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" loading="lazy">
                                            </div>
                                            <div class="p-3 bg-white">
                                                <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $jenis_motor->stok->merk }}</h3>
                                                <p class="text-lg font-bold text-indigo-600 mt-1">Rp. {{ number_format($jenis_motor->stok->harga_perHari, 0, ',', '.') }}</p>
                                                <p class="text-xs text-gray-500 mt-1">Stok: <span class="stock-count font-medium">{{ $jenis_motor->available_stock }}</span></p>
                                            </div>
                                            <div class="selected-indicator absolute top-2 right-2 bg-green-500 text-white rounded-full p-1 hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" class="id_jenis" name="rentals[0][id_jenis]" required>
                                    <p class="selected-text text-green-600 font-bold mt-4 text-sm hidden"></p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                    <div>
                                        <label for="lama_sewa" class="block text-sm font-medium text-gray-700 mb-1">Lama Sewa</label>
                                        <div id="lama_sewa" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                            0 hari 0 jam
                                        </div>
                                    </div>

                                    <div>
                                        <label for="keterlambatan" class="block text-sm font-medium text-gray-700 mb-1">Keterlambatan</label>
                                        <div id="keterlambatan" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                            0 jam
                                        </div>
                                    </div>

                                    <div>
                                        <label for="formatted_total" class="block text-sm font-medium text-gray-700 mb-1">Harga per-unit</label>
                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 formatted_total" readonly>
                                    </div>
                                </div>

                                <input type="hidden" class="total" name="rentals[0][total]">
                            </div>
                        </div>

                        <button type="button" id="addRental" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-6">
                            Tambahkan Booking
                        </button>

                        <div id="error-message" class="text-red-600 mb-4 text-sm"></div>

                        <div class="mb-6">
                            <label for="grand_total" class="block text-sm font-medium text-gray-700 mb-1">Total Keseluruhan</label>
                            <input type="text" id="grand_total" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-lg font-semibold" readonly>
                            <small class="text-gray-500">Total keseluruhan mencakup biaya sewa dari seluruh unit yang akan disewa dan biaya denda jika ada.</small>
                        </div>

                        @include('rental.terms')

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .kanban-item {
        transition: all 0.3s ease;
    }
    .kanban-item:hover {
        transform: translateY(-3px);
    }
    .kanban-item.selected {
        background-color: #EEF2FF !important;
        border-color: #6366F1 !important;
    }
    .kanban-item.cursor-not-allowed {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .selected-text {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background-color: rgba(16, 185, 129, 0.9);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: bold;
    }
</style>
@include('rental.script')

@endsection
