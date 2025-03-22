<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sportsmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if user is verified
    $sql = "SELECT * FROM users WHERE email='$email' AND verified=1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User is verified, log them in
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not verified or user does not exist']);
    }
}

$conn->close();
?>