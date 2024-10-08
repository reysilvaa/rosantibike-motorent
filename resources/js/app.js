import '@fortawesome/fontawesome-free/css/all.css';

import '../css/app.css';
import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const spinner = document.getElementById('loading-spinner');
    if (spinner) {
        spinner.style.display = 'none';
    }
});

// Fallback to hide spinner after a certain time
setTimeout(() => {
    const spinner = document.getElementById('loading-spinner');
    if (spinner) {
        spinner.style.display = 'none';
    }
}, 5000); // Adjust the time as needed
