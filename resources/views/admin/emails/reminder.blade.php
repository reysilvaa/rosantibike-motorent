<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Rental</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 550px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        h1 {
            color: #333333;
            font-size: 26px;
            margin: 0 0 20px;
            padding-bottom: 10px;
            text-align: center;
            border-bottom: 3px solid #007bff;
        }
        p {
            color: #555555;
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 20px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            background: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        li {
            padding: 15px;
            font-size: 16px;
            color: #333333;
            border-bottom: 1px solid #e0e0e0;
            background: #ffffff;
        }
        li:last-child {
            border-bottom: none;
        }
        .footer {
            text-align: center;
            padding: 15px;
            border-top: 1px solid #e0e0e0;
            background: #007bff;
            color: #ffffff;
            font-size: 14px;
            border-radius: 0 0 12px 12px;
        }
        .footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .highlight {
            background-color: #e0f7ff;
            padding: 10px;
            border-radius: 6px;
            color: #007bff;
            font-weight: bold;
        }
        .header-img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://i.ibb.co.com/vv5wPd2/images.jpg" alt="Header Image" class="header-img">
        <h1>Pengingat Rental Anda!</h1>
        <p>Periode rental kendaraan Anda akan berakhir pada: <span class="highlight">{{ $transaksi->tgl_kembali->format('d-m-Y') }}</span></p>
        <p>Berikut adalah detail kendaraan Anda:</p>
        <ul>
            <li><strong>Nama Penyewa:</strong> {{ $transaksi->nama_penyewa }}</li>
            <li><strong>Merk:</strong> {{ $merk }}</li>
            <li><strong>Hari/Tanggal:</strong> <span style="font-size: 15px; ">{{ $formattedDate }}</span></li>
            <li><strong>No. Polisi:</strong> {{ $nopol }}</li>
        </ul>
        <p>Terima kasih telah menggunakan layanan kami. Jika ada pertanyaan, silakan hubungi kami.</p>
        <div class="footer">
            &copy; {{ date('Y') }} RosantiBike. All rights reserved. <br>
            <a href="https://www.rosantibike.com">Kunjungi situs kami</a>
        </div>
    </div>
</body>
</html>
