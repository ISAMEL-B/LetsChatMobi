<?php
session_start(); // Start the session

if (isset($_POST['submit'])) {
    $reset_code = $_POST['reset_code'];
    
    // Get the email from the session
    $email = $_SESSION['email'] ?? null;

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'file_sharing');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Check if the reset code matches and is not expired
    $result = $conn->query("SELECT * FROM offices WHERE email = '$email' AND reset_code = '$reset_code' AND code_expiry > NOW()");
    
    if ($result->num_rows > 0) {
        // Code matches, redirect to password reset form
        echo '<script>alert("Code verified. Continue to update password."); window.location.href = "reset_password.php?email=' . urlencode($email) . '";</script>';
    } else {
        echo "Invalid code or the code has expired.";
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
        .form-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <title>Verify Reset Code</title>
</head>
<body>
    <div class="form-container">
        <h2>Verify Reset Code</h2>
        <form method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="text" name="reset_code" placeholder="Enter the reset code" required>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>
