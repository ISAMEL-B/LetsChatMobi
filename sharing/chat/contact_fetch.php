<?php
// Start the session
session_start();

// Check if the session variable `user_id` is set, redirect if not
if (!isset($_SESSION['user_id'])) {
    // Optionally, you can redirect to a login page or show an error
    header('Location: ../../register/register.php');
    exit();
}
include '../../register/config/db.php';

// Assume the current logged-in user's office_id is stored in session
$current_office_id = $_SESSION['user_id'];

// SQL query to fetch all unique contacts with whom the user has at least one conversation
$sql = "
    SELECT o.office_id, o.username,

       -- Last sent message by the current user to this contact
       (SELECT f1.message 
        FROM files f1 
        WHERE f1.sender_office_id = ? AND f1.receiver_office_id = o.office_id 
        ORDER BY f1.time_sent DESC LIMIT 1) AS last_sent_message,

       (SELECT f1.time_sent 
        FROM files f1 
        WHERE f1.sender_office_id = ? AND f1.receiver_office_id = o.office_id 
        ORDER BY f1.time_sent DESC LIMIT 1) AS last_sent_time,

       -- Last received message by the current user from this contact
       (SELECT f2.message 
        FROM files f2 
        WHERE f2.receiver_office_id = ? AND f2.sender_office_id = o.office_id 
        ORDER BY f2.time_sent DESC LIMIT 1) AS last_received_message,

       (SELECT f2.time_sent 
        FROM files f2 
        WHERE f2.receiver_office_id = ? AND f2.sender_office_id = o.office_id 
        ORDER BY f2.time_sent DESC LIMIT 1) AS last_received_time,

       -- Unread message count (messages received by the user)
       COUNT(CASE WHEN f.is_read = 0 AND f.receiver_office_id = ? THEN 1 END) AS unread_count

FROM offices o

-- Join the files table to account for all messages between the current user and each contact
LEFT JOIN files f ON (
    (f.sender_office_id = ? AND f.receiver_office_id = o.office_id) 
    OR 
    (f.receiver_office_id = ? AND f.sender_office_id = o.office_id)
)

-- Ensure you don't show the logged-in user's own office ID
-- WHERE o.office_id != ?

GROUP BY o.office_id

-- Sort the results by the most recent message (either sent or received)
ORDER BY GREATEST(
    COALESCE((SELECT MAX(f1.time_sent) FROM files f1 WHERE f1.sender_office_id = ? AND f1.receiver_office_id = o.office_id), 0),
    COALESCE((SELECT MAX(f2.time_sent) FROM files f2 WHERE f2.receiver_office_id = ? AND f2.sender_office_id = o.office_id), 0)
) DESC;
";

// Prepare and bind the SQL statement to prevent SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiiiiiii", 
    $current_office_id, $current_office_id, $current_office_id, $current_office_id, 
    $current_office_id, $current_office_id, $current_office_id, $current_office_id, 
    $current_office_id
);
$stmt->execute();
$result = $stmt->get_result();
?>
