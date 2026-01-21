document.addEventListener('DOMContentLoaded', function () {

    // Login Form Validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (password.length < 6) {
                e.preventDefault();
                alert('Security Error: Password must be at least 6 characters.');
            }
        });
    }

    // Register Form Validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (fullname.trim() === '') {
                e.preventDefault();
                alert('Identity Error: Name is required.');
                return;
            }

            if (!email.includes('@')) {
                e.preventDefault();
                alert('Identity Error: Invalid email format.');
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Security Error: Password must be at least 6 characters.');
                return;
            }
        });
    }
});
