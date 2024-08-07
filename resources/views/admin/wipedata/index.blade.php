@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Hapus Data</h1>

    <!-- Formulir Konfirmasi -->
    <form id="wipeForm" action="{{ route('admin.wipe.wipe') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Kartu Stok Merk Motor -->

            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Merk Motor</h2>
                    <p class="text-gray-600 mb-2">Hapus semua catatan terkait Merk Motor (ini juga menghapus data dari jenis motor).</p>
                    <input type="checkbox" name="models[]" value="stok" id="stok" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="stok" class="ml-2 text-gray-700">Pilih untuk menghapus</label>
                </div>
            </div>

            <!-- Kartu Jenis Motor -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Jenis Motor</h2>
                    <p class="text-gray-600 mb-2">Hapus semua catatan terkait Jenis Motor.</p>
                    <input type="checkbox" name="models[]" value="jenis_motor" id="jenis_motor" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="jenis_motor" class="ml-2 text-gray-700">Pilih untuk menghapus</label>
                </div>
            </div>

            <!-- Kartu Transaksi -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Transaksi</h2>
                    <p class="text-gray-600 mb-2">Hapus semua catatan terkait Transaksi.</p>
                    <input type="checkbox" name="models[]" value="transaksi" id="transaksi" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="transaksi" class="ml-2 text-gray-700">Pilih untuk menghapus</label>
                </div>
            </div>

            <!-- Kartu Booking -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Booking</h2>
                    <p class="text-gray-600 mb-2">Hapus semua catatan terkait Booking.</p>
                    <input type="checkbox" name="models[]" value="booking" id="booking" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="booking" class="ml-2 text-gray-700">Pilih untuk menghapus</label>
                </div>
            </div>

            <!-- Kartu Galeri -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Galeri</h2>
                    <p class="text-gray-600 mb-2">Hapus semua catatan terkait Galeri.</p>
                    <input type="checkbox" name="models[]" value="galeri" id="galeri" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="galeri" class="ml-2 text-gray-700">Pilih untuk menghapus</label>
                </div>
            </div>

            <!-- Kartu Rating -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Rating</h2>
                    <p class="text-gray-600 mb-2">Hapus semua catatan terkait Rating.</p>
                    <input type="checkbox" name="models[]" value="rating" id="rating" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="rating" class="ml-2 text-gray-700">Pilih untuk menghapus</label>
                </div>
            </div>
        </div>

        <button type="submit" id="submitButton" class="w-full mt-6 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
            Hapus Data Terpilih
        </button>
    </form>

    <x-back-to-list-button route="{{ route('dashboard') }}" />
</div>
@endsection

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submitButton').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah form dari dikirim langsung
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Ini akan menghapus catatan yang dipilih secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4c51bf',  // Warna indigo-600
            cancelButtonColor: '#38a169',  // Warna hijau
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('wipeForm').submit(); // Mengirim form jika konfirmasi berhasil
            }
        });
    });
});
</script>
@endpush
