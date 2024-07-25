<!DOCTYPE html>
<html>
<head>
    <title>Invoice Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">
    <div class="max-w-4xl mx-auto p-4 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold text-gray-800">ROSANTIBIKE Motorent</h1>
            <p class="text-gray-600 text-sm">JL. BAUKSIT 90 C RT.04 RW.09 BLIMBING - MALANG</p>
            <p class="text-gray-600 text-sm">HP: 0811 3535 122, 082 331 044 747, 085 258 725 454</p>
        </div>

        <h2 class="text-lg font-semibold text-gray-800 mb-4">TANDA TERIMA & SURAT PERJANJIAN PENYEWAAN SEPEDA MOTOR</h2>

        <div class="space-y-3">
            <!-- Section: Customer Details -->
            <div>
                <label class="block text-gray-600 text-sm mb-1">Nama Penyewa:</label>
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm" value="{{ $transaksi->nama_penyewa }}" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">Alamat:</label>
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm" value="{{ $transaksi->alamat ?? '........................................' }}" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">No. Handphone:</label>
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm mb-1" value="1. {{ $transaksi->wa1 }}" />
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm mb-1" value="2. {{ $transaksi->wa2 }}" />
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm" value="3. {{ $transaksi->wa3 }}" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">Jenis Motor:</label>
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm" value="{{ $transaksi->jenisMotor->merk ?? '........................................' }} No. Pol: {{ $transaksi->jenisMotor->nopol ?? '........................................' }}" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">Lama Sewa:</label>
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm" value="{{ $transaksi->lama_sewa ?? '........................................' }} Hari" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">Tanggal Sewa:</label>
                <input type="date" class="border border-gray-300 rounded p-1 w-full text-sm" value="{{ $transaksi->tgl_sewa }}" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">Tanggal Berakhir Sewa:</label>
                <input type="date" class="border border-gray-300 rounded p-1 w-full text-sm" value="{{ $transaksi->tgl_kembali }}" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">Biaya Sewa:</label>
                <input type="text" class="border border-gray-300 rounded p-1 w-full text-sm" value="Rp. {{ number_format($transaksi->total, 0, ',', '.') }} Biaya antar jemput Rp. {{ number_format($transaksi->biaya_antar_jemput ?? 0, 0, ',', '.') }}" />
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-1">Keterangan Lain:</label>
                <textarea class="border border-gray-300 rounded p-1 w-full text-sm" rows="4">{{ $transaksi->keterangan_lain ?? '........................................' }}</textarea>
            </div>
        </div>

        <h3 class="text-md font-semibold text-gray-800 mt-6 mb-2">PENTING DIKETAHUI KETENTUAN-KETENTUAN DIBAWAH INI:</h3>
        <ol class="list-decimal list-inside space-y-1 text-gray-600 text-sm mb-4">
            <li>Kendaraan (Sepeda Motor) yang tersebut diatas (yang disewakan) tidak dapat dipindah tangan kepada pihak lain/kedua tanpa seizin pemilik kendaraan (Sepeda Motor).</li>
            <li>Kendaraan (Sepeda Motor) tersebut diatas tidak dapat dijadikan jaminan/digadaikan dengan tujuan apapun kepada siapapun.</li>
            <li>
                Pelanggaran No. 1 & 2 akan diproses melalui jalur pidana dan pemilik kendaraan berhak untuk mengambil kembali kendaraan apabila terjadi pelanggaran No. 1 & 2 atau terdapat kejanggalan lainnya mengenai pemakaian kendaraan, dimana hal ini dirasakan oleh pemilik kendaraan (Sepeda Motor).
            </li>
            <li>Apabila terjadi kerusakan pada kendaraan baik sengaja maupun tidak setelah kendaraan ditangan PENYEWA, PENYEWA bertanggung jawab atas kerusakan tersebut.</li>
            <li>Jika ada keterlambatan pengembalian kendaraan akan dikenakan denda perjam sebesar Rp. 15.000; dst.</li>
        </ol>

        <div class="mt-4">
            <p class="text-gray-600 text-sm">Malang, {{ now()->format('d M Y') }}</p>
            <p class="text-gray-600 text-sm">Pemilik Kendaraan</p>
            <p class="text-gray-600 text-sm">MENYETUJUI PERNYATAAN DIATAS</p>
            <p class="mt-6 text-sm">({{ $transaksi->nama_penyewa }})</p>
        </div>

        <div class="text-center mt-4">
            <p class="text-gray-600 text-sm">JAM OPERASIONAL 06.00 - 20.00 WIB</p>
        </div>
    </div>
</body>
</html>
