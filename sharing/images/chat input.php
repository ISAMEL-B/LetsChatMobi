<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp-like Chat Input</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        /* Chat container */
        .chat-container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Input field container */
        .input-container {
            display: flex;
            align-items: center;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 25px;
            border: 1px solid #ddd;
        }

        /* Text area */
        .chat-input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            resize: none;
            overflow: hidden;
            height: 40px;
            max-height: 100px;
            outline: none;
        }

        /* Icon buttons */
        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
            margin: 0 10px;
        }

        /* Send button */
        .send-button {
            background-color: #25D366;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Icons */
        .icon-button img {
            width: 24px;
            height: 24px;
        }

        .send-button img {
            width: 18px;
            height: 18px;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <!-- Input container -->
    <div class="input-container">
        <!-- Attachment button -->
        <button class="icon-button">
            <img src="https://image.flaticon.com/icons/png/512/1828/1828784.png" alt="Attachment Icon">
        </button>

        <!-- Emoji button -->
        <button class="icon-button">
            <img src="https://image.flaticon.com/icons/png/512/1828/1828764.png" alt="Emoji Icon">
        </button>

        <!-- Text input (expanding textarea) -->
        <textarea class="chat-input" placeholder="Type a message"></textarea>

        <!-- Send button -->
        <button class="send-button">
            <img src="https://image.flaticon.com/icons/png/512/1828/1828640.png" alt="Send Icon">
        </button>
    </div>
</div>

<script>
    // Auto-expand textarea as user types
    const chatInput = document.querySelector('.chat-input');

    chatInput.addEventListener('input', function() {
        // Reset the height
        chatInput.style.height = '40px';
        // Set the height according to scroll height
        chatInput.style.height = (chatInput.scrollHeight) + 'px';
    });
</script>


document.getElementById('uploadButton').onclick = function() {
    document.getElementById('fileUpload').click();
};

function handleFileUpload(event) {
    const files = event.target.files;
    // Handle the uploaded files here
    console.log(files);
}




</body>
</html>
