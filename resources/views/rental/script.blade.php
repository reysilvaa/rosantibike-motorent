<script>
document.addEventListener('DOMContentLoaded', function() {
    const rentalForms = document.getElementById('rentalForms');
    const addRentalBtn = document.getElementById('addRental');
    const errorMessageDiv = document.getElementById('error-message');
    const grandTotalInput = document.getElementById('grand_total');
    let rentalCount = 1;
    let selectedMotors = {};
    let bookedMotors = {};

    function initializeMotorStatus() {
        document.querySelectorAll('.rental-form').forEach(form => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                const motorId = item.getAttribute('data-value');
                const availableStock = parseInt(item.getAttribute('data-stock'));
                selectedMotors[motorId] = selectedMotors[motorId] || 0;

                updateMotorItemStatus(item, availableStock, selectedMotors[motorId]);
            });
        });
    }

    function updateMotorItemStatus(item, availableStock, selectedCount) {
        const motorId = item.getAttribute('data-value');
        const isBooked = bookedMotors[motorId];

        if (availableStock === 0 || isBooked) {
            item.classList.add('opacity-50', 'cursor-not-allowed');
            item.classList.remove('hover:bg-blue-300');

            let statusText = item.querySelector('.status-text');
            if (!statusText) {
                statusText = document.createElement('div');
                statusText.classList.add('status-text', 'font-bold', 'mt-2', 'text-sm');
                item.appendChild(statusText);
            }

            if (isBooked) {
                statusText.textContent = '🔒 Sudah Dibooking';
                statusText.classList.add('text-yellow-600');
            } else {
                statusText.textContent = '⚠️ Stok Habis';
                statusText.classList.add('text-red-600');
            }
        } else {
            item.classList.remove('opacity-50', 'cursor-not-allowed');
            item.classList.add('hover:bg-blue-300');
            item.querySelector('.status-text')?.remove();
        }

        const stockCountElement = item.querySelector('.stock-count');
        if (stockCountElement) {
            stockCountElement.textContent = `Tersedia: ${availableStock - selectedCount}`;
        }
    }

    function hitungTotal(rentalForm) {
        const tglSewaInput = rentalForm.querySelector('.tgl_sewa');
        const tglKembaliInput = rentalForm.querySelector('.tgl_kembali');
        const hargaPerHari = parseFloat(rentalForm.querySelector('.id_jenis').dataset.price);
        const formattedTotal = rentalForm.querySelector('.formatted_total');
        const totalInput = rentalForm.querySelector('.total');

        const tglSewa = new Date(tglSewaInput.value);
        const tglKembali = new Date(tglKembaliInput.value);

        if (isNaN(tglSewa.getTime()) || isNaN(tglKembali.getTime()) || isNaN(hargaPerHari)) {
            errorMessageDiv.innerHTML = '<span class="text-red-600">⚠️ Mohon isi semua form dengan benar.</span>';
            formattedTotal.value = '';
            totalInput.value = '';
            return 0;
        }

        if (tglSewa < new Date() && tglSewa.toDateString() !== new Date().toDateString()) {
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Sewa Tidak Valid',
                text: '⚠️ Tanggal sewa tidak boleh kurang dari tanggal hari ini.',
                confirmButtonText: 'Ok',
                customClass: {
                    confirmButton: 'bg-red-600 text-white'
                }
            });
            resetSelections();
            formattedTotal.value = '';
            totalInput.value = '';
            return 0;
        }

        if (tglKembali < tglSewa) {
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Kembali Tidak Valid',
                text: '⚠️ Tanggal kembali tidak boleh kurang dari tanggal sewa.',
                confirmButtonText: 'Ok',
                customClass: {
                    confirmButton: 'bg-red-600 text-white'
                }
            });
            resetSelections();
            formattedTotal.value = '';
            totalInput.value = '';
            return 0;
        }


        const diffTime = Math.abs(tglKembali - tglSewa);
        const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
        const total = diffDays * hargaPerHari;

        formattedTotal.value = `Rp. ${total.toLocaleString('id-ID')}`;
        totalInput.value = total;

        return total;
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.rental-form').forEach(form => {
            grandTotal += hitungTotal(form);
        });
        grandTotalInput.value = `Rp. ${grandTotal.toLocaleString('id-ID')}`;
    }

    function cekTanggalBooking(tglSewa, tglKembali, idJenis) {
        return fetch(`/booking/check-booking-dates?tgl_sewa=${tglSewa}&tgl_kembali=${tglKembali}&id_jenis=${idJenis}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data && typeof data.isBooked !== 'undefined') {
                    return data.isBooked;
                } else {
                    console.error('Respons tidak memiliki properti isBooked yang diharapkan:', data);
                    return false;
                }
            })
            .catch(error => {
                console.error('Error dalam cekTanggalBooking:', error);
                return false;
            });
    }

    async function updateDateCheck(rentalForm) {
        const tglSewaInput = rentalForm.querySelector('.tgl_sewa');
        const tglKembaliInput = rentalForm.querySelector('.tgl_kembali');
        const idJenisInput = rentalForm.querySelector('.id_jenis');

        if (tglSewaInput.value && tglKembaliInput.value && idJenisInput.value) {
            const isBooked = await cekTanggalBooking(tglSewaInput.value, tglKembaliInput.value, idJenisInput.value);

            if (isBooked) {
                resetSelections();
                Swal.fire({
                    icon: 'info',
                    title: 'Motor Sudah Dibooking',
                    text: '🔒 Motor ini sudah dibooking untuk tanggal yang dipilih.',
                    confirmButtonText: 'Ok',
                    customClass: {
                        confirmButton: 'bg-indigo-600 text-white'
                    }
                });
                tglKembaliInput.classList.add('border-yellow-500');
                bookedMotors[idJenisInput.value] = true;
            } else {
                errorMessageDiv.textContent = '';
                tglKembaliInput.classList.remove('border-yellow-500');
                bookedMotors[idJenisInput.value] = false;
            }

            updateMotorSelectionStatus();
            updateGrandTotal();

            // Fetch and update available stock
            fetch(`/booking/get-available-stock?id_jenis=${idJenisInput.value}&tgl_sewa=${tglSewaInput.value}&tgl_kembali=${tglKembaliInput.value}`)
                .then(response => response.json())
                .then(data => {
                    const stockElement = rentalForm.querySelector(`.kanban-item[data-value="${idJenisInput.value}"] .stock-count`);
                    if (stockElement) {
                        stockElement.textContent = `Tersedia: ${data.available_stock}`;
                    }
                })
                .catch(error => console.error('Error fetching available stock:', error));
        }
    }

    function addEventListeners(rentalForm) {
        const tglSewaInput = rentalForm.querySelector('.tgl_sewa');
        const tglKembaliInput = rentalForm.querySelector('.tgl_kembali');
        const idJenisInput = rentalForm.querySelector('.id_jenis');

        tglSewaInput.addEventListener('change', () => updateDateCheck(rentalForm));
        tglKembaliInput.addEventListener('change', () => updateDateCheck(rentalForm));
        idJenisInput.addEventListener('change', () => updateDateCheck(rentalForm));
    }

    function updateMotorSelectionStatus() {
        document.querySelectorAll('.rental-form').forEach(form => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                const motorId = item.getAttribute('data-value');
                const availableStock = parseInt(item.getAttribute('data-stock'));
                const selectedCount = selectedMotors[motorId] || 0;

                updateMotorItemStatus(item, availableStock, selectedCount);
            });
        });
    }

    let selectedIdJenis = new Set();
    function addKanbanSelectListeners() {
        document.querySelectorAll('.rental-form').forEach((form, formIndex) => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                item.addEventListener('click', function() {
                    if (this.classList.contains('cursor-not-allowed')) {
                        return; // Prevent selection of disabled items
                    }

                    const motorId = this.getAttribute('data-value');
                    const availableStock = parseInt(this.getAttribute('data-stock'));
                    const allIds = JSON.parse(this.getAttribute('data-all-ids'));
                    const selectedCount = selectedMotors[motorId] || 0;

                    if (selectedCount >= availableStock && !this.classList.contains('selected')) {
                        resetSelections();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stok Habis',
                            text: '⚠️ Maaf, stok motor ini sudah habis.',
                            confirmButtonText: 'Ok',
                            customClass: {
                                confirmButton: 'bg-indigo-600 text-white'
                            }
                        });
                        return;
                    }


                    form.querySelectorAll('.kanban-item').forEach(i => {
                        if (i.classList.contains('selected')) {
                            const prevMotorId = i.getAttribute('data-value');
                            selectedMotors[prevMotorId]--;
                            selectedIdJenis.delete(parseInt(form.querySelector('.id_jenis').value));
                        }
                        i.classList.remove('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
                        i.classList.add('bg-gray-100', 'border-gray-200');
                        i.querySelector('.selected-text')?.remove();
                    });

                    this.classList.add('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
                    this.classList.remove('bg-gray-100', 'border-gray-200');

                    const availableIds = allIds.filter(id => !selectedIdJenis.has(id) && !bookedMotors[id]);
                    if (availableIds.length === 0) {
                        resetSelections();
                        Swal.fire({
                            icon: 'info',
                            title: 'Motor Tidak Tersedia',
                            text: '⚠️ Tidak ada motor tersedia untuk jenis ini saat ini.',
                            confirmButtonText: 'Ok',
                            customClass: {
                                confirmButton: 'bg-indigo-600 text-white'
                            }
                        });
                        return;
                    }

                    const selectedId = availableIds[Math.floor(Math.random() * availableIds.length)];
                    selectedIdJenis.add(selectedId);
                    form.querySelector('.id_jenis').value = selectedId;
                    form.querySelector('.id_jenis').dataset.price = this.getAttribute('data-price');

                    selectedMotors[motorId] = (selectedMotors[motorId] || 0) + 1;

                    const selectedText = document.createElement('div');
                    selectedText.innerHTML = '✅ Motor Terpilih!';
                    selectedText.classList.add('selected-text', 'text-green-600', 'font-bold', 'mt-2', 'text-sm');
                    this.appendChild(selectedText);

                    errorMessageDiv.textContent = '';
                    updateDateCheck(form);
                    updateMotorSelectionStatus();
                });
            });
        });
    }

    function resetSelections() {
        selectedIdJenis.clear();
        selectedMotors = {};
        bookedMotors = {};
        document.querySelectorAll('.rental-form').forEach(form => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                item.classList.remove('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
                item.classList.add('bg-gray-100', 'border-gray-200');
                item.querySelector('.selected-text')?.remove();
                item.querySelector('.status-text')?.remove();
            });
            form.querySelector('.id_jenis').value = '';
        });
        updateMotorSelectionStatus();
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
        newRentalForm.querySelectorAll('.kanban-item').forEach(item => {
            item.classList.remove('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
            item.classList.add('bg-gray-100', 'border-gray-200');
            item.querySelector('.selected-text')?.remove();
            item.querySelector('.status-text')?.remove();
        });
        rentalForms.appendChild(newRentalForm);
        addEventListeners(newRentalForm);
        addKanbanSelectListeners();
        updateMotorSelectionStatus();
    });

    addKanbanSelectListeners();
    addEventListeners(rentalForms.children[0]);
    initializeMotorStatus();
    updateGrandTotal();

    document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let isValid = true;

    // Periksa setiap rental form untuk melihat apakah motor sudah dipilih
    document.querySelectorAll('.rental-form').forEach(form => {
        if (!form.querySelector('.kanban-item.selected')) {
            isValid = false;
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Motor',
                text: '⚠️ Mohon pilih motor untuk setiap rental.',
                confirmButtonText: 'Ok',
                customClass: {
                    confirmButton: 'bg-indigo-600 text-white'
                }
            });
        }
    });

    document.querySelectorAll('.rental-form').forEach(form => {
        const tglSewaInput = form.querySelector('.tgl_sewa');
        const tglKembaliInput = form.querySelector('.tgl_kembali');
        const tglSewa = new Date(tglSewaInput.value);
        const tglKembali = new Date(tglKembaliInput.value);

        if (tglSewa < new Date() && tglSewa.toDateString() !== new Date().toDateString()) {
            isValid = false;
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Sewa Tidak Valid',
                text: '⚠️ Tanggal sewa tidak boleh kurang dari tanggal hari ini.',
                confirmButtonText: 'Ok'
            });
        }

        if (tglKembali < tglSewa) {
            isValid = false;
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Kembali Tidak Valid',
                text: '⚠️ Tanggal kembali tidak boleh kurang dari tanggal sewa.',
                confirmButtonText: 'Ok',
                customClass: {
                    confirmButton: 'bg-indigo-600 text-white'
                }
            });
        }
    });
        // Periksa apakah terdapat motor yang sudah dibooking pada tanggal tersebut
        document.querySelectorAll('.rental-form').forEach(form => {
            const idJenisInput = form.querySelector('.id_jenis');
            const motorId = idJenisInput.value;

            if (bookedMotors[motorId]) {
                isValid = false;
                resetSelections();
                Swal.fire({
                    icon: 'info',
                    title: 'Motor Sudah Dibooking',
                    text: '🔒 Motor ini sudah dibooking untuk tanggal yang dipilih.',
                    confirmButtonText: 'Ok'
                });
            }
        });

        // Jika validasi gagal, tampilkan pesan kesalahan dan jangan kirim form
        if (!isValid) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Formulir tidak valid. Mohon periksa kembali data yang Anda masukkan.',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-red-600 text-white'
                }
            });
            return; // Mencegah pengiriman form jika tidak valid
        }

        // Jika semua validasi berhasil, kirim form
        Swal.fire({
            title: 'Berhasil!',
            text: 'Formulir berhasil dikirimkan.',
            icon: 'success',
            confirmButtonText: 'Siap',
            customClass: {
                confirmButton: 'bg-indigo-600 text-white'
            }
        }).then(() => {
            this.submit();
        });
    });
});
</script>
<style>
    .bg-indigo-600 {
        background-color: #4f46e5;
    }

    .text-white {
        color: #ffffff;
    }
</style>
