@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Wipe Data</h1>

    <!-- Confirmation Modal -->
    <div x-data="{ open: false }">
        <!-- Button to open the modal -->
        <form @submit.prevent="open = true">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Jenis Motor Card -->
                <div x-data="{ checked: false }" class="w-full">
                    <div :class="{ 'border-blue-500': checked }" class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                        <h2 class="text-lg font-semibold mb-2">Jenis Motor</h2>
                        <p class="text-gray-600 mb-2">Delete all records related to Jenis Motor.</p>
                        <input type="checkbox" name="models[]" value="jenis_motor" id="jenis_motor" x-model="checked" class="form-checkbox h-5 w-5 text-blue-600">
                        <label for="jenis_motor" class="ml-2 text-gray-700">Select to wipe</label>
                    </div>
                </div>

                <!-- Transaksi Card -->
                <div x-data="{ checked: false }" class="w-full">
                    <div :class="{ 'border-blue-500': checked }" class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                        <h2 class="text-lg font-semibold mb-2">Transaksi</h2>
                        <p class="text-gray-600 mb-2">Delete all records related to Transaksi.</p>
                        <input type="checkbox" name="models[]" value="transaksi" id="transaksi" x-model="checked" class="form-checkbox h-5 w-5 text-blue-600">
                        <label for="transaksi" class="ml-2 text-gray-700">Select to wipe</label>
                    </div>
                </div>

                <!-- Booking Card -->
                <div x-data="{ checked: false }" class="w-full">
                    <div :class="{ 'border-blue-500': checked }" class="bg-white p-4 rounded-lg shadow-md border border-gray-300 transition-transform transform hover:scale-105">
                        <h2 class="text-lg font-semibold mb-2">Booking</h2>
                        <p class="text-gray-600 mb-2">Delete all records related to Booking.</p>
                        <input type="checkbox" name="models[]" value="booking" id="booking" x-model="checked" class="form-checkbox h-5 w-5 text-blue-600">
                        <label for="booking" class="ml-2 text-gray-700">Select to wipe</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full mt-6 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
                Wipe Selected Data
            </button>
        </form>

        <!-- Confirmation Modal -->
        <div x-show="open" @keydown.window.escape="open = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">Confirm Wipe Data</h3>
                <p class="mb-6">Are you sure you want to delete the selected data? This action cannot be undone.</p>
                <div class="flex justify-end gap-4">
                    <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-300">
                        Cancel
                    </button>
                    <form action="{{ route('admin.wipe.wipe') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-300">
                            Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
