<?php
session_start();
$servername = "localhost"; // Change as needed
$username = "root"; // Change as needed
$password = ""; // Change as needed
$dbname = "your_database"; // Change as needed

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_code = $_POST['code'];
    $new_password = $_POST['new_password'];

    if ($input_code == $_SESSION['reset_code']) {
        $email = $_SESSION['email'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password in the database
        $stmt = $conn->prepare("UPDATE offices SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        echo "<script>alert('Password updated successfully!');</script>";
        session_destroy();
    } else {
        echo "<script>alert('Invalid code.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Update Password</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Update Password</h2>
        <input type="text" name="code" placeholder="Enter the code" required>
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <button type="submit">Update Password</button>
    </form>
</body>
</html>
