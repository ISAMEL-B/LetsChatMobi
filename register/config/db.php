<?php
$host = 'localhost'; // Database host, usually 'localhost'
$user = 'root'; // Database username
$pass = ''; // Database password (leave empty if no password)
$db = 'file_sharing'; // Name of your database

// Create a connection using mysqli
$conn = mysqli_connect($host, $user, $pass, $db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Uncomment the line below to test the connection
// echo "Connected successfully";
?>
