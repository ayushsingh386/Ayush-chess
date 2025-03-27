function validateForm() {
    let subButton = document.getElementById("submit");
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("pass").value;
    let confirmPassword = document.getElementById("cnpass").value;

    if (name === "" || email === "" || password === "" || confirmPassword === "") {
        alert("All the fields must be filled out");
        return false;
    }

    // Email validation
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Invalid email address format.");
        return false;
    }

    // Password validation
    if (password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return false;
    }
    if (!/\d/.test(password)) {
        alert("Password must contain at least one digit.");
        return false;
    }
    if (!/[a-z]/.test(password)) {
        alert("Password must contain at least one lowercase letter.");
        return false;
    }
    if (!/[A-Z]/.test(password)) {
        alert("Password must contain at least one uppercase letter.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match");
        return false;
    }

    console.log("Form Submitted Successfully");
    return true; // Allow form submission
}