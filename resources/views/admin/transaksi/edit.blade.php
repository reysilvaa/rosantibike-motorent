@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-10 bg-gray-100 rounded-lg shadow-lg">
    <h2 class="text-4xl font-bold mb-10 text-gray-800 text-center">Edit Transaksi</h2>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg shadow-sm" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-lg shadow-sm" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-lg space-y-8" id="editTransaksiForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="space-y-6">
                @foreach(['id' => 'ID Transaksi', 'id_user' => 'ID User', 'nama_penyewa' => 'Nama Penyewa'] as $field => $label)
                    <div class="form-group">
                        <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                        <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ $transaksi->$field }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-gray-100" disabled>
                    </div>
                @endforeach
            </div>

            <div class="space-y-6">
                @foreach(['wa1' => 'WA1', 'wa2' => 'WA2', 'wa3' => 'WA3'] as $field => $label)
                    <div class="form-group">
                        <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                        <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ $transaksi->$field }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-gray-100" disabled>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-8">
            <div class="form-group">
                <label for="tgl_sewa" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sewa</label>
                <input type="date" id="tgl_sewa" name="tgl_sewa" value="{{ $transaksi->tgl_sewa->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-gray-100" disabled>
            </div>

            <div class="form-group">
                <label for="tgl_kembali" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali</label>
                <input type="date" id="tgl_kembali" name="tgl_kembali" value="{{ $transaksi->tgl_kembali->format('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('tgl_kembali') border-red-500 @enderror">
                @error('tgl_kembali')
                    <p class="text-rose-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-12 bg-gray-50 p-8 rounded-lg shadow-inner">
            <h3 class="text-2xl font-bold text-gray-800 mb-8">Pilih Jenis Motor</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="jenisMotorKanban">
                @foreach($jenisMotorList as $jenisMotor)
                    <div class="bg-white border-2 rounded-lg p-3 cursor-pointer transition-all duration-300 hover:shadow-lg hover:border-indigo-500" data-id="{{ $jenisMotor->id }}" data-price="{{ $jenisMotor->harga_perHari }}">
                        <img src="{{ $jenisMotor->foto ? asset('storage/' . $jenisMotor->foto) : 'https://via.placeholder.com/150' }}" alt="{{ $jenisMotor->merk }}" class="w-full h-32 object-cover rounded-md mb-3">
                        <h3 class="text-sm font-semibold text-gray-800">{{ $jenisMotor->merk }}</h3>
                        <p class="text-xs text-gray-600">Nopol: {{ $jenisMotor->nopol }}</p>
                        <p class="text-sm font-bold text-indigo-600 mt-1">Rp {{ number_format($jenisMotor->harga_perHari, 0, ',', '.') }}/hari</p>
                    </div>
                @endforeach
            </div>
            <input type="hidden" id="id_jenis" name="id_jenis" value="{{ $transaksi->id_jenis }}">
            @error('id_jenis')
                <p class="text-rose-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div class="mt-12 bg-white p-8 rounded-lg shadow-md">
            <h3 class="text-2xl font-bold text-gray-800 mb-8">Rincian Biaya</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                @foreach([
                    'totalSebelum' => 'Total Sebelum Perpanjang',
                    'totalSesudah' => 'Total Sesudah Perpanjang',
                    'lamaPerpanjang' => 'Lama Perpanjang',
                    'motorSebelum' => 'Motor Sebelum Perubahan',
                    'motorSesudah' => 'Motor Sesudah Perubahan',
                    'biayaGantiUnit' => 'Biaya Harga Unit (Jika ganti unit)'
                ] as $id => $label)
                    <div>
                        <p class="font-medium text-gray-700">{{ $label }}:</p>
                        <p id="{{ $id }}" class="text-lg font-semibold text-gray-900"></p>
                    </div>
                @endforeach
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h4 class="font-semibold text-xl mb-4 text-gray-800">Rincian:</h4>
                <p id="rincianBiaya" class="text-2xl font-bold text-indigo-600"></p>
                <div id="rincianDetail" class="text-base md:text-lg font-bold text-indigo-600 break-words space-y-2">
            </div>

            <input type="hidden" id="total" name="total" value="{{ $transaksi->total }}">
        </div>

        <button type="submit" class="mt-12 w-full bg-indigo-600 text-white text-xl font-bold px-8 py-4 rounded-lg shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition transform hover:scale-105">
            Update Transaksi
        </button>
    </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const tglKembaliInput = document.getElementById('tgl_kembali');
    const idJenisInput = document.getElementById('id_jenis');
    const totalInput = document.getElementById('total');
    const jenisMotorKanban = document.getElementById('jenisMotorKanban');

    const totalSebelumEl = document.getElementById('totalSebelum');
    const totalSesudahEl = document.getElementById('totalSesudah');
    const lamaPerpanjangEl = document.getElementById('lamaPerpanjang');
    const motorSebelumEl = document.getElementById('motorSebelum');
    const motorSesudahEl = document.getElementById('motorSesudah');
    const biayaGantiUnitEl = document.getElementById('biayaGantiUnit');
    const rincianBiayaEl = document.getElementById('rincianBiaya');
    const rincianDetailEl = document.getElementById('rincianDetail');

    const originalTotal = parseFloat("{{ $transaksi->total }}");
    const originalMotor = "{{ $transaksi->jenisMotor->merk }} (Nopol: {{ $transaksi->jenisMotor->nopol }})";
    let currentMotor = originalMotor;

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angka);
    }

    function updateTotal() {
        const originalTglKembali = new Date("{{ $transaksi->tgl_kembali->format('Y-m-d') }}");
        const tglKembali = new Date(tglKembaliInput.value);
        const selectedMotor = jenisMotorKanban.querySelector('.selected');
        const hargaPerHari = selectedMotor ? parseFloat(selectedMotor.dataset.price) : 0;

        if (tglKembali && hargaPerHari) {
            const jumlahHari = Math.max(0, Math.ceil((tglKembali - originalTglKembali) / (1000 * 60 * 60 * 24)));
            const biayaPerpanjangan = jumlahHari * hargaPerHari;
            const newTotal = biayaPerpanjangan + originalTotal;

            totalSebelumEl.textContent = formatRupiah(originalTotal);
            totalSesudahEl.textContent = formatRupiah(newTotal);
            lamaPerpanjangEl.textContent = `${jumlahHari} hari`;
            motorSebelumEl.textContent = originalMotor;
            motorSesudahEl.textContent = currentMotor;

            if (currentMotor === originalMotor) {
                biayaGantiUnitEl.textContent = 'Tidak ada perubahan';
                motorSesudahEl.textContent = 'Tidak ada perubahan';

                biayaGantiUnitEl.classList.add('text-rose-500', 'text-sm');
                motorSesudahEl.classList.add('text-rose-500', 'text-sm');

                if (lamaPerpanjangEl.textContent === '0 hari'){
                    lamaPerpanjangEl.textContent = 'Tanggal Kembali Belum di isi!';
                    lamaPerpanjangEl.classList.add('text-rose-500', 'text-sm');
                }
            } else {
                biayaGantiUnitEl.textContent = formatRupiah(biayaPerpanjangan);
                biayaGantiUnitEl.classList.remove('text-rose-500', 'text-sm');
                motorSesudahEl.classList.remove('text-rose-500', 'text-sm');
                lamaPerpanjangEl.classList.remove('text-rose-500', 'text-sm');
            }

            rincianBiayaEl.textContent = formatRupiah(newTotal);
            rincianDetailEl.textContent = `${formatRupiah(originalTotal)} (sebelum perpanjang) + ${formatRupiah(biayaPerpanjangan)} (biaya ${currentMotor} untuk ${jumlahHari} hari) = ${formatRupiah(newTotal)}`;

            totalInput.value = newTotal;
        }
    }

    tglKembaliInput.addEventListener('change', updateTotal);

    jenisMotorKanban.addEventListener('click', function (e) {
        const selectedCard = e.target.closest('[data-id]');
        if (selectedCard) {
            jenisMotorKanban.querySelectorAll('.selected').forEach(card => {
                card.classList.remove('selected', 'border-indigo-500', 'shadow-md');
            });
            selectedCard.classList.add('selected', 'border-indigo-500', 'shadow-md');
            idJenisInput.value = selectedCard.dataset.id;
            currentMotor = `${selectedCard.querySelector('h3').textContent} (Nopol: ${selectedCard.querySelector('p').textContent.split(': ')[1]})`;
            updateTotal();
        }
    });

    // Pra-pilih card berdasarkan id_jenis dari database
    const preSelectedCard = jenisMotorKanban.querySelector(`[data-id='${idJenisInput.value}']`);
    if (preSelectedCard) {
        preSelectedCard.classList.add('selected', 'border-indigo-500', 'shadow-md');
        currentMotor = `${preSelectedCard.querySelector('h3').textContent} (Nopol: ${preSelectedCard.querySelector('p').textContent.split(': ')[1]})`;
        updateTotal();
    }
});
</script>
<style>
    @media (max-width: 640px) {
        #rincianDetail {
            font-size: 0.875rem; /* text-sm */
        }
    }

    @media (min-width: 641px) {
        #rincianDetail {
            font-size: 1.125rem; /* text-lg */
        }
    }
</style>
@endsection
