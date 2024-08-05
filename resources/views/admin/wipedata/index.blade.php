@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Wipe Data</h1>

    <!-- Confirmation Form -->
    <form action="{{ route('admin.wipe.wipe') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Jenis Motor Card -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Jenis Motor</h2>
                    <p class="text-gray-600 mb-2">Delete all records related to Jenis Motor.</p>
                    <input type="checkbox" name="models[]" value="jenis_motor" id="jenis_motor" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="jenis_motor" class="ml-2 text-gray-700">Select to wipe</label>
                </div>
            </div>

            <!-- Transaksi Card -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Transaksi</h2>
                    <p class="text-gray-600 mb-2">Delete all records related to Transaksi.</p>
                    <input type="checkbox" name="models[]" value="transaksi" id="transaksi" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="transaksi" class="ml-2 text-gray-700">Select to wipe</label>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Booking</h2>
                    <p class="text-gray-600 mb-2">Delete all records related to Booking.</p>
                    <input type="checkbox" name="models[]" value="booking" id="booking" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="booking" class="ml-2 text-gray-700">Select to wipe</label>
                </div>
            </div>

            <!-- Gallery Card -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Gallery</h2>
                    <p class="text-gray-600 mb-2">Delete all records related to Gallery.</p>
                    <input type="checkbox" name="models[]" value="galeri" id="galeri" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="galeri" class="ml-2 text-gray-700">Select to wipe</label>
                </div>
            </div>

            <!-- Rating Card -->
            <div class="w-full">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                    <h2 class="text-lg font-semibold mb-2">Rating</h2>
                    <p class="text-gray-600 mb-2">Delete all records related to Rating.</p>
                    <input type="checkbox" name="models[]" value="rating" id="rating" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="rating" class="ml-2 text-gray-700">Select to wipe</label>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full mt-6 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
            Wipe Selected Data
        </button>
    </form>

    <x-back-to-list-button route="{{ route('dashboard') }}" />
</div>
@endsection
