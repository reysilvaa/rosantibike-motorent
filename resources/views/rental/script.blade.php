<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.3/echo.iife.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rentalForms = document.getElementById('rentalForms');
    const addRentalBtn = document.getElementById('addRental');
    // const errorMessageDiv = document.getElementById('error-message');
    const grandTotalInput = document.getElementById('grand_total');
    let rentalCount = 1;
    let selectedMotors = {};
    let bookedMotors = {};

    // Initialize Echo for real-time updates
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    // Listen for rental updates
    Echo.channel('rentals')
        .listen('.rental.updated', (e) => {
            if (e.type === 'booking') {
                updateBookingStatus(e.rental);
            } else {
                updateTransactionStatus(e.rental);
            }
            updateMotorAvailability(e.rental.id_jenis);
        });

    const tglSewa = document.querySelector('.tgl_sewa');
    const tglKembali = document.querySelector('.tgl_kembali');
    const maxHours = 20;

    const showAlert = (message) => {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: message,
            confirmButtonText: 'Ok',
            customClass: {
                confirmButton: 'bg-red-600 text-white'
            }
        });
    };

    const checkMaxTime = (input, message) => {
        const selectedDate = new Date(input.value);
        if (selectedDate.getHours() >= maxHours && selectedDate.getMinutes() > 0) {
            showAlert(message);
            input.value = '';
        }
    };

    tglSewa.addEventListener('input', () => {
        checkMaxTime(tglSewa, "Waktu Sewa tidak boleh lebih dari jam 20:00.");
    });

    tglKembali.addEventListener('input', () => {
        checkMaxTime(tglKembali, "Waktu Kembali tidak boleh lebih dari jam 20:00.");
    });

    // Function to update booking status in UI
    function updateBookingStatus(rental) {
        const motorItems = document.querySelectorAll(`.kanban-item[data-value="${rental.id_jenis}"]`);
        motorItems.forEach(item => {
            const availableStock = parseInt(item.getAttribute('data-stock'));
            updateMotorItemStatus(item, availableStock - 1, selectedMotors[rental.id_jenis] || 0);
            bookedMotors[rental.id_jenis] = true;
        });
        updateMotorSelectionStatus();
    }

    // Function to update transaction status in UI
    function updateTransactionStatus(transaction) {
        const motorItems = document.querySelectorAll(`.kanban-item[data-value="${transaction.id_jenis}"]`);
        motorItems.forEach(item => {
            const availableStock = parseInt(item.getAttribute('data-stock'));
            updateMotorItemStatus(item, availableStock - 1, selectedMotors[transaction.id_jenis] || 0);
            
            if (transaction.status === 'disewa') {
                item.classList.add('rented');
                item.querySelector('.status-text')?.remove();
                
                const statusText = document.createElement('div');
                statusText.classList.add('status-text', 'font-bold', 'text-sm', 'absolute', 'top-2', 'right-2', 'px-2', 'py-1', 'rounded-full', 'bg-red-500', 'text-white');
                statusText.textContent = 'Disewa';
                
                const imageContainer = item.querySelector('.aspect-w-16');
                imageContainer.style.position = 'relative';
                imageContainer.appendChild(statusText);
            }
        });
        updateMotorSelectionStatus();
    }

    // Function to update motor availability
    async function updateMotorAvailability(motorId) {
        try {
            const response = await fetch(`/booking/get-available-stock?id_jenis=${motorId}`);
            const data = await response.json();
            
            document.querySelectorAll(`.kanban-item[data-value="${motorId}"] .stock-count`)
                .forEach(element => {
                    element.textContent = `${data.available_stock}`;
                });

            document.querySelectorAll(`.kanban-item[data-value="${motorId}"]`)
                .forEach(item => {
                    item.setAttribute('data-stock', data.available_stock);
                });

            updateMotorSelectionStatus();
        } catch (error) {
            console.error('Error updating motor availability:', error);
        }
    }

    addRentalBtn.addEventListener('click', function() {
        const newRentalForm = rentalForms.children[0].cloneNode(true);
        rentalCount++;
        newRentalForm.querySelector('h3').textContent = `Rental ${rentalCount}`;
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

        item.querySelector('.status-text')?.remove();

        if (availableStock === 0 || isBooked) {
            item.classList.add('opacity-50', 'cursor-not-allowed');
            item.classList.remove('hover:bg-blue-300');

            const statusText = document.createElement('div');
            statusText.classList.add('status-text', 'font-bold', 'text-sm', 'absolute', 'top-2', 'right-2', 'px-2', 'py-1', 'rounded-full');

            if (isBooked) {
                statusText.textContent = 'Dibooking';
                statusText.classList.add('bg-yellow-500', 'text-white');
            } else {
                statusText.textContent = 'Habis';
                statusText.classList.add('bg-red-500', 'text-white');
            }

            const imageContainer = item.querySelector('.aspect-w-16');
            imageContainer.style.position = 'relative';
            imageContainer.appendChild(statusText);
        } else {
            item.classList.remove('opacity-50', 'cursor-not-allowed');
            item.classList.add('hover:bg-blue-300');
        }

        const stockCountElement = item.querySelector('.stock-count');
        if (stockCountElement) {
            stockCountElement.textContent = `${availableStock - selectedCount}`;
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
        const dendaPerJam = 15000;

        if (isNaN(tglSewa.getTime()) || isNaN(tglKembali.getTime()) || isNaN(hargaPerHari)) {
            // errorMessageDiv.innerHTML = '<span class="text-red-600">⚠️ Mohon isi semua form dengan benar.</span>';
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

        const diffTime = tglKembali - tglSewa;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        const remainingHours = Math.floor((diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        let total = diffDays * hargaPerHari;

        if (remainingHours > 0 && remainingHours <= 6) {
            total += remainingHours * dendaPerJam;
        } else if (remainingHours > 6) {
            total += hargaPerHari;
        }

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

    async function cekTanggalBooking(tglSewa, tglKembali, idJenis) {
        try {
            const response = await fetch(`/booking/check-booking-dates?tgl_sewa=${tglSewa}&tgl_kembali=${tglKembali}&id_jenis=${idJenis}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            if (data && typeof data.isBooked !== 'undefined') {
                return data.isBooked;
            }
            return false;
        } catch (error) {
            console.error('Error dalam cekTanggalBooking:', error);
            return false;
        }
    }

    async function updateDateCheck(rentalForm) {
        const tglSewaInput = rentalForm.querySelector('.tgl_sewa');
        const tglKembaliInput = rentalForm.querySelector('.tgl_kembali');
        const idJenisInput = rentalForm.querySelector('.id_jenis');
        // const errorMessageDiv = rentalForm.querySelector('.error-message'); // Tempat pesan error

        if (!tglSewaInput.value || !tglKembaliInput.value || !idJenisInput.value) {
            console.error('Salah satu elemen input tidak ditemukan di dalam form.');
            return;
        }

        // Tampilkan loading
        Swal.fire({
            title: 'Memeriksa Ketersediaan...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
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
                Swal.fire({
                    icon: 'success',
                    title: 'Motor Tersedia',
                    text: '✔️ Motor ini tersedia untuk tanggal yang dipilih.',
                    confirmButtonText: 'Ok',
                    customClass: {
                        confirmButton: 'bg-green-500 text-white'
                    }
                });
                // errorMessageDiv.textContent = '';
                tglKembaliInput.classList.remove('border-yellow-500');
                bookedMotors[idJenisInput.value] = false;
            }

            updateMotorSelectionStatus();
            updateGrandTotal();

            // Periksa stok tersedia
            const response = await fetch(`/booking/get-available-stock?id_jenis=${idJenisInput.value}&tgl_sewa=${tglSewaInput.value}&tgl_kembali=${tglKembaliInput.value}`);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const data = await response.json();
            const stockElement = rentalForm.querySelector(`.kanban-item[data-value="${idJenisInput.value}"] .stock-count`);
            if (stockElement) {
                stockElement.textContent = `Tersedia: ${data.available_stock}`;
            } else {
                console.warn('Elemen stok tidak ditemukan untuk id_jenis:', idJenisInput.value);
            }
        } catch (error) {
            console.error('Terjadi kesalahan:', error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: 'Terjadi kesalahan saat memproses permintaan Anda.',
                confirmButtonText: 'Ok',
                customClass: {
                    confirmButton: 'bg-red-500 text-white'
                }
            });
        } finally {
            Swal.close();
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

    let selectedIdJenis = new Set();

    function updateMotorSelectionStatus() {
        document.querySelectorAll('.rental-form').forEach(form => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                const motorId = item.getAttribute('data-value');
                const availableStock = parseInt(item.getAttribute('data-stock'));
                const selectedCount = selectedMotors[motorId] || 0;
                updateMotorItemStatus(item,availableStock, selectedCount);
            });
        });
    }

    function addKanbanSelectListeners() {
        document.querySelectorAll('.rental-form').forEach((form, formIndex) => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                item.addEventListener('click', function() {
                    if (this.classList.contains('cursor-not-allowed')) {
                        return;
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
                        i.classList.remove('selected');
                        i.querySelector('.selected-text')?.remove();
                    });

                    this.classList.add('selected');

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
                    selectedText.innerHTML = 'Terpilih';
                    selectedText.classList.add('selected-text');
                    this.appendChild(selectedText);

                    // errorMessageDiv.textContent = '';
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

    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

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
                    confirmButtonText: 'Ok',
                    customClass: {
                        confirmButton: 'bg-red-600 text-white'
                    }
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
                        confirmButton: 'bg-red-600 text-white'
                    }
                });
            }
        });

        if (!isValid) {
            return;
        }

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

    function updateRentalInfo() {
        const tglSewaInput = document.querySelector('.tgl_sewa');
        const tglKembaliInput = document.querySelector('.tgl_kembali');

        if (tglSewaInput && tglKembaliInput) {
            const tglSewa = new Date(tglSewaInput.value);
            const tglKembali = new Date(tglKembaliInput.value);

            if (tglSewa && tglKembali) {
                const diff = tglKembali - tglSewa;
                const totalHours = Math.floor(diff / (1000 * 60 * 60));
                const days = Math.floor(totalHours / 24);
                const hours = totalHours % 24;

                document.getElementById('lama_sewa').textContent = `${days} hari ${hours} jam`;

                let keterlambatan = Math.max(0, totalHours - 24);
                document.getElementById('keterlambatan').textContent = `${keterlambatan} jam`;

                const hourlyRate = 15000;
                let total = totalHours * hourlyRate;

                document.getElementById('formatted_total').value = `Rp. ${total.toLocaleString('id-ID')}`;
                document.getElementById('formatted_total').value = total;
            }
        }
    }

    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('input', updateRentalInfo);
    }

    // Initialize everything
    addKanbanSelectListeners();
    addEventListeners(rentalForms.children[0]);
    initializeMotorStatus();
    updateGrandTotal();
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
