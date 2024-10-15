<?php
// Start the session to manage user sessions
session_start();

include '../../register/config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || strlen($_SESSION['user_id']) == 0) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../../register/register.php');
    exit();
}

$current_office_id = $_SESSION['user_id'];

// Get the contact_id from GET parameters
if (isset($_GET['contactId'])) { // Use 'contactId' for consistency
    $contact_id = intval($_GET['contactId']); // Ensure it's an integer
} else {
    // Redirect to contacts page if no contact_id is provided
    header("Location: contacts.php");
    exit();
}

// Fetch the contact's username
$contact_sql = "SELECT username FROM offices WHERE office_id = ?";
$contact_stmt = $conn->prepare($contact_sql);
$contact_stmt->bind_param("i", $contact_id);
$contact_stmt->execute();
$contact_result = $contact_stmt->get_result();

if ($contact_result->num_rows > 0) {
    $contact_row = $contact_result->fetch_assoc();
    $contact_name = htmlspecialchars($contact_row['username']);
} else {
    // If contact not found, redirect to contacts page
    header("Location: contacts.php");
    exit();
}
$contact_stmt->close();

// Update the `is_read` status for messages between current user and the contact
$update_read_stmt = $conn->prepare("UPDATE files SET is_read = 1 WHERE (sender_office_id = ? AND receiver_office_id = ?) OR (sender_office_id = ? AND receiver_office_id = ?)");
$update_read_stmt->bind_param("iiii", $current_office_id, $contact_id, $contact_id, $current_office_id);
$update_read_stmt->execute();
$update_read_stmt->close(); // Close the statement after execution

// SQL query to fetch all messages between the current user and the contact
$messages_sql = "
    SELECT f.file_id, f.sender_office_id, f.receiver_office_id, f.message, f.time_sent, f.file_path, f.file_name, f.is_read
    FROM files f
    WHERE 
        (f.sender_office_id = ? AND f.receiver_office_id = ?)
        OR
        (f.sender_office_id = ? AND f.receiver_office_id = ?)
    ORDER BY f.time_sent ASC
";

// Prepare and bind the SQL statement to prevent SQL injection
$messages_stmt = $conn->prepare($messages_sql);
$messages_stmt->bind_param("iiii", $current_office_id, $contact_id, $contact_id, $current_office_id);
$messages_stmt->execute();
$messages_result = $messages_stmt->get_result();

?>
