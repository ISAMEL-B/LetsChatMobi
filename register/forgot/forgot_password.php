<?php
session_start(); // Start the session
date_default_timezone_set('Africa/Kampala'); // Set to Uganda's timezone

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Include PHPMailer library files
require '../../plugins/PHPMailer/src/Exception.php';
require '../../plugins/PHPMailer/src/PHPMailer.php';
require '../../plugins/PHPMailer/src/SMTP.php';

$email = ''; // Initialize email variable

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the form was submitted
    $email = trim($_POST['email']); // Get the email and trim whitespace
    
    // Debugging output to see if email is being received
    if (empty($email)) {
        echo '<script>alert("Email is empty.");</script>';
    } 
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'file_sharing');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Automatically nullify expired reset codes
    $delete_stmt = $conn->prepare("UPDATE offices SET reset_code = NULL, code_expiry = NULL WHERE code_expiry < NOW()");
    $delete_stmt->execute();
    $delete_stmt->close();

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM offices WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Generate random code
        $reset_code = rand(100000, 999999);
        $code_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store the reset code and expiry in the database
        $update_stmt = $conn->prepare("UPDATE offices SET reset_code = ?, code_expiry = ? WHERE email = ?");
        $update_stmt->bind_param('iss', $reset_code, $code_expiry, $email);
        $update_stmt->execute();
        
        // Store email in session
        $_SESSION['reset_email'] = $email;

        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'byaruhangaisamelk@gmail.com';                     
            $mail->Password   = 'jctz chkz ckxf lckx';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $mail->Port       = 465;                                    

            // Recipients
            $mail->setFrom('byaruhangaisamelk@gmail.com', 'LETSCHAT_HELP DESK');
            $mail->addAddress($email); // Send email to the user who requested the reset

            // Content
            $mail->isHTML(true);                                         
            $mail->Subject = 'LETS-CHAT Password Reset Code';

            // HTML formatted email body with basic styling
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto; background-color: #b3fab1; border: 1px solid #ddd; border-radius: 8px;'>
                    <h2 style='color: #333; text-align: center;'>Password Reset Request</h2>
                    <p>Dear <strong>$email</strong>,</p>
                    <p style='color: #555;'>You have requested to reset your password. Please use the following code to reset your password:</p>
                    <div style='text-align: center; margin: 20px 0;'>
                        <span style='font-size: 24px; font-weight: bold; color: #007BFF;'>$reset_code</span>
                    </div>
                    <p style='color: #555;'>This code is valid for <strong>1 hour</strong>.</p>
                    <p>If you did not request this, please ignore this email or contact support immediately.</p>
                    <p>Thank you!</p>
                    <br>
                    <hr style='border: 0; border-top: 1px solid #ddd;'>
                    <p style='text-align: center; font-size: 12px; color: #999;'>@B.Isamel <br>&copy; 2024 LetsChat. All rights reserved.</p>
                </div>
            ";

            // Plain text version for email clients that do not support HTML
            $mail->AltBody = "Dear $email, your password reset code is $reset_code. This code will expire in 1 hour.";
            $mail->send();
            
            echo '<script>alert("Password reset email has been sent."); window.location.href = "verify_code.php";</script>';
        } catch (Exception $e) {
            echo '<script>alert("There was an error sending the password reset email. Please check your internet connection and try again later."); </script>';
        }

        // Close prepared statements
        $stmt->close();
        $update_stmt->close();
    } else {
        echo '<script>alert("No account found with that email address.");</script>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            width: 400px;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="email"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="email"]:focus, input[type="submit"]:hover {
            border-color: #007bff;
            outline: none;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
    <title>Forgot Password</title>
</head>
<body>
    <div class="form-container">
        <h2>Forgot Password? <br>----<br> Change Password</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <div class="footer">
            <p>&copy; 2024 LetsChat.org</p>
        </div>
    </div>
</body>
</html>
