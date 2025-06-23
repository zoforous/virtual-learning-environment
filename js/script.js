// Show a confirmation before deleting (works if delete buttons use class="confirm-delete")
document.addEventListener('DOMContentLoaded', function () {
    const deleteLinks = document.querySelectorAll('.confirm-delete');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const confirmDelete = confirm("Are you sure you want to delete this item?");
            if (!confirmDelete) {
                e.preventDefault();
            }
        });
    });
});

// Show/hide password toggle (if input has class="toggle-password")
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.toggle-password');
    toggles.forEach(toggle => {
        const input = document.querySelector(`#${toggle.dataset.target}`);
        toggle.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';
                toggle.textContent = '🙈 Hide';
            } else {
                input.type = 'password';
                toggle.textContent = '👁️ Show';
            }
        });
    });
});

// Highlight current navigation item
document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    document.querySelectorAll('nav a').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.style.textDecoration = 'underline';
        }
    });
});