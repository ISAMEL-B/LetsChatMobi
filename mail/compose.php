<?php include 'process_email.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and other head elements -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #2e8b57; /* Dark green */
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #e0f7fa; /* Light blue form background */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            display: none;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="email"],
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #b0e0e6; /* Light blue border */
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }
        button {
            background-color: #007bff; /* Blue */
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            button {
                padding: 10px;
            }
        }
    </style>
    <script>
        function showMessage(messageType, messageText) {
            const messageDiv = document.getElementById('message');
            if (messageType && messageText) {
                messageDiv.className = `message ${messageType}`;
                messageDiv.textContent = messageText;
                messageDiv.style.display = 'block';
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, messageType === 'success' ? 5000 : 4000);
            }
        }

        // Show message on page load if exists
        window.onload = function() {
            const messageType = "<?php echo htmlspecialchars($messageType); ?>";
            const messageText = "<?php echo htmlspecialchars($message); ?>";
            if (messageType && messageText) {
                showMessage(messageType, messageText);
            }
        };
    </script>
</head>
<body>
    <div class="container">
        <h1>Send Email</h1>

        <?php if (!empty($message)): ?>
            <div id="message" class="message <?php echo htmlspecialchars($messageType); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="email">Recipient Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required>
            
            <label for="message">Message:</label>
            <textarea name="message" id="message-text" rows="4" required></textarea> <!-- Changed id to avoid confusion with the message div -->
            
            <label for="attachment">Attachment (optional):</label>
            <input type="file" name="attachment" id="attachment" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt"> <!-- Added accepted file types -->
            
            <button type="submit" name="submit">Send Email</button> <!-- Added name attribute for submit button -->
        </form>
    </div>
</body>
</html>
