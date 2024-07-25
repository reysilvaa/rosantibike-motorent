<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Rental</title>
    <style>
        @media print {
            @page {
                margin: 0;
                size: A4;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            background-color: #f0f0f0;
            padding: 10px 15px;
            border-bottom: 2px solid #ddd;
            margin-bottom: 15px;
        }

        .header strong {
            font-size: 18px;
            color: #333;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-header {
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            color: #444;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }

        .notes {
            font-size: 10px;
            color: #666;
            font-style: italic;
        }

        .terms {
            font-size: 10px;
            color: #333;
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .terms h4 {
            margin: 0 0 10px 0;
            color: #444;
        }

        .terms ol {
            padding-left: 20px;
            margin: 0;
        }

        .terms li {
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .footer p {
            margin: 3px 0;
        }

        .footer-bottom {
            background-color: #333;
            color: #fff;
            padding: 5px 0;
            font-size: 11px;
            text-align: center;
            margin-top: 20px;
        }

        .phone-table {
            margin: 0;
            padding: 0;
        }

        .phone-table th, .phone-table td {
            border: none;
            padding: 2px 5px;
        }

        .phone-table th {
            width: 20px;
        }
        .time-column {
            width: 10%; /* Atur lebar sesuai kebutuhan */
        }
        .extra-column {
            width: 15%;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <strong>Invoice #{{ $transaksi->id }}</strong>
        </div>

        <div class="section">
            <div class="section-header">Data Diri Penyewa</div>
            <table class="table">
                <tr>
                    <th width="30%">Nama Penyewa</th>
                    <td colspan="3">{{ $transaksi->nama_penyewa }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td colspan="3">{{ $transaksi->alamat ?? '........................................' }}</td>
                </tr>
                <tr>
                    <th>No. Handphone</th>
                    <td colspan="3">
                        <table class="phone-table">
                            <tr><th>1.</th><td>{{ $transaksi->wa1 }}</td></tr>
                            <tr><th>2.</th><td>{{ $transaksi->wa2 }}</td></tr>
                            <tr><th>3.</th><td>{{ $transaksi->wa3 }}</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Jenis Motor</th>
                    <td>{{ $transaksi->jenisMotor->merk ?? '........................................' }}</td>
                    <th class="extra-column">Helm</th>
                    <td>{{ $transaksi->helm ?? '...........' }} Buah</td>
                </tr>
                <tr>
                    <th>No. Pol</th>
                    <td>{{ $transaksi->jenisMotor->nopol ?? '-' }}</td>
                    <th class="extra-column">Jas Hujan</th>
                    <td>{{ $transaksi->jas_hujan ?? '...........' }} Buah</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-header">Informasi Sewa</div>
            <table class="table">
                <tr>
                    <th width="20%">Tanggal Sewa</th>
                    <td width="30%">{{ $transaksi->tgl_sewa }}</td>
                    <th class="time-column">Jam</th>
                    <td>{{ $transaksi->jam_sewa ?? '...........' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kembali</th>
                    <td>{{ $transaksi->tgl_kembali }}</td>
                    <th class="time-column">Jam</th>
                    <td>{{ $transaksi->jam_kembali ?? '...........' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-header">Biaya</div>
            <table class="table">
                <tr>
                    <th width="30%">Biaya Sewa</th>
                    <td>Rp. {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Biaya Antar Jemput</th>
                    <td>Rp. {{ number_format($transaksi->biaya_antar_jemput ?? 0, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-header">Keterangan Lain</div>
            <div class="notes">
                {{ $transaksi->keterangan_lain ?? '........................................' }}
            </div>
        </div>

        <div class="terms">
            <h4>PENTING DIKETAHUI KETENTUAN-KETENTUAN DIBAWAH INI:</h4>
            <ol>
                <li>Kendaraan (Sepeda Motor) yang tersebut diatas (yang disewakan) tidak dapat dipindah tangan kepada pihak lain/kedua tanpa seizin pemilik kendaraan (Sepeda Motor).</li>
                <li>Kendaraan (Sepeda Motor) tersebut diatas tidak dapat dijadikan jaminan/digadaikan dengan tujuan apapun kepada siapapun.</li>
                <li>Pelanggaran No. 1 & 2 akan diproses melalui jalur pidana dan pemilik kendaraan berhak untuk mengambil kembali kendaraan apabila terjadi pelanggaran No. 1 & 2 atau terdapat kejanggalan lainnya mengenai pemakaian kendaraan, dimana hal ini dirasakan oleh pemilik kendaraan (Sepeda Motor).</li>
                <li>Apabila terjadi kerusakan pada kendaraan baik sengaja maupun tidak setelah kendaraan ditangan PENYEWA, PENYEWA bertanggung jawab atas kerusakan tersebut.</li>
                <li><strong>Jika ada keterlambatan pengembalian kendaraan akan dikenakan denda perjam sebesar Rp. 15.000; dst.</strong></li>
            </ol>
        </div>

        <div class="footer">
            <p>Malang, {{ now()->format('d M Y') }}</p>
            <p>Pemilik Kendaraan</p>
            <p>&nbsp;</p>
            <p>MENYETUJUI PERNYATAAN DIATAS</p>
            <p>({{ $transaksi->nama_penyewa }})</p>
        </div>

        <div class="footer-bottom">
            <p>JAM OPERASIONAL 06.00 - 20.00 WIB</p>
        </div>
    </div>
</body>
</html>
