<?php
session_start();
include '../../register/config/db.php';

// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // header('Location: index.php'); // Redirect to login page
//     exit();
// }

// $user_id = $_SESSION['user_id'];

// // Fetch user data from the database
// $stmt = $conn->prepare("SELECT username, status, profile_picture FROM offices WHERE user_id = ?");
// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $stmt->bind_result($username, $status, $profile_picture);
// $stmt->fetch();
// $stmt->close();

// // Handle profile picture update
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
//     $target_dir = "images/profile_pictures/";
//     if (!is_dir($target_dir)) {
//         mkdir($target_dir, 0777, true);
//     }

//     $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
//     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//     // Validate image
//     $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
//     if ($check !== false) {
//         // Validate file size (5MB maximum)
//         if ($_FILES["profile_picture"]["size"] <= 5000000) {
//             // Allow certain file formats
//             if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
//                 // Rename the file to avoid conflicts
//                 $new_filename = $target_dir . "profile_" . $user_id . "." . $imageFileType;
//                 if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $new_filename)) {
//                     // Update the database
//                     $update_stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
//                     $update_stmt->bind_param("si", $new_filename, $user_id);
//                     $update_stmt->execute();
//                     $update_stmt->close();

//                     // Refresh the page to display the new profile picture
//                     header("Location: profile.php");
//                     exit();
//                 } else {
//                     $upload_error = "Sorry, there was an error uploading your file.";
//                 }
//             } else {
//                 $upload_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//             }
//         } else {
//             $upload_error = "Sorry, your file is too large.";
//         }
//     } else {
//         $upload_error = "File is not an image.";
//     }
// }

// // Handle username and status update
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['status'])) {
//     $new_username = trim($_POST['username']);
//     $new_status = trim($_POST['status']);

//     if (!empty($new_username)) {
//         $update_stmt = $conn->prepare("UPDATE users SET username = ?, status = ? WHERE user_id = ?");
//         $update_stmt->bind_param("ssi", $new_username, $new_status, $user_id);
//         $update_stmt->execute();
//         $update_stmt->close();

//         // Refresh the page to display the updated information
//         header("Location: profile.php");
//         exit();
//     } else {
//         $update_error = "Username cannot be empty.";
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo htmlspecialchars($username); ?></title>
    <link rel="stylesheet" href="css/profile.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTTX5o+DnG/6MffJhe9gAmD/tHmvVde5N8ITg9JkOQFIx1g0h9S2sHbyw77rE4MjVJ+8f/ezxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Reset some basic styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f5f5;
    color: #333;
}

/* Profile Container */
.profile-container {
    max-width: 800px;
    margin: 50px auto;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Header */
.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #0088cc;
    color: #ffffff;
    padding: 20px;
}

.profile-header h1 {
    font-size: 1.5em;
}

.logout-button {
    background-color: #ff4d4d;
    color: #ffffff;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease;
}

.logout-button i {
    margin-right: 5px;
}

.logout-button:hover {
    background-color: #e60000;
}

/* Profile Content */
.profile-content {
    display: flex;
    padding: 20px;
    border-bottom: 1px solid #ddd;
}

.profile-picture-section {
    flex: 1;
    text-align: center;
    position: relative;
}

.profile-picture {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #0088cc;
}

.upload-button {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background-color: #0088cc;
    color: #ffffff;
    padding: 8px 12px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.upload-button:hover {
    background-color: #005f8a;
}

.error-message {
    color: #ff4d4d;
    margin-top: 10px;
}

/* Profile Info */
.profile-info {
    flex: 2;
    padding-left: 30px;
}

.input-group {
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #555555;
}

.input-group i {
    margin-right: 5px;
    color: #0088cc;
}

.input-group input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #cccccc;
    border-radius: 5px;
    font-size: 1em;
    transition: border-color 0.3s ease;
}

.input-group input:focus {
    border-color: #0088cc;
    outline: none;
}

.save-button {
    background-color: #0088cc;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease;
}

.save-button i {
    margin-right: 5px;
}

.save-button:hover {
    background-color: #005f8a;
}

/* Profile Settings */
.profile-settings {
    padding: 20px;
}

.profile-settings h2 {
    margin-bottom: 15px;
    color: #0088cc;
}

.profile-settings ul {
    list-style: none;
}

.profile-settings ul li {
    margin-bottom: 10px;
}

.profile-settings ul li a {
    text-decoration: none;
    color: #333333;
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.profile-settings ul li a i {
    margin-right: 10px;
    color: #0088cc;
}

.profile-settings ul li a:hover {
    background-color: #f0f0f0;
}

/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; 
    z-index: 1001; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.5); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto; /* 10% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    max-width: 500px;
    border-radius: 10px;
    position: relative;
}

.close-modal {
    color: #aaaaaa;
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-modal:hover,
.close-modal:focus {
    color: #000;
    text-decoration: none;
}

.edit-modal-content h3 {
    margin-bottom: 15px;
    color: #0088cc;
}

.edit-modal-content textarea {
    width: 100%;
    height: 100px;
    resize: none;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #cccccc;
    border-radius: 5px;
    font-size: 1em;
}

.edit-modal-content button {
    background-color: #0088cc;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

.edit-modal-content button:hover {
    background-color: #005f8a;
}

    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Your Profile</h1>
            <a href="php/logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <div class="profile-content">
            <div class="profile-picture-section">
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-picture">
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <label for="profile_picture" class="upload-button"><i class="fas fa-camera"></i> Change Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;" onchange="this.form.submit()">
                </form>
                <?php if(isset($upload_error)): ?>
                    <p class="error-message"><?php echo $upload_error; ?></p>
                <?php endif; ?>
            </div>

            <div class="profile-info">
                <form action="profile.php" method="POST">
                    <div class="input-group">
                        <label for="username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="status"><i class="fas fa-comment-dots"></i> Status</label>
                        <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($status); ?>">
                    </div>
                    <?php if(isset($update_error)): ?>
                        <p class="error-message"><?php echo $update_error; ?></p>
                    <?php endif; ?>
                    <button type="submit" class="save-button"><i class="fas fa-save"></i> Save Changes</button>
                </form>
            </div>
        </div>

        <div class="profile-settings">
            <h2>Settings</h2>
            <ul>
                <li><a href="#"><i class="fas fa-lock"></i> Privacy</a></li>
                <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Account Settings</a></li>
                <!-- Add more settings options as needed -->
            </ul>
        </div>
    </div>
</body>
</html>
