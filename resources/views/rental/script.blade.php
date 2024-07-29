
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rentalForms = document.getElementById('rentalForms');
    const addRentalBtn = document.getElementById('addRental');
    const errorMessageDiv = document.getElementById('error-message');
    const grandTotalInput = document.getElementById('grand_total');
    let rentalCount = 1;
    let selectedMotors = {};

    function calculateTotal(rentalForm) {
        const tglSewaInput = rentalForm.querySelector('.tgl_sewa');
        const tglKembaliInput = rentalForm.querySelector('.tgl_kembali');
        const hargaPerHari = rentalForm.querySelector('.id_jenis').dataset.price;
        const formattedTotal = rentalForm.querySelector('.formatted_total');
        const totalInput = rentalForm.querySelector('.total');

        const tglSewa = new Date(tglSewaInput.value);
        const tglKembali = new Date(tglKembaliInput.value);

        if (isNaN(tglSewa.getTime()) || isNaN(tglKembali.getTime()) || !hargaPerHari) {
            errorMessageDiv.textContent = 'Mohon Isi Form Dengan Benar.';
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
        rentalForm.querySelectorAll('.kanban-item').forEach(item => {
            item.addEventListener('click', updateGrandTotal);
        });
    }

    function updateMotorSelectionStatus() {
        document.querySelectorAll('.rental-form').forEach(form => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                const motorId = item.getAttribute('data-value');
                const isSelected = item.classList.contains('selected');
                const availableStock = parseInt(item.getAttribute('data-stock'));
                const selectedCount = selectedMotors[motorId] || 0;

                if (selectedCount >= availableStock && !isSelected) {
                    item.classList.add('opacity-50', 'cursor-not-allowed');
                    item.classList.remove('hover:bg-blue-300');
                    if (!item.querySelector('.out-of-stock-text')) {
                        const text = document.createElement('div');
                        text.textContent = 'Stok Habis';
                        text.classList.add('out-of-stock-text', 'text-red-600', 'font-bold', 'mt-2');
                        item.appendChild(text);
                    }
                } else {
                    item.classList.remove('opacity-50', 'cursor-not-allowed');
                    item.classList.add('hover:bg-blue-300');
                    item.querySelector('.out-of-stock-text')?.remove();
                }

                // Update stock count display
                const stockCountElement = item.querySelector('.stock-count');
                if (stockCountElement) {
                    stockCountElement.textContent = availableStock - selectedCount;
                }
            });
        });
    }

    function addKanbanSelectListeners() {
        document.querySelectorAll('.rental-form').forEach((form, formIndex) => {
            form.querySelectorAll('.kanban-item').forEach(item => {
                item.addEventListener('click', function() {
                    const motorId = this.getAttribute('data-value');
                    const availableStock = parseInt(this.getAttribute('data-stock'));
                    const selectedCount = selectedMotors[motorId] || 0;

                    if (selectedCount >= availableStock && !this.classList.contains('selected')) {
                        errorMessageDiv.textContent = 'Stok motor ini sudah habis';
                        return;
                    }

                    // Remove selection from all items in the current form
                    form.querySelectorAll('.kanban-item').forEach(i => {
                        if (i.classList.contains('selected')) {
                            const prevMotorId = i.getAttribute('data-value');
                            selectedMotors[prevMotorId]--;
                        }
                        i.classList.remove('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
                        i.classList.add('bg-gray-100', 'border-gray-200');
                        i.querySelector('.selected-text')?.remove();
                    });

                    // Add selection to the clicked item
                    this.classList.add('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
                    this.classList.remove('bg-gray-100', 'border-gray-200');
                    form.querySelector('.id_jenis').value = motorId;
                    form.querySelector('.id_jenis').dataset.price = this.getAttribute('data-price');

                    // Update selected motors count
                    selectedMotors[motorId] = (selectedMotors[motorId] || 0) + 1;

                    // Add "Selected" text
                    const selectedText = document.createElement('div');
                    selectedText.textContent = 'Saya Pilih Ini!';
                    selectedText.classList.add('selected-text', 'text-indigo-600', 'font-bold', 'mt-2');
                    this.appendChild(selectedText);

                    errorMessageDiv.textContent = '';
                    updateGrandTotal();
                    updateMotorSelectionStatus();
                });
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
        newRentalForm.querySelectorAll('.kanban-item').forEach(item => {
            item.classList.remove('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
            item.classList.add('bg-gray-100', 'border-gray-200');
            item.querySelector('.selected-text')?.remove();
            item.querySelector('.out-of-stock-text')?.remove();
        });
        rentalForms.appendChild(newRentalForm);
        addEventListeners(newRentalForm);
        addKanbanSelectListeners();
        updateMotorSelectionStatus();
    });

    // Initialize form
    addKanbanSelectListeners();
    addEventListeners(rentalForms.children[0]);
    updateMotorSelectionStatus();

    // Form submission
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Check if all rental forms have a motor selected
        document.querySelectorAll('.rental-form').forEach(form => {
            if (!form.querySelector('.kanban-item.selected')) {
                isValid = false;
                errorMessageDiv.textContent = 'Mohon pilih motor untuk setiap rental.';
            }
        });

        if (isValid) {
            // If everything is valid, you can submit the form
            this.submit();
        }
    });
});
</script>
