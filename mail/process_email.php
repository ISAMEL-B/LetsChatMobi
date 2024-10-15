<?php
// Start of PHP code with no preceding whitespace
date_default_timezone_set('Africa/Kampala'); // Set to Uganda's timezone

// Enable error reporting during development (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Use PHPMailer namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer library files
require '../plugins/PHPMailer/src/Exception.php';
require '../plugins/PHPMailer/src/PHPMailer.php';
require '../plugins/PHPMailer/src/SMTP.php';

// Initialize message variables
$message = '';
$messageType = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve and sanitize form data
    $recipient_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']), ENT_QUOTES, 'UTF-8');
    $message_content = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');
    
    // Initialize attachment variable
    $attachmentPath = null;

    // Validate email format
    if (!filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $messageType = "error";
    } else {
        // Handle file upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/'; // Ensure this directory exists and is writable
            
            // Ensure the uploads directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the directory with proper permissions
            }

            // Sanitize the file name and prepare the attachment path
            $attachmentPath = $uploadDir . basename($_FILES['attachment']['name']);
            if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $attachmentPath)) {
                $message = "Failed to move the uploaded file.";
                $messageType = "error";
            }
        }

        // Database connection using MySQLi
        $conn = new mysqli('localhost', 'root', '', 'file_sharing');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the INSERT statement
        $insert_stmt = $conn->prepare("INSERT INTO mails (recipient_email, subject, message, attachment, sent_at) VALUES (?, ?, ?, ?, NOW())");
        if ($insert_stmt) {
            $attachmentPathForDB = $attachmentPath ? $attachmentPath : NULL; // Use NULL if no attachment
            $insert_stmt->bind_param('ssss', $recipient_email, $subject, $message_content, $attachmentPathForDB);

            // Execute the statement
            if ($insert_stmt->execute()) {
                // Email sent successfully; proceed to send the email
                // Create an instance of PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable for debugging
                    $mail->isSMTP();                                           
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'byaruhangaisamelk@gmail.com';       // Your SMTP username                     
                    $mail->Password   = 'jctz chkz ckxf lckx';                // Your SMTP password                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                    
    
                    // Recipients
                    $mail->setFrom('byaruhangaisamelk@gmail.com', 'LETSCHAT_HELP DESK');
                    $mail->addAddress($recipient_email); // Add a recipient
    
                    // Content
                    $mail->isHTML(true);                                  
                    $mail->Subject = $subject;

                    // Customized HTML email body
                    $mail->Body = "
                        <div style='font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto; background-color: #b3fab1; border: 1px solid #ddd; border-radius: 8px;'>
                            <h2 style='color: #333; text-align: center;'>LETSCHAT Message</h2>
                            <p>Dear <strong>{$recipient_email}</strong>,</p>
                            <p style='color: #555;'>{$message_content}</p>
                            <br>
                            <hr style='border: 0; border-top: 1px solid #ddd;'>
                            <p style='text-align: center; font-size: 12px; color: #999;'>@B.Isamel <br>&copy; 2024 LetsChat. All rights reserved.</p>
                        </div>
                    ";

                    // Plain text version for email clients that do not support HTML
                    $mail->AltBody = "Dear {$recipient_email},\n\n{$message_content}\n\n@B.Isamel\n© 2024 LetsChat. All rights reserved.";

                    // Add attachment if it exists
                    if ($attachmentPath) {
                        $mail->addAttachment($attachmentPath);
                    }

                    // Send the email
                    $mail->send();

                    // Provide success feedback
                    $message = "Email sent successfully.";
                    $messageType = "success";
                } catch (Exception $e) {
                    // Log the error
                    error_log("Mailer Error: {$mail->ErrorInfo}");
                    $message = "There was an error sending the email. Please check your internet connection and try again later.";
                    $messageType = "error";
                }
            } else {
                // Failed to insert into database
                $message = "Failed to send the email. Check Recepient's Email Address";
                $messageType = "error";
            }

            // Close the statement
            $insert_stmt->close();
        } else {
            // Failed to prepare the statement
            $message = "Failed to prepare the database statement.";
            $messageType = "error";
        }

        // Close the database connection
        $conn->close();
    }
}
?>
