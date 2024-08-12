<!-- resources/views/components/loading-spinner.blade.php -->
<div
    x-data="{ isLoading: true }"
    x-init="setTimeout(() => isLoading = false, 3000)"
    x-show="isLoading"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-80 backdrop-blur-sm z-50"
>
    <div class="relative w-16 h-16">
        <!-- Main rotating square -->
        <div class="absolute inset-0 border-t-4 border-blue-500 animate-spin-cubic"></div>

        <!-- Smaller squares -->
        <div class="absolute inset-0 flex flex-wrap">
            <div class="w-6 h-6 bg-blue-500 animate-scale-fade animation-delay-300"></div>
            <div class="w-6 h-6 bg-blue-500 animate-scale-fade animation-delay-600"></div>
            <div class="w-6 h-6 bg-blue-500 animate-scale-fade animation-delay-900"></div>
            <div class="w-6 h-6 bg-blue-500 animate-scale-fade"></div>
        </div>
    </div>
</div>

<style>
    @keyframes spin-cubic {
        0% { transform: rotate(0deg); }
        25% { transform: rotate(90deg); }
        50% { transform: rotate(180deg); }
        75% { transform: rotate(270deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes scale-fade {
        0%, 100% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1); opacity: 1; }
    }

    .animate-spin-cubic {
        animation: spin-cubic 2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    }

    .animate-scale-fade {
        animation: scale-fade 2s ease-in-out infinite;
    }

    .animation-delay-300 {
        animation-delay: 300ms;
    }

    .animation-delay-600 {
        animation-delay: 600ms;
    }

    .animation-delay-900 {
        animation-delay: 900ms;
    }
</style>
