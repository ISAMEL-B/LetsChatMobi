<?php include 'chat_user_fetch.php'; ?>
<!DOCTYPE html>
<html lang="en" data-user-id="<?php echo htmlspecialchars($current_office_id); ?>" data-selected-sender-id="<?php echo htmlspecialchars($contact_id); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo htmlspecialchars($contact_name); ?></title>
    <link rel="stylesheet" href="css/chatting.css">
    <link rel="stylesheet" href="css/chatting2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="overlay" id="overlay"></div>
    <div class="container">
        <div class="hamburger-container">
            <?php include 'cd_hamburger.php'; ?>
        </div>

        <div class="card-container chat-frame">
            <div class="chat-header">
                <div style="display: flex; align-items: center;">
                    <img src="user.png" alt="Contact" style="width:50px; height:50px; border-radius:50%; margin-right:10px;">
                    <h2><?php echo htmlspecialchars($contact_name); ?></h2>
                </div>
            </div>

            <div class="message-container" id="messagesContainer">
                <?php
                if ($messages_result->num_rows > 0) {
                    while ($message = $messages_result->fetch_assoc()) {
                        $is_sender = ($message['sender_office_id'] == $current_office_id);
                        $message_class = $is_sender ? 'sent' : 'received';
                        $message_text = htmlspecialchars($message['message']);
                        $message_time = htmlspecialchars(date('d M, Y, H:i', strtotime($message['time_sent'])));
                        $file_path = htmlspecialchars($message['file_path']);
                        $file_name = htmlspecialchars($message['file_name']);
                        $file_id = $message['file_id'];

                        $tick_class = 'tick';
                        if ($message['is_read'] == 1) {
                            $tick_class .= ' green';
                        } elseif ($message['is_read'] == 0) {
                            $tick_class .= ''; // Keep it black
                        } else {
                            $tick_class .= ' brown';
                        }

                        echo '<div class="message-card ' . $message_class . '">';
                        echo '<p>' . nl2br($message_text) . '</p>';
                        
                        if (!empty($file_path)) {
                            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                            if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                echo '<img src="' . $file_path . '" alt="' . $file_name . '" class="message-image" onclick="openImage(\'' . $file_path . '\')">';
                            } elseif (in_array($file_extension, ['mp3', 'wav', 'ogg'])) {
                                echo '<audio controls class="message-audio">
                                        <source src="' . $file_path . '" type="audio/' . ($file_extension === 'mp3' ? 'mpeg' : $file_extension) . '">
                                        Your browser does not support the audio element.
                                      </audio>';
                            } elseif (in_array($file_extension, ['mp4', 'webm', 'ogv'])) {
                                echo '<video controls class="message-video">
                                        <source src="' . $file_path . '" type="video/' . ($file_extension === 'mp4' ? 'mp4' : $file_extension) . '">
                                        Your browser does not support the video tag.
                                      </video>';
                            } else {
                                echo '<a href="' . $file_path . '" download class="attachment">📄 ' . $file_name . '</a>';
                            }
                        }

                        echo '<p class="message-time">' . $message_time . '</p>';
                        echo '<div class="message-actions">';

                    if ($is_sender) {
                        // Show both edit and delete buttons for sent messages
                        echo '<div class="edit-action"><button onclick="openEditModal(' . $file_id . ', \'' . addslashes($message_text) . '\')"><i class="fas fa-edit"></i></button></div>';
                        echo '<div class="delete-action"><button onclick="confirmDeleteMessage(' . $file_id . ')"><i class="fas fa-trash"></i></button></div>';
                    } else {
                        // Show only delete button for received messages
                        echo '<div class="delete-action"><button onclick="confirmDeleteMessage(' . $file_id . ')"><i class="fas fa-trash"></i></button></div>';
                    }

                    echo '</div>';

                        if ($is_sender) {
                             echo '<span class="' . $tick_class . '"><i class="fas fa-check"></i></span>';
                        }
                        
                        echo '</div>'; // Close message card
                    }
                }
                ?>
            </div>

            <!-- Display file name here -->
            <div class="file-name-display" id="fileNameDisplay"></div>

            <div class="reply-area">
                <button id="emojiButton" class="reply-button" onclick="alert('Emoji picker will be implemented soon!')"><i class="fas fa-smile"></i></button>
                <button id="micButton" class="reply-button" onclick="alert('Voice recording will be implemented soon!')"><i class="fas fa-microphone"></i></button>
                <button id="fileUploadButton" class="reply-button"><i class="fas fa-paperclip"></i></button>
                <input type="file" id="fileInput" name="fileInput" style="display: none;">
                <textarea class="reply-input" id="replyInput" placeholder="Type a message"></textarea>
                <button class="send-button" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>

            <!-- Refresh Button -->
            <button class="refresh-button" id="refreshButton" title="Refresh Messages">
                <i class="fas fa-sync-alt"></i>
                <div class="spinner"></div>
            </button>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeEditModal()">&times;</span>
            <div class="edit-modal-content">
                <h3>Edit Message</h3>
                <textarea id="editMessageInput" placeholder="Edit your message"></textarea>
                <button onclick="updateMessage()">Update</button>
            </div>
        </div>
    </div>

    <script>
    let currentEditId = null;

    function openEditModal(fileId, messageText) {
        currentEditId = fileId;
        document.getElementById('editMessageInput').value = messageText;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function updateMessage() {
        const updatedText = document.getElementById('editMessageInput').value.trim();

        if (updatedText === '') {
            alert("Message cannot be empty.");
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'edit_message.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                location.reload();
            } else {
                alert("Failed to update the message.");
            }
        };
        xhr.send('file_id=' + encodeURIComponent(currentEditId) + '&message=' + encodeURIComponent(updatedText));

        closeEditModal();
    }

    function confirmDeleteMessage(fileId) {
        if (confirm("Are you sure you want to delete this message?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_message.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    alert("Failed to delete the message.");
                }
            };
            xhr.send('file_id=' + encodeURIComponent(fileId));
        }
    }

    function sendMessage() {
        const replyMessage = document.getElementById('replyInput').value.trim();
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0]; // Get the selected file

        if (!replyMessage && !file) {
            alert("Please enter a message or select a file to send.");
            return;
        }

        const formData = new FormData();
        formData.append('reply_message', replyMessage);
        formData.append('receiver_id', <?php echo $contact_id; ?>); // Ensure contactId is defined
        if (file) {
            formData.append('file', file);
        }

        const sendButton = document.getElementById('sendButton');
        sendButton.disabled = true;
        sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_reply.php', true);
        xhr.onload = function () {
            sendButton.disabled = false;
            sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        appendNewMessage(response.message);
                        document.getElementById('replyInput').value = ''; // Clear input after sending
                        document.getElementById('fileInput').value = ''; // Clear file input after sending
                        document.getElementById('fileNameDisplay').textContent = ''; // Clear displayed file name
                    } else {
                        alert("Failed to send the message: " + response.error);
                    }
                } catch (e) {
                    alert("Unexpected response from server.");
                }
            } else {
                alert("Failed to send the message.");
            }
        };

        xhr.send(formData);
    }

    function appendNewMessage(newMessage) {
        const messagesContainer = document.getElementById('messagesContainer');

        const messageCard = document.createElement('div');
        messageCard.className = 'message-card sent';

        const messageText = document.createElement('p');
        messageText.textContent = newMessage.message;
        messageCard.appendChild(messageText);

        if (newMessage.file_path) {
            const fileExtension = newMessage.file_name.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                const img = document.createElement('img');
                img.src = newMessage.file_path;
                img.alt = newMessage.file_name;
                img.className = 'message-image';
                img.style.cursor = 'pointer';
                img.onclick = function() { openImage(newMessage.file_path); };
                messageCard.appendChild(img);
            } else if (['mp3', 'wav', 'ogg'].includes(fileExtension)) {
                const audio = document.createElement('audio');
                audio.controls = true;
                const source = document.createElement('source');
                source.src = newMessage.file_path;
                source.type = `audio/${fileExtension === 'mp3' ? 'mpeg' : fileExtension}`;
                audio.appendChild(source);
                audio.innerHTML = "Your browser does not support the audio element.";
                messageCard.appendChild(audio);
            } else if (['mp4', 'webm', 'ogv'].includes(fileExtension)) {
                const video = document.createElement('video');
                video.controls = true;
                video.className = 'message-video'; // Use the same class for styling
                const source = document.createElement('source');
                source.src = newMessage.file_path;
                source.type = `video/${fileExtension === 'mp4' ? 'mp4' : fileExtension}`;
                video.appendChild(source);
                video.innerHTML = "Your browser does not support the video tag.";
                messageCard.appendChild(video);
            } else {
                const attachment = document.createElement('a');
                attachment.href = newMessage.file_path;
                attachment.download = newMessage.file_name;
                attachment.className = 'attachment';
                attachment.textContent = `📄 ${newMessage.file_name}`;
                messageCard.appendChild(attachment);
            }
        }

        const messageTime = document.createElement('p');
        messageTime.className = 'message-time';
        const timeSent = new Date(newMessage.time_sent);
        messageTime.textContent = timeSent.toLocaleString();
        messageCard.appendChild(messageTime);

        const messageActions = document.createElement('div');
        messageActions.className = 'message-actions';

        const editAction = document.createElement('div');
        editAction.className = 'edit-action';
        const editButton = document.createElement('button');
        editButton.onclick = function() { openEditModal(newMessage.file_id, newMessage.message); };
        editButton.innerHTML = '<i class="fas fa-edit"></i>';
        editAction.appendChild(editButton);
        messageActions.appendChild(editAction);

        const deleteAction = document.createElement('div');
        deleteAction.className = 'delete-action';
        const deleteButton = document.createElement('button');
        deleteButton.onclick = function() { confirmDeleteMessage(newMessage.file_id); };
        deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
        deleteAction.appendChild(deleteButton);
        messageActions.appendChild(deleteAction);

        messageCard.appendChild(messageActions);

        const tick = document.createElement('span');
        tick.className = 'tick';
        tick.innerHTML = '<i class="fas fa-check"></i>';
        messageCard.appendChild(tick);

        messagesContainer.appendChild(messageCard);
        messagesContainer.scrollTop = messagesContainer.scrollHeight; // Scroll to bottom
    }

    // Refresh Messages Function
    function refreshMessages() {
        const refreshButton = document.getElementById('refreshButton');

        // Show loading spinner
        refreshButton.classList.add('loading');

        // Refresh the entire page
        location.reload();
    }

    document.getElementById('refreshButton').addEventListener('click', refreshMessages);

    // File input handling
    const fileInput = document.getElementById('fileInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name; // Display the selected file name
        } else {
            fileNameDisplay.textContent = ''; // Clear if no file selected
        }
    });

    document.getElementById('fileUploadButton').addEventListener('click', function() {
        fileInput.click(); // Trigger the file input click
    });

    function openImage(imageUrl) {
        const overlay = document.getElementById('overlay');
        overlay.style.display = 'flex'; // Make the overlay visible

        const img = document.createElement('img');
        img.src = imageUrl;
        img.style.width = '79%';
        img.style.height = 'auto'; // Maintain aspect ratio
        img.style.borderRadius = '10px'; // Rounded corners
        overlay.innerHTML = ''; // Clear previous content
        overlay.appendChild(img); // Add new image
    }

    overlay.addEventListener('click', function() {
        overlay.style.display = 'none'; // Hide overlay on click
    });

    // Send button event listener
    document.getElementById('sendButton').addEventListener('click', sendMessage);

    // Enter key sends the message
    document.getElementById('replyInput').addEventListener('keypress', function(event) {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault(); // Prevent newline
            sendMessage(); // Call sendMessage function
        }
    });
    </script>
</body>
</html>
