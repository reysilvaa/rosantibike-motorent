
<style>
    .custom-font {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
    }
    .btn-enabled {
        background-color: #4f46e5;
        color: white;
    }
    .btn-disabled {
        background-color: #d1d5db;
        color: #6b7280;
        cursor: not-allowed;
    }
</style>
    <div x-data="{
        canAgree: false,
        agreementChecked: false,
        checkScroll(event) {
            const container = event.target;
            this.canAgree = container.scrollHeight - container.scrollTop <= container.clientHeight + 1;
        },
        submitForm(event) {
            if (!this.canAgree || !this.agreementChecked) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Anda harus membaca syarat hingga ke bawah dan menyetujui syarat dan ketentuan sebelum melanjutkan.',
                    confirmButtonText: 'Ok',
                    customClass: {
                        confirmButton: 'bg-indigo-600 text-white'
                    }
                });
            }
        }
    }"
    x-init="$watch('canAgree', value => console.log('canAgree:', value)); $watch('agreementChecked', value => console.log('agreementChecked:', value))"
    class="max-w-screen mx-auto px-4 py-6">
        <div class="mb-6">
            <h6 class="text-xl font-semibold mb-4 text-gray-900">Syarat dan Ketentuan</h6>
            <div class="border border-gray-200 rounded-lg shadow-md p-4 sm:p-6 h-64 overflow-y-auto bg-white"
                 x-on:scroll="checkScroll($event)"
                 x-ref="termsContainer">
                 <div class="prose prose-sm text-gray-800 mx-auto max-w-full">
                    <h3 class="text-lg font-bold mt-4 mb-2 border-b border-gray-300 pb-2">Syarat Jaminan</h3>
                    <ol class="list-decimal list-inside space-y-2 custom-font">
                        <li>Penyewa harus menyertakan E-KTP (Wajib) + Identitas lain yang mendukung.</li>
                        <li>Apabila Penyewa berboncengan harus menyertakan E-KTP (Wajib) + Identitas lain yang mendukung (Teman Boncengan).</li>
                        <li>Identitas Penyewa akan ditahan hingga pengembalian motor.</li>
                    </ol>

                    <h3 class="text-lg font-bold mt-8 mb-2 border-b border-gray-300 pb-2">Ketentuan Penyewa</h3>
                    <ol class="list-decimal list-inside space-y-2 custom-font">
                        <li>Penyewa harus berusia minimal 18 tahun dan memiliki SIM yang masih berlaku.</li>
                        <li>Penyewa bertanggung jawab penuh atas kerusakan atau kehilangan motor selama masa sewa.</li>
                        <li>Dilarang keras menggunakan motor untuk kegiatan ilegal atau yang melanggar hukum.</li>
                        <li>Motor harus dikembalikan dalam kondisi yang sama seperti saat dipinjam.</li>
                        <li>Penyewa wajib menggunakan helm dan mematuhi peraturan lalu lintas yang berlaku.</li>
                        <li>Penyewa wajib melaporkan segera jika terjadi kecelakaan atau kerusakan pada motor.</li>
                    </ol>

                    <h3 class="text-lg font-bold mt-8 mb-2 border-b border-gray-300 pb-2">Ketentuan Biaya</h3>
                    <ol class="list-decimal list-inside space-y-2 custom-font">
                        <li>Keterlambatan pengembalian akan dikenakan denda Rp. 15.000 / jam.</li>
                        <li>Apabila menggunakan jasa antar-jemput maka Penyewa bersedia dikenakan biaya tambahan.</li>
                        <li>Biaya sewa tidak termasuk biaya bahan bakar / bensin.</li>
                    </ol>

                    <h3 class="text-lg font-bold mt-8 mb-2 border-b border-gray-300 pb-2">Ketentuan Dokumentasi</h3>
                    <ol class="list-decimal list-inside space-y-2 custom-font">
                        <li>Penyewa bersedia di foto dengan unit motor yang akan disewa.</li>
                    </ol>
                    <p class="text-xs font-bold mt-4 custom-font">
                        Dengan menyetujui syarat dan ketentuan ini, pemilik membebaskan pihak penyewa dari segala tuntutan hukum yang mungkin timbul selama masa penyewaan.
                    </p>
                </div>
            </div>
        </div>
        <div class="mb-6 flex items-center gap-3">
            <input type="checkbox" id="agreement" name="agreement" required
                   class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                   x-model="agreementChecked"
                   x-bind:disabled="!canAgree">
            <label for="agreement" class="text-sm font-medium text-gray-700"
                   x-bind:class="{ 'opacity-50': !canAgree }">
                Saya telah membaca dan menyetujui semua syarat dan ketentuan yang berlaku.
            </label>
        </div>

        <button
            type="submit"
            x-on:click="submitForm($event)"
            x-bind:class="{
                'btn-enabled': canAgree && agreementChecked,
                'btn-disabled': !(canAgree && agreementChecked)
            }"
            x-bind:disabled="!canAgree || !agreementChecked"
            class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Kirim Booking
        </button>
    </div>
