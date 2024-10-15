
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamburger Menu Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
            overflow: hidden; /* Prevent scrolling when sidebar is open */
        }

        /* Hamburger Icon */
        .hamburger {
            font-size: 30px;
            cursor: pointer;
            position: fixed;
            top: 20px;
            left: 10px;
            z-index: 1000;
            color: #333;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px; /* Initially hidden */
            width: 250px;
            height: 100%;
            background-color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            transition: left 0.3s ease-in-out;
            z-index: 999;
            display: flex;
            flex-direction: column;
        }

        .sidebar.active {
            left: 0; /* Slide in from the left */
        }

        .profile-section {
            padding: 20px;
            text-align: center;
            background-color: #f5f5f5;
        }

        .profile-picture {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            font-size: 20px; /* Adjust icon size */
            margin-right: 10px; /* Space between icon and text */
        }

        .sidebar ul li:hover {
            background-color: #f0f0f0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            display: none; /* Initially hidden */
        }

        .overlay.active {
            display: block; /* Show overlay when active */
        }
    </style>
</head>
<body>
    <!-- Hamburger Icon -->
    <div class="hamburger" id="hamburger">&#9776;</div>

    <!-- Dark overlay when sidebar is active -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="profile-section">
            <img src="user.png" alt="Profile Picture" class="profile-picture">
            <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3> <!-- Assuming username is stored in session -->
        </div>
        <ul>
            <li><a href="contacts.php"><i class="fas fa-inbox"></i> Chats</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="../../more/privacy_and_policy.php"><i class="fas fa-lock"></i> Privacy & Policy</a></li>
            <li><a href="../../more/terms_of_use.php"><i class="fas fa-file-alt"></i> Terms & Conditions</a></li>
            <li><a href="../../register/forgot/forgot_password.php"><i class="fas fa-comments"></i> Change Password</a></li>
            <li><a href="../../mail/compose.php"><i class="fas fa-comments"></i> Contact Us</a></li>
            <li class="../logout"><a href="../../register/register.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <script>
        // Get elements
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const hamburger = document.getElementById('hamburger');

        // Show sidebar and overlay on hamburger click
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        // Hide sidebar and overlay when tapping outside
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>
