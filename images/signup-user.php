<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "foodie";

// Create a database connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"]; // Confirm password

    // Form validation (you can add more validation as needed)
    if (empty($name) || empty($email) || empty($password) || empty($cpassword)) {
        echo "Error: Please fill in all fields.";
    } elseif ($password !== $cpassword) {
        echo "Error: Password and confirm password do not match.";
    } else {
        // Hash the password (you should use a stronger hashing method in production)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $sql = "INSERT INTO signup (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful!";
        } else {
            // Registration failed
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
