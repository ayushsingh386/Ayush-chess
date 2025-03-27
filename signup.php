<?php
// submit.php
session_start();
include 'db.php'; // Include the database connection

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $password = sanitizeInput($_POST['pass']);
    $cnpass = sanitizeInput($_POST['cnpass']);

    // Check if passwords match
    if ($password !== $cnpass) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to sign in page
        echo "<script>alert('Registration successful!'); window.location.href='signin.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>