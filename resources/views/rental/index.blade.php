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
                    <form action="{{ route('transaksi.store') }}" method="POST" id="bookingForm">
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

                        <div id="rentalForms">
                            <div class="rental-form mb-4">
                                <h6>Rental 1</h6>
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="date" class="form-control tgl_sewa" name="rentals[0][tgl_sewa]" required>
                                    <label>Tanggal Sewa</label>
                                </div>

                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="date" class="form-control tgl_kembali" name="rentals[0][tgl_kembali]" required>
                                    <label>Tanggal Kembali</label>
                                </div>

                                <label for="jenis_motor">Pilih Jenis Motor</label>
                                <div class="form-floating form-floating-outline mb-3">
                                    <div class="kanban-board">
                                        @foreach($jenis_motors as $jenis_motor)
                                            <div class="kanban-item" data-value="{{ $jenis_motor->id }}" data-price="{{ $jenis_motor->harga_perHari }}">
                                                <div class="kanban-item-title">{{ $jenis_motor->merk }}</div>
                                                <div class="kanban-item-price">Rp. {{ number_format($jenis_motor->harga_perHari, 0, ',', '.') }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" class="id_jenis" name="rentals[0][id_jenis]" required>
                                </div>

                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" class="form-control formatted_total" readonly>
                                    <label>Harga per-unit</label>
                                </div>
                                <input type="hidden" class="total" name="rentals[0][total]">
                            </div>
                        </div>

                        <button type="button" id="addRental" class="btn btn-secondary mb-3">Add Another Rental</button>

                        <div id="error-message" class="text-danger mb-4"></div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" id="grand_total" class="form-control" readonly>
                            <label for="grand_total">Total Keseluruhan</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .kanban-board {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: flex-start;
        padding: 10px 0;
    }

    .kanban-item {
        flex: 0 0 calc(50% - 7.5px);
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-sizing: border-box;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }

    .kanban-item:hover {
        background-color: #f1f1f1;
        transform: translateY(-2px);
    }

    .kanban-item.selected {
        background-color: #007bff;
        color: white;
    }

    .kanban-item-title {
        font-weight: bold;
        margin-bottom: 8px;
        font-size: 1.1em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .kanban-item-price {
        font-size: 1em;
    }

    @media (min-width: 768px) {
        .kanban-board {
            flex-wrap: wrap;
            overflow-x: hidden;
        }

        .kanban-item {
            flex: 0 0 calc(50% - 7.5px);
            max-width: calc(50% - 7.5px);
        }
    }

    @media (min-width: 1200px) {
        .kanban-board {
            justify-content: center;
        }

        .kanban-item {
            flex: 0 0 calc(33.333% - 10px);
            max-width: calc(33.333% - 10px);
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            setupKanbanSelect();
        });

        function setupKanbanSelect() {
            const kanbanBoards = document.querySelectorAll('.kanban-board');

            kanbanBoards.forEach(board => {
                const items = board.querySelectorAll('.kanban-item');
                const hiddenInput = board.nextElementSibling;

                items.forEach(item => {
                    item.addEventListener('click', function() {
                        items.forEach(i => i.classList.remove('selected'));
                        this.classList.add('selected');
                        hiddenInput.value = this.getAttribute('data-value');
                        hiddenInput.dataset.price = this.getAttribute('data-price');
                        updateGrandTotal();
                    });
                });
            });
        }

        setupKanbanSelect();
        addEventListeners(rentalForms.children[0]);
    });
</script>
@endsection
