<?php
session_start();
include '../../register/config/db.php';

// Set the content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables
    $reply_message = mysqli_real_escape_string($conn, $_POST['reply_message']);
    $receiver_id = mysqli_real_escape_string($conn, $_POST['receiver_id']);
    $user_id = $_SESSION['user_id'];

    // Check if receiver ID is provided
    if (empty($receiver_id)) {
        echo json_encode(["status" => "error", "error" => "Receiver ID is missing."]);
        exit;
    }

    // Initialize file variables
    $file_path = '';
    $file_name = '';

    // Check if a file was uploaded
    if (isset($_FILES['file'])) {
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(["status" => "error", "error" => "File upload error. Error code: " . $_FILES['file']['error']]);
            exit;
        }

        $file_tmp_path = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];

        // Define allowed file types
        $allowed_file_types = [
            'image/jpeg', 
            'image/png', 
            'image/gif', 
            'audio/mpeg', 
            'audio/wav', 
            'application/pdf',
            'video/mp4',       // MP4 video
            'video/x-msvideo', // AVI video
            'video/x-matroska',// MKV video
            'video/ogg',       // OGG video
            'video/webm'      // WebM video
        ];
        
        // Check file type and size
        if (!in_array($file_type, $allowed_file_types)) {
            echo json_encode(["status" => "error", "error" => "Invalid file type. Only JPG, PNG, GIF, MP3, WAV, PDF, MP4, AVI, MKV, OGG, and WebM files are allowed."]);
            exit;
        }
        
        if ($file_size > 10 * 1024 * 1024) { // Limit file size to 5MB
            echo json_encode(["status" => "error", "error" => "File size exceeds the limit of 10MB."]);
            exit;
        }

        // Specify the directory to save the uploaded file
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Create the directory if it doesn't exist
        }

        // Handle file name collision
        $file_name = time() . '_' . basename($file_name);
        $file_path = $upload_dir . $file_name;

        // Move the uploaded file to the specified directory
        if (!move_uploaded_file($file_tmp_path, $file_path)) {
            echo json_encode(["status" => "error", "error" => "Failed to upload file."]);
            exit;
        }
    }

    // Prepare SQL query to insert message and file details
    $stmt = mysqli_prepare($conn, "INSERT INTO files (file_name, file_path, sender_office_id, receiver_office_id, message, time_sent) VALUES (?, ?, ?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, 'sssss', $file_name, $file_path, $user_id, $receiver_id, $reply_message);

    if (mysqli_stmt_execute($stmt)) {
        $last_insert_id = mysqli_insert_id($conn);

        // Fetch the newly inserted message to send back as a response
        $select_query = "SELECT file_id, file_name, file_path, sender_office_id, receiver_office_id, message, time_sent 
                         FROM files WHERE file_id = ?";
        $select_stmt = mysqli_prepare($conn, $select_query);
        mysqli_stmt_bind_param($select_stmt, 'i', $last_insert_id);
        mysqli_stmt_execute($select_stmt);
        $result = mysqli_stmt_get_result($select_stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $new_message = mysqli_fetch_assoc($result);
            echo json_encode(["status" => "success", "message" => $new_message]);
        } else {
            echo json_encode(["status" => "error", "error" => "Failed to retrieve the new message."]);
        }
    } else {
        echo json_encode(["status" => "error", "error" => "Failed to send the message. Error: " . mysqli_error($conn)]);
    }

    // Close prepared statements
    mysqli_stmt_close($stmt);
    if (isset($select_stmt)) {
        mysqli_stmt_close($select_stmt);
    }
}

// Close the database connection
mysqli_close($conn);
?>
