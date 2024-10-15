    

// Get necessary elements
const sendButton = document.getElementById('sendButton');
const replyInput = document.getElementById('replyInput');
const messagesContainer = document.getElementById('messagesContainer');

// Function to send a message
async function sendMessage() {
    const message = replyInput.value.trim();
    // const contactId = <?php echo json_encode($contact_id); ?>;
    // PHP variable ($contact_id) that is being echoed directly into JavaScript
    // IT HSA REMAINED IN INTERNAL JS (chatting.php)
    if (message === '') {

        // alert('Cannot send an empty message.');
        
        return;
    }

    // Disable send button to prevent multiple clicks
    sendButton.disabled = true;

    try {
        const response = await fetch('send_messages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                contactId: contactId,
                message: message
            })
        });

        const data = await response.json();

        if (data.success) {
            const newMessage = data.message;
            appendMessage(newMessage, true); // true indicates it's a sent message
            replyInput.value = ''; // Clear the input
            scrollToBottom();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while sending the message.');
    } finally {
        sendButton.disabled = false;
    }
}

// Function to append a new message to the chat
function appendMessage(messageData, isSender) {
    const messageCard = document.createElement('div');
    messageCard.classList.add('message-card', isSender ? 'sent' : 'received');

    // Message text
    const messageText = document.createElement('p');
    messageText.innerHTML = nl2br(messageData.message);
    messageCard.appendChild(messageText);

    // Attachment (if any)
    if (messageData.file_path) {
        const attachmentLink = document.createElement('a');
        attachmentLink.href = messageData.file_path;
        attachmentLink.download = messageData.file_name;
        attachmentLink.classList.add('attachment');
        attachmentLink.innerText = `📄 ${messageData.file_name}`;
        messageCard.appendChild(attachmentLink);
    }

    // Message time
    const messageTime = document.createElement('p');
    messageTime.classList.add('message-time');
    messageTime.innerText = formatDate(messageData.time_sent);
    messageCard.appendChild(messageTime);

    // Edit/Delete Actions
    const messageActions = document.createElement('div');
    messageActions.classList.add('message-actions');
    const actionButton = document.createElement('button');
    actionButton.innerHTML = '<i class="fas fa-ellipsis-v"></i>';
    actionButton.onclick = function() {
        openEditModal(messageData.file_id, messageData.message);
    };
    messageActions.appendChild(actionButton);
    messageCard.appendChild(messageActions);

    messagesContainer.appendChild(messageCard);
}

// Function to format the timestamp
function formatDate(datetimeStr) {
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    const date = new Date(datetimeStr);
    return date.toLocaleDateString(undefined, options);
}

// Function to convert newlines to <br>
function nl2br(str) {
    return str.replace(/\n/g, '<br>');
}

// Function to scroll to the bottom of the chat
function scrollToBottom() {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Event listener for send button
sendButton.addEventListener('click', sendMessage);

// Event listener for Enter key press in the textarea
replyInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault(); // Prevent newline insertion
        sendMessage();
    }
});

// Initial scroll to bottom on page load
window.onload = scrollToBottom;

// Optional: Auto-scroll when new messages are appended
const observer = new MutationObserver(scrollToBottom);
observer.observe(messagesContainer, { childList: true });

// Emogi, voice and upload









let currentEditId = null;

// Function to open the edit modal
function openEditModal(fileId, messageText) {
    currentEditId = fileId; // Store the current message ID for editing
    document.getElementById('editMessageInput').value = messageText; // Set the textarea value
    document.getElementById('editModal').style.display = 'block'; // Show the modal
}

// Function to close the edit modal
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none'; // Hide the modal
}

// Function to update the message
function updateMessage() {
    const updatedText = document.getElementById('editMessageInput').value.trim();

    if (updatedText === '') {
        alert("Message cannot be empty.");
        return;
    }

    // AJAX request to update the message
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'edit_message.php', true); // Point to your PHP update file
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            location.reload(); // Refresh the page to show updated message
        } else {
            alert("Failed to update the message.");
        }
    };
    xhr.send('file_id=' + encodeURIComponent(currentEditId) + '&message=' + encodeURIComponent(updatedText));

    closeEditModal(); // Close the modal after sending the request
}

// Function to confirm deletion of a message
function confirmDeleteMessage(fileId) {
    if (confirm("Are you sure you want to delete this message?")) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_message.php', true); // Point to your PHP delete file
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                location.reload(); // Refresh the page to show updated messages
            } else {
                alert("Failed to delete the message.");
            }
        };
        xhr.send('file_id=' + encodeURIComponent(fileId));
    }
}

// // File sending functionality
// const sendButton = document.getElementById('sendButton');
// const replyInput = document.getElementById('replyInput');
// const fileUploadButton = document.getElementById('fileUploadButton');
// const fileInput = document.getElementById('fileInput');
// const messagesContainer = document.getElementById('messagesContainer');

// Trigger the hidden file input when the upload button is clicked
fileUploadButton.addEventListener('click', () => {
    fileInput.click();
});

// Handle the file input change to display the selected file name
fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        displaySelectedFile(fileName);
    } else {
        clearSelectedFile();
    }
});

// Function to display the selected file name
function displaySelectedFile(fileName) {
    let fileDisplay = document.getElementById('fileDisplay');
    if (!fileDisplay) {
        fileDisplay = document.createElement('div');
        fileDisplay.id = 'fileDisplay';
        fileDisplay.style.marginTop = '5px';
        fileDisplay.style.fontStyle = 'italic';
        fileUploadButton.parentNode.insertBefore(fileDisplay, replyInput);
    }
    fileDisplay.textContent = `Selected file: ${fileName}`;
}

// Function to clear the selected file display
function clearSelectedFile() {
    const fileDisplay = document.getElementById('fileDisplay');
    if (fileDisplay) {
        fileDisplay.textContent = '';
    }
}

// Handle the send button click
sendButton.addEventListener('click', () => {
    const message = replyInput.value.trim();
    const file = fileInput.files[0]; // Get the selected file

    // Ensure that either a message or a file is provided
    if (!message && !file) {
        alert("Please enter a message or select a file to send.");
        return;
    }

    // Prepare the data to send
    const formData = new FormData();
    formData.append('message', message);
    formData.append('contact_id', contactId); // Ensure contactId is defined
    if (file) {
        formData.append('file', file);
    }

    // Disable the send button to prevent multiple clicks
    sendButton.disabled = true;
    sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    // Send the data via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_messages.php', true); // Ensure you have this PHP file to handle the request

    xhr.onload = function () {
        sendButton.disabled = false;
        sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';

        if (xhr.status === 200) {
            // Optionally, parse the response and handle it
            console.log(xhr.responseText);
            // Reload or update the messages
            location.reload();
        } else {
            alert("An error occurred while sending the message: " + xhr.responseText);
        }
    };

    xhr.onerror = function () {
        sendButton.disabled = false;
        sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
        alert("An error occurred during the request.");
    };

    xhr.send(formData);
});


// ]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]
        document.addEventListener('DOMContentLoaded', () => {
            // PHP variable ($contact_id) that is being echoed directly into JavaScript
            const contactId = //<? php //echo json_encode($contact_id); ?>;
        
            //let currentEditId = null;
        
            // Function to open the edit modal
            function openEditModal(fileId, messageText) {
                currentEditId = fileId; // Store the current message ID for editing
                document.getElementById('editMessageInput').value = messageText; // Set the textarea value
                document.getElementById('editModal').style.display = 'block'; // Show the modal
            }
        
            // Function to close the edit modal
            function closeEditModal() {
                document.getElementById('editModal').style.display = 'none'; // Hide the modal
            }
        
            // Function to update the message
            function updateMessage() {
                const updatedText = document.getElementById('editMessageInput').value.trim();
        
                if (updatedText === '') {
                    alert("Message cannot be empty.");
                    return;
                }
        
                // AJAX request to update the message
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'edit_message.php', true); // Point to your PHP update file
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        location.reload(); // Refresh the page to show updated message
                    } else {
                        alert("Failed to update the message: " + xhr.responseText);
                        console.error("Update Error:", xhr.responseText);
                    }
                };
                xhr.onerror = function () {
                    alert("An error occurred during the update request.");
                };
                xhr.send('file_id=' + encodeURIComponent(currentEditId) + '&message=' + encodeURIComponent(updatedText));
        
                closeEditModal(); // Close the modal after sending the request
            }
        
            // Function to confirm deletion of a message
            function confirmDeleteMessage(fileId) {
                if (confirm("Are you sure you want to delete this message?")) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'delete_message.php', true); // Point to your PHP delete file
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            location.reload(); // Refresh the page to show updated messages
                        } else {
                            alert("Failed to delete the message: " + xhr.responseText);
                        }
                    };
                    xhr.onerror = function () {
                        alert("An error occurred during the delete request.");
                    };
                    xhr.send('file_id=' + encodeURIComponent(fileId));
                }
            }
        
            // Set up the send button click event
            document.getElementById('sendButton').addEventListener('click', function () {
                const messageInput = document.getElementById('replyInput');
                const messageText = messageInput.value.trim();
        
                if (messageText === '') {
                    alert("Message cannot be empty.");
                    return;
                }
        
                // AJAX request to send the message
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'send_message.php', true); // Point to your PHP send file
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        messageInput.value = ''; // Clear the input after sending
                        location.reload(); // Refresh the page to show the new message
                    } else {
                        alert("Failed to send the message: " + xhr.responseText);
                    }
                };
                xhr.onerror = function () {
                    alert("An error occurred during the send request.");
                };
                xhr.send('contact_id=' + encodeURIComponent(contactId) + '&message=' + encodeURIComponent(messageText));
            });

            // Function to handle file upload
            document.getElementById('fileUploadButton').addEventListener('click', function () {
                document.getElementById('fileInput').click();
            });

            // Handle file input change
            document.getElementById('fileInput').addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('contact_id', contactId);

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'upload_file.php', true); // Point to your PHP upload file
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            location.reload(); // Refresh the page to show the uploaded file
                        } else {
                            alert("Failed to upload the file: " + xhr.responseText);
                        }
                    };
                    xhr.send(formData);
                }
            });

            // Emoji button functionality can be added here if needed
        });
    