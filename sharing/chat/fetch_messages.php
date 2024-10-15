<?php
session_start();
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "file_sharing";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated.']);
    exit();
}

$current_user_id = $_SESSION['user_id'];

// Get POST data
$message = isset($_POST['message']) ? $_POST['message'] : '';
$contact_id = isset($_POST['contactId']) ? intval($_POST['contactId']) : 0;

if (empty($message) || $contact_id === 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters.']);
    exit();
}

// Insert the message into the database
$insert_sql = "INSERT INTO files (sender_office_id, receiver_office_id, message, time_sent) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($insert_sql);
$stmt->bind_param("iis", $current_user_id, $contact_id, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to send message.']);
}

$stmt->close();
$conn->close();
?>
