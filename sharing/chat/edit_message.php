<?php
session_start();
include '../../register/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_id = intval($_POST['file_id']);
    $message = $_POST['message'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE files SET message = ? WHERE file_id = ?");
    $stmt->bind_param("si", $message, $file_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo "Message updated successfully.";
    } else {
        echo "Error updating message.";
    }

    $stmt->close();
    $conn->close();
}
?>
