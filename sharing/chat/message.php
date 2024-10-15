<?php
// send_message.php

// Start the session to manage user sessions
session_start();

// Set response header to JSON
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

// Retrieve and sanitize POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['contactId'], $data['message'])) {
    echo json_encode(['success' => false, 'message' => 'Incomplete data provided.']);
    exit();
}

$contact_id = intval($data['contactId']);
$message = trim($data['message']);

// Validate message content
if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
    exit();
}

// Database configuration
$servername = "localhost";
$db_username = "root"; // Replace with your database username
$db_password = "";     // Replace with your database password
$dbname = "file_sharing";

// Create connection to the database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection for any connection errors
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

$current_office_id = $_SESSION['user_id'];

// Prepare SQL to insert the new message
$insert_sql = "
    INSERT INTO files (sender_office_id, receiver_office_id, message, time_sent)
    VALUES (?, ?, ?, NOW())
";

$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("iis", $current_office_id, $contact_id, $message);

if ($insert_stmt->execute()) {
    // Fetch the inserted message details
    $message_id = $insert_stmt->insert_id;

    $fetch_sql = "
        SELECT file_id, sender_office_id, receiver_office_id, message, time_sent, file_path, file_name
        FROM files
        WHERE file_id = ?
    ";

    $fetch_stmt = $conn->prepare($fetch_sql);
    $fetch_stmt->bind_param("i", $message_id);
    $fetch_stmt->execute();
    $result = $fetch_stmt->get_result();

    if ($result->num_rows > 0) {
        $new_message = $result->fetch_assoc();
        // Sanitize data before sending
        $new_message['message'] = htmlspecialchars($new_message['message']);
        $new_message['file_path'] = htmlspecialchars($new_message['file_path']);
        $new_message['file_name'] = htmlspecialchars($new_message['file_name']);
        $new_message['time_sent'] = htmlspecialchars($new_message['time_sent']);

        echo json_encode(['success' => true, 'message' => $new_message]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to retrieve the new message.']);
    }

    $fetch_stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send the message.']);
}

$insert_stmt->close();
$conn->close();
?>
