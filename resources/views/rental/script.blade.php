
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
            rentalForm.querySelector('.kanban-item').addEventListener('click', updateGrandTotal);
        }

        function updateMotorSelectionStatus() {
            const selectedMotors = new Set();
            document.querySelectorAll('.rental-form').forEach(form => {
                const selectedMotor = form.querySelector('.kanban-item.selected');
                if (selectedMotor) {
                    selectedMotors.add(selectedMotor.getAttribute('data-value'));
                }
            });

            document.querySelectorAll('.rental-form').forEach(form => {
                form.querySelectorAll('.kanban-item').forEach(item => {
                    const motorId = item.getAttribute('data-value');
                    const isSelected = item.classList.contains('selected');
                    const isSelectedElsewhere = selectedMotors.has(motorId) && !isSelected;

                    if (isSelectedElsewhere) {
                        if (!item.querySelector('.already-rented-text')) {
                            const text = document.createElement('div');
                            text.textContent = 'Saya sudah sewa ini';
                            text.classList.add('already-rented-text', 'text-red-600', 'font-bold', 'mt-2');
                            item.appendChild(text);
                            item.classList.add('border-red-500', 'border-2');
                        }
                    } else {
                        item.classList.remove('border-red-500', 'border-2');
                        item.querySelector('.already-rented-text')?.remove();
                    }

                    // Always add red outline to selected items
                    if (isSelected) {
                        item.classList.add('border-indigo-500', 'border-2');
                    }
                });
            });
        }

        function addKanbanSelectListeners() {
            document.querySelectorAll('.rental-form').forEach((form, formIndex) => {
                form.querySelectorAll('.kanban-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const motorId = this.getAttribute('data-value');
                        const alreadySelectedForm = document.querySelector(`.rental-form:not(:nth-child(${formIndex + 1})) .kanban-item[data-value="${motorId}"].selected`);

                        if (alreadySelectedForm) {
                            errorMessageDiv.textContent = 'Motor yang akan anda pilih sudah anda pilih sebelumnya';
                            return;
                        }

                        // Remove selection from all items in the current form
                        form.querySelectorAll('.kanban-item').forEach(i => {
                            i.classList.remove('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
                            i.classList.add('bg-gray-100', 'border-gray-200');
                            i.querySelector('.selected-text')?.remove();
                        });

                        // Add selection to the clicked item
                        this.classList.add('bg-indigo-100', 'border-indigo-500', 'hover:bg-indigo-100', 'selected');
                        this.classList.remove('bg-gray-100', 'border-gray-200');
                        form.querySelector('.id_jenis').value = motorId;
                        form.querySelector('.id_jenis').dataset.price = this.getAttribute('data-price');

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
                item.querySelector('.already-rented-text')?.remove();
            });
            rentalForms.appendChild(newRentalForm);
            addEventListeners(newRentalForm);
            addKanbanSelectListeners();
            updateMotorSelectionStatus(); // Update status after adding new form
        });

        addKanbanSelectListeners();
        addEventListeners(rentalForms.children[0]);
        updateMotorSelectionStatus(); // Initial setup of motor selection status
    });
    </script>
