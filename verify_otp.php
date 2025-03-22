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
    $otp = $_POST['otp'];

    // Check OTP
    $sql = "SELECT * FROM users WHERE email='$email' AND otp='$otp'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // OTP is correct, update user as verified
        $sql = "UPDATE users SET verified=1 WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Email verified successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating record: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
    }
}

$conn->close();
?>