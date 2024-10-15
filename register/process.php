<?php
session_start(); // Start the session

include 'config/db.php';
// Handle signup
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if phone_number or username already exists
    $check_sql = "SELECT * FROM offices WHERE username='$username' OR phone_number='$phone_number'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Set session messages based on which field is taken
        $errors = [];
        while ($row = $check_result->fetch_assoc()) {
            if ($row['username'] === $username) {
                $errors[] = "username is already taken!   ";
            }
            if ($row['phone_number'] === $phone_number) {
                $errors[] = "phone_number is already taken!   ";
            }
            if ($row['email'] === $email) {
                $errors[] = "Email ID is already taken!   ";
            }
            
        }
        $_SESSION['registration_errors'] = implode(" ", $errors); // Combine errors into one message
        header("Location: register.php"); // Redirect back to the registration page
        exit();
    }

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO offices (username, email, password, phone_number, fname) VALUES ('$username', '$email', '$hashed_password', '$phone_number', '$fname')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['signup_message'] = "Account created successfully!";
            header("Location: register.php"); 
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Passwords do not match!";
    }
}

// Handle login
if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM offices WHERE username='$user' OR phone_number='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['office_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['phone_number'] = $row['phone_number']; 
            $_SESSION['fname'] = $row['fname'];
            

             // Redirect based on role to upload.php with role as a query parameter
             header("Location: ../sharing/chat/contacts.php");
             exit();
            
        } else {
            $_SESSION['login_error'] = "Invalid password!"; // Set login error
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "No user with that Username/Phone No.!"; // Set email error
        header("Location: register.php");
        exit();
    }
}

$conn->close();
?>
