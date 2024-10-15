<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef; /* Light gray background */
            margin: 0;
            padding: 20px;
        }

        .settings-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 600px; /* Max width for the settings container */
            margin: auto; /* Center the container */
            background-color: #fff; /* White background for the settings */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
            overflow: hidden; /* Prevent overflow */
        }

        .settings-header {
            background-color: #0088cc; /* Header color similar to Telegram */
            color: white; /* Text color */
            padding: 15px;
            text-align: center;
            font-size: 1.5em; /* Header font size */
        }

        .message-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 480px; /* Fixed height */
            background-image: url('whitep.png'); /* Background image */
            background-size: contain; /* Contain the image */
            background-repeat: repeat; /* Repeat the image */
            background-position: center top; /* Position at the top */
            overflow-y: auto; /* Vertical scrolling */
            border: 1px solid #ccc; /* Border around the container */
            padding: 6px; /* Padding inside the container */
            border-radius: 5px; /* Rounded corners */
            background-color: rgba(249, 249, 249, 0.8); /* Light background with transparency */
        }

        .setting-item {
            padding: 15px;
            border-bottom: 1px solid #ddd; /* Divider between items */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth background change */
        }

        .setting-item:hover {
            background-color: #f0f0f0; /* Background color on hover */
        }

        .setting-title {
            font-size: 1.2em; /* Title font size */
            margin-bottom: 5px; /* Space below title */
        }

        .setting-description {
            font-size: 0.9em; /* Description font size */
            color: #555; /* Description text color */
        }
 
        .setting-item {
            display: block; /* Makes the anchor behave like a block-level element */
            padding: 20px; /* Adds space inside the div */
            background-color: #f8f9fa; /* Light background color */
            border-radius: 5px; /* Rounded corners */
            text-decoration: none; /* Removes underline from the link */
            color: #333; /* Dark text color */
            transition: background-color 0.3s; /* Smooth background color transition */
        }

        .setting-item:hover {
            background-color: #e2e6ea; /* Darker background on hover */
        }

        .setting-title {
            font-weight: bold; /* Makes the title bold */
            font-size: 1.2em; /* Increases the font size */
        }

        .setting-description {
            font-size: 0.9em; /* Sets a slightly smaller font size for the description */
            color: #666; /* Light color for the description */
        }

        .footer {
            padding: 15px;
            text-align: center;
            font-size: 0.8em;
            color: #888; /* Footer text color */
        }
    </style>
</head>
<body>
<?php include "cd_hamburger.php";?>
    <div class="settings-container">
        <div class="settings-header">Settings</div>
        <div class="message-container">
            <div class="setting-item">
                <div class="setting-title">Account</div>
                <div class="setting-description">Manage your account settings</div>
            </div>
            <div class="setting-item">
                <div class="setting-title">Privacy</div>
                <div class="setting-description">Control who can see your information</div>
            </div>
            <div class="setting-item">
                <div class="setting-title">Notifications</div>
                <div class="setting-description">Customize your notification preferences</div>
            </div>
            <div class="setting-item">
                <div class="setting-title">Data and Storage</div>
                <div class="setting-description">Manage your data usage and storage settings</div>
            </div>
            <div class="setting-item">
                <div class="setting-title">Chat Settings</div>
                <div class="setting-description">Adjust your chat appearance and behavior</div>
            </div>
            <div class="setting-item">
                <div class="setting-title">About</div>
                <div class="setting-description">Learn more about this app</div>
            </div>
            <a href="../../register/delete_account/home.php" class="setting-item">
                <div class="setting-title">Security</div>
                <div class="setting-description">More about your account</div>
            </a>
        </div>
        <div class="footer">© 2024 BI</div>
    </div>

</body>
</html>
