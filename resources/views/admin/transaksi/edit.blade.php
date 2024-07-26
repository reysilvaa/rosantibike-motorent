@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Transaksi</h2>

    <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success:</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Menampilkan data transaksi -->
        <div class="mb-4">
            <label for="id" class="block text-sm font-medium text-gray-700">ID Transaksi</label>
            <input type="text" id="id" name="id" value="{{ $transaksi->id }}" class="mt-1 block w-full" disabled>
        </div>

        <div class="mb-4">
            <label for="id_user" class="block text-sm font-medium text-gray-700">ID User</label>
            <input type="text" id="id_user" name="id_user" value="{{ $transaksi->id_user }}" class="mt-1 block w-full" disabled>
        </div>

        <div class="mb-4">
            <label for="nama_penyewa" class="block text-sm font-medium text-gray-700">Nama Penyewa</label>
            <input type="text" id="nama_penyewa" name="nama_penyewa" value="{{ $transaksi->nama_penyewa }}" class="mt-1 block w-full" disabled>
        </div>

        <div class="mb-4">
            <label for="wa1" class="block text-sm font-medium text-gray-700">WA1</label>
            <input type="text" id="wa1" name="wa1" value="{{ $transaksi->wa1 }}" class="mt-1 block w-full" disabled>
        </div>

        <div class="mb-4">
            <label for="wa2" class="block text-sm font-medium text-gray-700">WA2</label>
            <input type="text" id="wa2" name="wa2" value="{{ $transaksi->wa2 }}" class="mt-1 block w-full" disabled>
        </div>

        <div class="mb-4">
            <label for="wa3" class="block text-sm font-medium text-gray-700">WA3</label>
            <input type="text" id="wa3" name="wa3" value="{{ $transaksi->wa3 }}" class="mt-1 block w-full" disabled>
        </div>

        <div class="mb-4">
            <label for="tgl_sewa" class="block text-sm font-medium text-gray-700">Tanggal Sewa</label>
            <input type="date" id="tgl_sewa" name="tgl_sewa" value="{{ $transaksi->tgl_sewa->format('Y-m-d') }}" class="mt-1 block w-full" disabled>
        </div>

        <div class="mb-4">
            <label for="tgl_kembali" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
            <input type="date" id="tgl_kembali" name="tgl_kembali" value="{{ $transaksi->tgl_kembali->format('Y-m-d') }}" class="mt-1 block w-full @error('tgl_kembali') border-red-500 @enderror">
            @error('tgl_kembali')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="id_jenis" class="block text-sm font-medium text-gray-700">Jenis Motor</label>
            <select id="id_jenis" name="id_jenis" class="mt-1 block w-full @error('id_jenis') border-red-500 @enderror">
                @foreach($jenisMotorList as $jenisMotor)
                    <option value="{{ $jenisMotor->id }}" {{ $jenisMotor->id == $transaksi->id_jenis ? 'selected' : '' }}>
                        {{ $jenisMotor->merk }} ({{ $jenisMotor->nopol }})
                    </option>
                @endforeach
            </select>
            @error('id_jenis')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
            <input type="text" id="total" name="total" value="{{ $transaksi->total }}" class="mt-1 block w-full" disabled>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Transaksi
        </button>
    </form>
</div>
@endsection
