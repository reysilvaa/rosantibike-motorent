@if ($errors->any())
<div x-data="{ open: true }">
    <div x-show="open"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">

        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all sm:w-full sm:max-w-lg">
            <div class="px-6 py-4">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-medium text-red-500">Kesalahan!</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500">
                        <span class="text-2xl">&times;</span>
                    </button>
                </div>
                <div class="mt-3">
                    <ul class="list-disc pl-5 text-red-500">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <button @click="open = false" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@if (session('success'))
<div x-data="{ open: true }">
    <div x-show="open"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">

        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all sm:w-full sm:max-w-lg">
            <div class="px-6 py-4">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-medium text-green-500">Berhasil!</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500">
                        <span class="text-2xl">&times;</span>
                    </button>
                </div>
                <div class="mt-3">
                    <p class="text-green-500">{{ session('success') }}</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <button @click="open = false" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif
