<?php
// login.php
session_start();
include 'db.php'; // Include the database connection

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $login = sanitizeInput($_POST['login']);
    $password = sanitizeInput($_POST['pass']);

    // Prepare a statement to check if the user exists
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['login'] = $login; // Store the user's email or phone number
            echo "<script>window.location.href='index.html'; alert('Login successful!'); </script>";
        } else {
            // Password is incorrect
            echo "<script>prompt('Invalid password.'); window.history.back();</script>";
        }
    } else {
        // User does not exist
        echo "<script>alert('No account found with that email or phone number.'); window.history.back();</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>