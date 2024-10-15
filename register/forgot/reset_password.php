<?php
session_start(); // Corrected the session start function

// Check if the session variable for email is set
if (!isset($_SESSION['reset_email'])) {
    echo '<script>alert("Session expired. Please request a password reset again."); window.location.href = "../forgot/forgot_password.php";</script>';
    exit;
}

$email = $_SESSION['reset_email']; // Retrieve the email from session

if (isset($_POST['submit'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate that passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
    } else {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'file_sharing');
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Hash the new password for security
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE offices SET password = ?, reset_code = NULL, code_expiry = NULL WHERE email = ?");
        $stmt->bind_param('ss', $hashed_password, $email);
        
        if ($stmt->execute()) {
            // Clear the session variable after successful password reset
            unset($_SESSION['reset_email']);
            echo '<script>alert("Your password has been successfully reset."); window.location.href = "../register.php";</script>';
        } else {
            echo "<script>alert('Error resetting password. Please try again.');</script>";
        }

        // Close prepared statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .form-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .error {
            color: red;
            display: none; /* Hidden by default */
            margin: 5px 0;
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
    </style>
    <title>Reset Password</title>
</head>
<body>
    <div class="form-container">
        <h2>Reset Password</h2>
        <form method="POST" id="resetForm">
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
            <div id="error_message" class="error">Passwords do not match!</div>
            <input type="submit" name="submit" value="Reset Password">
        </form>
    </div>

    <script>
        const form = document.getElementById('resetForm');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const errorMessage = document.getElementById('error_message');

        form.addEventListener('submit', function(event) {
            const newPassword = form.new_password.value;
            const confirmPassword = confirmPasswordInput.value;

            // Check if the passwords match
            if (newPassword !== confirmPassword) {
                event.preventDefault(); // Prevent form submission
                errorMessage.style.display = 'block'; // Show error message
                confirmPasswordInput.classList.add('shake'); // Add shake class
                setTimeout(() => {
                    confirmPasswordInput.classList.remove('shake'); // Remove shake class after animation
                }, 500);
            } else {
                errorMessage.style.display = 'none'; // Hide error message if passwords match
            }
        });
    </script>
</body>
</html>
