<?php
// Start session
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "register_db";

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Store user data in session
            $_SESSION['username'] = $username;

            // Redirect to homepage
            header("Location: ../Home.html");
            exit;
        } else {
            echo "<script>alert('Invalid password!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.history.back();</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
