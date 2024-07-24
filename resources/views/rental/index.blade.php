@extends('layouts.admin')

@section('title', 'Form/Booking')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <div class="py-5 text-center">
            <p class="lead"></p>
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Formulir Booking</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transaksi.store') }}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="nama_penyewa" name="nama_penyewa" placeholder="John Doe" required>
                                <label for="nama_penyewa">Nama Penyewa</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="tel" id="wa1" name="wa1" class="form-control" placeholder="628123456789" required>
                                <label for="wa1">WhatsApp 1</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="tel" id="wa2" name="wa2" class="form-control" placeholder="628123456789">
                                <label for="wa2">WhatsApp 2 (Optional)</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="tel" id="wa3" name="wa3" class="form-control" placeholder="628123456789">
                                <label for="wa3">WhatsApp 3 (Optional)</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="date" id="tgl_sewa" name="tgl_sewa" class="form-control" required>
                                <label for="tgl_sewa">Tanggal Sewa</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="date" id="tgl_kembali" name="tgl_kembali" class="form-control" required>
                                <label for="tgl_kembali">Tanggal Kembali</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <select id="id_jenis" name="id_jenis" class="form-select" required>
                                    <option value="">Pilih Jenis Motor</option>
                                    @foreach($jenis_motors as $jenis_motor)
                                        <option value="{{ $jenis_motor->id }}" data-price="{{ $jenis_motor->harga_perHari }}">{{ $jenis_motor->merk }} (Rp. {{$jenis_motor->harga_perHari}})</option>
                                    @endforeach
                                </select>
                                <label for="id_jenis">Jenis Motor</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="formatted_total" name="formatted_total" class="form-control" readonly>
                                <label for="formatted_total">Total Harga</label>
                            </div>

                            <div id="error-message" class="text-danger mb-4"></div>
                            <input type="hidden" id="total" name="total">
                            <button type="submit" class="btn btn-primary">Submit Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tglSewaInput = document.getElementById('tgl_sewa');
        const tglKembaliInput = document.getElementById('tgl_kembali');
        const idJenisSelect = document.getElementById('id_jenis');
        const formattedTotal = document.getElementById('formatted_total');
        const totalInput = document.getElementById('total');
        const errorMessageDiv = document.getElementById('error-message');

        function calculateTotal() {
            const tglSewa = new Date(tglSewaInput.value);
            const tglKembali = new Date(tglKembaliInput.value);
            const hargaPerHari = idJenisSelect.options[idJenisSelect.selectedIndex]?.dataset.price;

            if (isNaN(tglSewa.getTime()) || isNaN(tglKembali.getTime()) || !hargaPerHari) {
                errorMessageDiv.textContent = 'Please fill in all required fields correctly.';
                formattedTotal.value = '';
                totalInput.value = '';  // Clear hidden field
                return;
            }

            if (tglSewa < new Date() && tglSewa.toDateString() !== new Date().toDateString()) {
                errorMessageDiv.textContent = 'Tanggal Sewa tidak boleh kurang dari tanggal hari ini.';
                formattedTotal.value = '';
                totalInput.value = '';  // Clear hidden field
                return;
            }

            if (tglKembali < tglSewa) {
                errorMessageDiv.textContent = 'Tanggal Kembali tidak boleh kurang dari Tanggal Sewa.';
                formattedTotal.value = '';
                totalInput.value = '';  // Clear hidden field
                return;
            }

            const diffTime = Math.abs(tglKembali - tglSewa);
            const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
            const total = diffDays * hargaPerHari;

            // Update the visible total input with formatted currency
            formattedTotal.value = `Rp. ${total.toLocaleString('id-ID')}`;
            // Store the numeric value in the hidden input
            totalInput.value = total;
            errorMessageDiv.textContent = '';  // Clear error message if all is well
        }

        tglSewaInput.addEventListener('change', calculateTotal);
        tglKembaliInput.addEventListener('change', calculateTotal);
        idJenisSelect.addEventListener('change', calculateTotal);
    });

    </script>
@endsection
