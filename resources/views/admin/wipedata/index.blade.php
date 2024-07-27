@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Wipe Data</h1>

    <form action="{{ route('wipe.data') }}" method="POST">
        @csrf
        <div class="flex flex-wrap gap-6">
            <!-- Jenis Motor Card -->
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300">
                    <h2 class="text-xl font-semibold mb-4">Jenis Motor</h2>
                    <p class="text-gray-600 mb-4">Delete all records related to Jenis Motor.</p>
                    <input type="checkbox" name="models[]" value="jenis_motor" id="jenis_motor" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="jenis_motor" class="ml-2 text-gray-700">Select to wipe</label>
                </div>
            </div>

            <!-- Transaksi Card -->
            <div class="w-full sm:w-1/2 lg:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300">
                    <h2 class="text-xl font-semibold mb-4">Transaksi</h2>
                    <p class="text-gray-600 mb-4">Delete all records related to Transaksi.</p>
                    <input type="checkbox" name="models[]" value="transaksi" id="transaksi" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="transaksi" class="ml-2 text-gray-700">Select to wipe</label>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full mt-6 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">Wipe Selected Data</button>
    </form>
</div>
@endsection
