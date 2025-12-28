document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.signup-form');
    const fullname = document.getElementById('fullname');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');

    const fbBtn = document.querySelector('.facebook');
    const googleBtn = document.querySelector('.google');
    const xBtn = document.querySelector('.x');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let errors = [];

        if(fullname.value.trim() === '') {
            errors.push("Full Name is required");
        }

        if(email.value.trim() === '') {
            errors.push("Email is required");
        } else if(!validateEmail(email.value)) {
            errors.push("Enter a valid email");
        }

        if(password.value.trim() === '') {
            errors.push("Password is required");
        }

        if(confirmPassword.value.trim() === '') {
            errors.push("Confirm Password is required");
        }

        if(password.value !== confirmPassword.value) {
            errors.push("Passwords do not match");
        }

        if(errors.length > 0) {
            alert(errors.join("\n"));
        } else {
            alert("Sign Up Successful!");
            form.reset();
        }
    });

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\\.,;:\s@"]+\.)+[^<>()[\]\\.,;:\s@"]{2,})$/i;
        return re.test(email);
    }

    fbBtn.addEventListener('click', function() {
        window.open('https://www.facebook.com/r.php', '_blank');
    });

    googleBtn.addEventListener('click', function() {
        window.open('https://accounts.google.com/signup', '_blank');
    });

    xBtn.addEventListener('click', function() {
        window.open('https://twitter.com/i/flow/signup', '_blank');
    });
});
