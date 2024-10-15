const toggleButton = document.getElementById('toggle-mode');
const body = document.body;

// Check if dark mode is enabled (saved in local storage)
if (localStorage.getItem('nightMode') === 'enabled') {
    body.classList.add('dark-mode');
}

toggleButton.addEventListener('click', () => {
    // Toggle dark mode on/off
    body.classList.toggle('dark-mode');

    // Save the user's preference in local storage
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('nightMode', 'enabled');
    } else {
        localStorage.removeItem('nightMode');
    }
});
