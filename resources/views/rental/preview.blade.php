@extends('layouts.admin')

@section('title', 'Invoice Preview')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg p-4 z-10 relative">
            <iframe src="data:application/pdf;base64,{{ base64_encode($pdf) }}" style="width: 100%; height: 600px;" frameborder="0"></iframe>
            <div class="mt-4 z-10 relative">
                <a href="{{ route('transaksi.invoice.download', $transaksi->id) }}" class="btn btn-primary">Download PDF</a>
            </div>
        </div>
    </div>
@endsection
