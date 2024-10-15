<?php
session_start();
$servername = "localhost"; // Change as needed
$username = "root"; // Change as needed
$password = ""; // Change as needed
$dbname = "file_sharing"; // Change as needed

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $code = rand(100000, 999999);
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM offices WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Send code via email (for demonstration, we just store it in session)
        $_SESSION['reset_code'] = $code;
        $_SESSION['email'] = $email;
        // Here you would send the code via email
        echo "<script>alert('A reset code has been sent to your email.');</script>";
    } else {
        echo "<script>alert('Email not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Forgot Password</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Forgot Password</h2>
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Code</button>
    </form>

    <?php if (isset($_SESSION['reset_code'])): ?>
        <form method="POST" action="update_password.php">
            <input type="text" name="code" placeholder="Enter the code" required>
            <button type="submit">Verify Code</button>
        </form>
    <?php endif; ?>
</body>
</html>
