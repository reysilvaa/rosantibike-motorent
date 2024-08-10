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
        <div class="bg-white shadow-md rounded-lg border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h5 class="text-2xl font-semibold">Formulir Booking</h5>
            </div>
            <div class="p-6">
                <form action="{{ route('transaksi.store') }}" method="POST" id="bookingForm" x-data="{ canAgree: false }">
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
                                <label for="tgl_sewa" class="w-1/3 text-sm font-medium text-gray-700">Tanggal dan Jam Sewa</label>
                                <input type="datetime-local" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 tgl_sewa" name="rentals[0][tgl_sewa]" required>
                            </div>

                            <div class="mb-4 flex items-center gap-4">
                                <label for="tgl_kembali" class="w-1/3 text-sm font-medium text-gray-700">Tanggal dan Jam Kembali</label>
                                <input type="datetime-local" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 tgl_kembali" name="rentals[0][tgl_kembali]" required>
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

                    <button type="button" id="addRental" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-4">
                        Tambahkan Booking
                    </button>

                    <div id="error-message" class="text-red-600 mb-4 text-sm"></div>

                    <div class="mb-4 flex items-center gap-4">
                        <label for="grand_total" class="w-1/3 text-sm font-medium text-gray-700">Total Keseluruhan</label>
                        <input type="text" id="grand_total" class="w-2/3 mt-1 block border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3" readonly>
                    </div>

                    <div x-data="{
                        canAgree: false,
                        checkScroll(event) {
                            const container = event.target;
                            this.canAgree = container.scrollHeight - container.scrollTop <= container.clientHeight + 1;
                        }
                    }">
                    <div class="mb-6">
                        <h6 class="text-2xl font-semibold mb-4 text-gray-900">Syarat dan Ketentuan</h6>
                        <div class="border border-gray-200 rounded-lg shadow-md p-6 h-72 overflow-y-auto bg-white"
                             x-on:scroll="checkScroll($event)"
                             x-ref="termsContainer">
                             <div class="prose prose-sm text-gray-800 mx-auto max-w-2xl">
                                <h3 class="text-xl font-bold mt-4 mb-2 border-b border-gray-300 pb-2">Syarat Jaminan</h3>
                                <ol class="list-decimal list-inside space-y-2 custom-font">
                                    <li class="leading-6">Penyewa harus menyertakan E-KTP (Wajib) + Identitas lain yang mendukung.</li>
                                    <li class="leading-6">Apabila Penyewa berboncengan harus menyertakan E-KTP (Wajib) + Identitas lain yang mendukung (Teman Boncengan).</li>
                                    <li class="leading-6">Identitas Penyewa akan ditahan hingga pengembalian motor.</li>
                                </ol>

                                <h3 class="text-xl font-bold mt-8 mb-2 border-b border-gray-300 pb-2">Ketentuan Penyewa</h3>
                                <ol class="list-decimal list-inside space-y-2 custom-font">
                                    <li class="leading-6">Penyewa harus berusia minimal 18 tahun dan memiliki SIM yang masih berlaku.</li>
                                    <li class="leading-6">Penyewa bertanggung jawab penuh atas kerusakan atau kehilangan motor selama masa sewa.</li>
                                    <li class="leading-6">Keterlambatan pengembalian akan dikenakan denda Rp. 15.000 / jam.</li>
                                    <li class="leading-6">Dilarang keras menggunakan motor untuk kegiatan ilegal atau yang melanggar hukum.</li>
                                    <li class="leading-6">Motor harus dikembalikan dalam kondisi yang sama seperti saat dipinjam.</li>
                                    <li class="leading-6">Penyewa wajib menggunakan helm dan mematuhi peraturan lalu lintas yang berlaku.</li>
                                    <li class="leading-6">Penyewa wajib melaporkan segera jika terjadi kecelakaan atau kerusakan pada motor.</li>
                                </ol>

                                <h3 class="text-xl font-bold mt-8 mb-2 border-b border-gray-300 pb-2">Ketentuan Lain</h3>
                                <ol class="list-decimal list-inside space-y-2 custom-font">
                                    <li class="leading-6">Biaya sewa tidak termasuk biaya bahan bakar / bensin.</li>
                                    <li class="leading-6">Bersedia di foto dengan unit motor yang akan disewa.</li>
                                </ol>
                                <p class="leading-6 text-sm font-mono mt-4">
                                    Dengan menyetujui syarat dan ketentuan ini, penyewa membebaskan pihak penyewa dari segala tuntutan hukum yang mungkin timbul selama masa penyewaan.
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="mb-6 flex items-center gap-3">
                        <input type="checkbox" id="agreement" name="agreement" required
                               class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                               x-bind:disabled="!canAgree">
                        <label for="agreement" class="text-sm font-medium text-gray-700"
                               x-bind:class="{ 'opacity-50': !canAgree }">
                            Saya telah membaca dan menyetujui semua syarat dan ketentuan yang berlaku.
                        </label>
                    </div>

                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            x-bind:disabled="!canAgree">
                        Submit Booking
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('rental.script')
<style>
    .list-decimal {
        list-style-type: decimal;
    }
    .custom-font {
        font-family: 'Courier New', Courier, monospace;
        font-size: 13px;
    }
</style>
@endsection
