<?php
session_start();
include '../../register/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_id = intval($_POST['file_id']);

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM files WHERE file_id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Message deleted successfully.";
    } else {
        echo "Error deleting message.";
    }

    $stmt->close();
    $conn->close();
}
?>
