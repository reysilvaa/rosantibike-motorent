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

<script>
 document.addEventListener('DOMContentLoaded', function() {
    addKanbanSelectListeners(); // Ensure initial kanban items are clickable
    const rentalForms = document.getElementById('rentalForms');
    const addRentalBtn = document.getElementById('addRental');
    const errorMessageDiv = document.getElementById('error-message');
    const grandTotalInput = document.getElementById('grand_total');
    let rentalCount = 1;

    function calculateTotal(rentalForm) {
        const tglSewaInput = rentalForm.querySelector('.tgl_sewa');
        const tglKembaliInput = rentalForm.querySelector('.tgl_kembali');
        const hargaPerHari = rentalForm.querySelector('.id_jenis').dataset.price;
        const formattedTotal = rentalForm.querySelector('.formatted_total');
        const totalInput = rentalForm.querySelector('.total');

        const tglSewa = new Date(tglSewaInput.value);
        const tglKembali = new Date(tglKembaliInput.value);

        if (isNaN(tglSewa.getTime()) || isNaN(tglKembali.getTime()) || !hargaPerHari) {
            errorMessageDiv.textContent = 'Please fill in all required fields correctly.';
            formattedTotal.value = '';
            totalInput.value = '';
            return 0;
        }

        if (tglSewa < new Date() && tglSewa.toDateString() !== new Date().toDateString()) {
            errorMessageDiv.textContent = 'Tanggal Sewa tidak boleh kurang dari tanggal hari ini.';
            formattedTotal.value = '';
            totalInput.value = '';
            return 0;
        }

        if (tglKembali < tglSewa) {
            errorMessageDiv.textContent = 'Tanggal Kembali tidak boleh kurang dari Tanggal Sewa.';
            formattedTotal.value = '';
            totalInput.value = '';
            return 0;
        }

        const diffTime = Math.abs(tglKembali - tglSewa);
        const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
        const total = diffDays * hargaPerHari;

        formattedTotal.value = `Rp. ${total.toLocaleString('id-ID')}`;
        totalInput.value = total;
        errorMessageDiv.textContent = '';

        return total;
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.rental-form').forEach(form => {
            grandTotal += calculateTotal(form);
        });
        grandTotalInput.value = `Rp. ${grandTotal.toLocaleString('id-ID')}`;
    }

    function addEventListeners(rentalForm) {
        rentalForm.querySelector('.tgl_sewa').addEventListener('change', updateGrandTotal);
        rentalForm.querySelector('.tgl_kembali').addEventListener('change', updateGrandTotal);
        rentalForm.querySelector('.kanban-item').addEventListener('click', updateGrandTotal);
    }
    function addKanbanSelectListeners() {
        document.querySelectorAll('.kanban-item').forEach(item => {
            item.addEventListener('click', function() {
                const parentForm = this.closest('.rental-form');

                // Remove selection from all items in the current form
                parentForm.querySelectorAll('.kanban-item').forEach(i => {
                    i.classList.remove('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100');
                    i.classList.add('bg-gray-100', 'border-gray-200'); // Default unselected style
                });

                // Add selection to the clicked item
                this.classList.add('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100');
                this.classList.remove('bg-gray-100', 'border-gray-200');
                parentForm.querySelector('.id_jenis').value = this.getAttribute('data-value');
                parentForm.querySelector('.id_jenis').dataset.price = this.getAttribute('data-price');

                // Update grand total after selection
                updateGrandTotal();
            });
        });
    }


    addRentalBtn.addEventListener('click', function() {
        const newRentalForm = rentalForms.children[0].cloneNode(true);
        rentalCount++;
        newRentalForm.querySelector('h6').textContent = `Rental ${rentalCount}`;
        const inputs = newRentalForm.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.name = input.name.replace('[0]', `[${rentalCount - 1}]`);
            if (input.type !== 'hidden') {
                input.value = '';
            }
        });
        rentalForms.appendChild(newRentalForm);
        addEventListeners(newRentalForm);
        addKanbanSelectListeners(); // Ensure new kanban items are clickable
    });

    addKanbanSelectListeners(); // Ensure initial kanban items are clickable
    addEventListeners(rentalForms.children[0]); // Ensure initial form has listeners
});

</script>
@endsection
