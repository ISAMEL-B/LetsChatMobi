<?php
// Include database connection
include '../../register/config/db.php';

if (isset($_GET['contactId'])) {
    $contactId = intval($_GET['contactId']);

    // Prepare and execute the SQL query to update the sender_is_read field
    $query = "UPDATE messages SET sender_is_read = 1 WHERE contact_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $contactId);
        if ($stmt->execute()) {
            // Return a JSON response indicating success
            echo json_encode(['success' => true]);
        } else {
            // Return a JSON response indicating failure
            echo json_encode(['success' => false, 'error' => 'Failed to execute query.']);
        }
        $stmt->close();
    } else {
        // Return a JSON response indicating failure
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement.']);
    }
} else {
    // Return a JSON response indicating failure due to missing contactId
    echo json_encode(['success' => false, 'error' => 'Invalid contactId.']);
}

// Close the database connection
$conn->close();
?>
