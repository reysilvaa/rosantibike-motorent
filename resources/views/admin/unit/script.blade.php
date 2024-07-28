
<script>
    const fileInput = document.getElementById('foto');
    const urlInput = document.getElementById('foto_url');
    const currentPhoto = document.getElementById('currentPhoto');
    const dropZone = document.querySelector('.border-dashed');

    fileInput.addEventListener('change', handleFileSelect);
    urlInput.addEventListener('input', handleUrlInput);

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-indigo-500', 'bg-indigo-100');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-indigo-500', 'bg-indigo-100');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-indigo-500', 'bg-indigo-100');
        fileInput.files = e.dataTransfer.files;
        handleFileSelect();
    });

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                currentPhoto.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-lg shadow-md">`;
            }
            reader.readAsDataURL(file);
            urlInput.value = ''; // Clear URL input when file is selected
        }
    }

    function handleUrlInput() {
        if (urlInput.value) {
            currentPhoto.innerHTML = `<img src="${urlInput.value}" alt="Preview" class="w-full h-full object-cover rounded-lg shadow-md">`;
            fileInput.value = ''; // Clear file input when URL is entered
        }
    }

    // Animated label for price input
    const priceInput = document.getElementById('harga_perHari');
    priceInput.addEventListener('focus', function() {
        this.parentNode.classList.add('ring', 'ring-indigo-500', 'ring-opacity-50');
    });
    priceInput.addEventListener('blur', function() {
        this.parentNode.classList.remove('ring', 'ring-indigo-500', 'ring-opacity-50');
    });
</script>
