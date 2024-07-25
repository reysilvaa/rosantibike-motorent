<!DOCTYPE html>
<html>
<head>
    <title>Invoice Preview</title>
</head>
<body>
    <h1>Invoice Preview</h1>
    <iframe src="data:application/pdf;base64,{{ base64_encode($pdf) }}" style="width: 100%; height: 600px;" frameborder="0"></iframe>
    <a href="{{ route('transaksi.invoice.download', $transaksi->id) }}" class="btn btn-primary">Download PDF</a>
</body>
</html>
