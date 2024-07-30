<!-- resources/views/components/loading-spinner.blade.php -->
<div id="loading-spinner" class="fixed inset-0 flex items-center justify-center bg-white z-50">
    <div class="flex flex-col items-center space-y-4">
        <!-- Spinner Circle -->
        <div class="relative w-24 h-24 flex items-center justify-center">
            <div class="absolute w-24 h-24 border-8 border-t-blue-500 border-solid rounded-full animate-spin"></div>
            <div class="absolute w-24 h-24 border-8 border-gray-300 border-solid rounded-full opacity-50"></div>
        </div>
        <!-- Loading Text -->
        {{-- <p class="text-blue-600 text-xl font-semibold animate-pulse">Loading...</p> --}}
    </div>
</div>

<!-- Additional style for the background animation -->
<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Spinner animation */
    .animate-spin {
        animation: spin 1.5s linear infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    /* Pulse effect for text */
    .animate-pulse {
        animation: pulse 1.5s infinite ease-in-out;
    }

    /* Improved spinner design */
    .relative > div:first-child {
        border-top-color: #3490dc; /* Blue color */
    }

    .relative > div:last-child {
        border-top-color: transparent;
    }

    /* Smooth backdrop and shadow */
    #loading-spinner {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        animation: backgroundAnimation 6s infinite alternate;
    }

    /* Background animation for a dynamic effect */
    @keyframes backgroundAnimation {
        0% { background-color: rgba(255, 255, 255, 0.9); }
        100% { background-color: rgba(0, 150, 255, 0.1); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hide loading spinner after 3 seconds
        setTimeout(() => {
            const spinner = document.getElementById('loading-spinner');
            if (spinner) {
                spinner.style.opacity = '0';
                setTimeout(() => {
                    spinner.style.display = 'none';
                }, 600);
            }
        }, 3000);
    });
</script>
