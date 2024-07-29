<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Rental - ROSANTIBIKE</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
    <script>
        window.tailwind.config = {
            darkMode: ['class'],
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))'
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))'
                        },
                        destructive: {
                            DEFAULT: 'hsl(var(--destructive))',
                            foreground: 'hsl(var(--destructive-foreground))'
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))'
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))'
                        },
                        popover: {
                            DEFAULT: 'hsl(var(--popover))',
                            foreground: 'hsl(var(--popover-foreground))'
                        },
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))'
                        },
                    },
                }
            }
        }
    </script>
    <style>
        @layer base {
            :root {
                --background: 0 0% 100%;
                --foreground: 240 10% 3.9%;
                --card: 0 0% 100%;
                --card-foreground: 240 10% 3.9%;
                --popover: 0 0% 100%;
                --popover-foreground: 240 10% 3.9%;
                --primary: 346.8 77.2% 49.8%;
                --primary-foreground: 355.7 100% 97.3%;
                --secondary: 240 4.8% 95.9%;
                --secondary-foreground: 240 5.9% 10%;
                --muted: 240 4.8% 95.9%;
                --muted-foreground: 240 3.8% 46.1%;
                --accent: 240 4.8% 95.9%;
                --accent-foreground: 240 5.9% 10%;
                --destructive: 0 84.2% 60.2%;
                --destructive-foreground: 0 0% 98%;
                --border: 240 5.9% 90%;
                --input: 240 5.9% 90%;
                --ring: 346.8 77.2% 49.8%;
                --radius: 0.5rem;
            }
            .dark {
                --background: 20 14.3% 4.1%;
                --foreground: 0 0% 95%;
                --popover: 0 0% 9%;
                --popover-foreground: 0 0% 95%;
                --card: 24 9.8% 10%;
                --card-foreground: 0 0% 95%;
                --primary: 346.8 77.2% 49.8%;
                --primary-foreground: 355.7 100% 97.3%;
                --secondary: 240 3.7% 15.9%;
                --secondary-foreground: 0 0% 98%;
                --muted: 0 0% 15%;
                --muted-foreground: 240 5% 64.9%;
                --accent: 12 6.5% 15.1%;
                --accent-foreground: 0 0% 98%;
                --destructive: 0 62.8% 30.6%;
                --destructive-foreground: 0 85.7% 97.3%;
                --border: 240 3.7% 15.9%;
                --input: 240 3.7% 15.9%;
                --ring: 346.8 77.2% 49.8%;
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
            padding: 5px;
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
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #666;
            position: relative;
        }

        .footer p {
            margin: 2px 0;
        }

        .footer-bottom {
            background-color: #333;
            color: #fff;
            padding: 2px 0;
            font-size: 9px;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
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
            width: 10%;
        }

        .extra-column {
            width: 15%;
            text-align: center;
        }

        .signature-block {
            text-align: center;
            width: 48%;
            position: absolute;
            margin-bottom: 0;
            margin-top: 10px;
            display: inline-block;
            vertical-align: top;
        }

        .signature-block-right {
            text-align: center;
            margin-top: 13.7px;
            width: 48%;
            position: absolute;
            right: 0;
            top: 0.7rem;
            display: inline-block;
        }

        .signature-line {
            border-top: 1px solid #666;
            margin-top: 50px;
            width: 100%;
        }
        .header-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .header-title {
            margin-bottom: 1rem;
        }

        .header-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @media (min-width: 640px) {
            .header-container {
                flex-direction: row;
                justify-content: space-between;
        }

        .header-title {
            margin-bottom: 0;
        }

        .header-info {
            align-items: flex-end;
        }
    }
    </style>
</head>
<body class="bg-white dark:bg-zinc-800">
    <div class="bg-white dark:bg-zinc-800 p-2 header-container max-w-3xl mx-auto mb-8">
        <div class="header-title">
            <h2 class="text-red-600 text-xl font-bold">ROSANTIBIKE Motorent</h2>
        </div>
        <div class="header-info">
            <p class="text-zinc-700 dark:text-zinc-300 text-xs sm:text-xs">JL. BAUKSIT 90 C RT.04 RW.09 BLIMBING - MALANG</p>
            <p class="text-zinc-700 dark:text-zinc-300 text-xs sm:text-xs">HP: 0811 3535 122, 082 331 044 747, 085 258 725 454</p>
        </div>
    </div>
    <!-- Data Diri Penyewa -->
    <div class="section mt-4">
        <div class="section-header">Data Diri Penyewa</div>
        <table class="table">
            <tr>
                <th width="30%">Nama Penyewa</th>
                <td colspan="3">{{ $transaksi->nama_penyewa }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td colspan="3">{{ $transaksi->alamat ?? '____________________________' }}</td>
            </tr>
            <tr>
                <th>No. Handphone</th>
                <td colspan="3">
                    <table class="phone-table">
                        <tr>
                            <th>1.</th>
                            <td>{{ $transaksi->wa1 }}</td>
                            <td>{{ $transaksi->nama }}</td>
                            <td>______________________</td>
                        </tr>
                        <tr>
                            <th>2.</th>
                            <td>{{ $transaksi->wa2 }}</td>
                            <td></td>
                            <td>______________________</td>
                        </tr>
                        <tr>
                            <th>3.</th>
                            <td>{{ $transaksi->wa3 }}</td>
                            <td></td>
                            <td>______________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Jenis Motor</th>
                <td>{{ $transaksi->jenisMotor->stok->merk ?? '_______________________' }}</td>
                <th class="extra-column">Helm</th>
                <td>{{ $transaksi->helm ?? '_______' }} Buah</td>
            </tr>
            <tr>
                <th>No. Pol</th>
                <td>{{ $transaksi->jenisMotor->nopol ?? '-' }}</td>
                <th class="extra-column">Jas Hujan</th>
                <td>{{ $transaksi->jas_hujan ?? '_______' }} Buah</td>
            </tr>
        </table>
    </div>

    <!-- Informasi Sewa -->
    <div class="section mt-4">
        <div class="section-header">Informasi Sewa</div>
        <table class="table">
            <tr>
                <th width="20%">Tanggal Sewa</th>
                <td width="30%">
                    {{ \Carbon\Carbon::parse($transaksi->tgl_sewa)->locale('id')->translatedFormat('l, d F Y') }}
                </td>
                <th class="time-column">Jam</th>
                <td>{{ $transaksi->jam_sewa ?? '_________' }}</td>
            </tr>
            <tr>
                <th>Tanggal Kembali</th>
                <td>
                    {{ \Carbon\Carbon::parse($transaksi->tgl_kembali)->locale('id')->translatedFormat('l, d F Y') }}
                </td>
                <th class="time-column">Jam</th>
                <td>{{ $transaksi->jam_kembali ?? '_________' }}</td>
            </tr>
        </table>
    </div>

    <!-- Biaya -->
    <div class="section mt-4">
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

    <!-- Keterangan Lain -->
    <div class="section mt-4">
        <div class="section-header">Keterangan Lain</div>
        <table class="table">
            <tr>
                <td class="notes">
                    {{ $transaksi->keterangan_lain ?? '____________________________________________________-' }}
                </td>
            </tr>
        </table>
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
        <p style="text-align: center; font-size: 9.5px;">Malang, {{ now()->format('d M Y') }}</p>
        <div class="signature-block">
            <p>PEMILIK KENDARAAN</p>
            <div class="signature-line"></div>
            <p>(_____________________________________________)</p>
        </div>
        <div class="signature-block-right">
            <p>MENYETUJUI PERNYATAAN DIATAS</p>
            <div class="signature-line"></div>
            <p style="font-size: 11px;">({{ $transaksi->nama_penyewa }})</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>JAM OPERASIONAL 06.00 - 20.00 WIB</p>
    </div>
</body>
</html>
