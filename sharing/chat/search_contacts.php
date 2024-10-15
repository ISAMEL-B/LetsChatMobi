<?php
// Include your database connection file here
include '../../register/config/db.php';

$query = $_GET['query'];
$searchQuery = "%" . $conn->real_escape_string($query) . "%";

// SQL to search for contacts who haven't initiated a conversation
$sql = "SELECT office_id, username 
        FROM offices 
        WHERE username LIKE ? 
        AND office_id NOT IN (SELECT DISTINCT sender_office_id FROM files WHERE office_id = ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $searchQuery, $current_office_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contactName = htmlspecialchars($row['username']);
        $contactId = $row['office_id'];

        echo "<a href='chatting.php?contactId=$contactId' style='text-decoration: none; color: inherit;' onclick='markAsRead($contactId)'>
                <div class='card'>
                    <div class='profile-img'></div>
                    <div class='message-info'>
                        <h2>$contactName</h2>
                    </div>
                </div>
              </a>";
    }
}

$stmt->close();
$conn->close();
?>
