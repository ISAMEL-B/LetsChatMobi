<?php
include 'contact_fetch.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts List</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="css/all.min.css">
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/contacts.css">
    <style>
        .spinner {
            width: 30px; /* Width of the spinner */
            height: 30px; /* Height of the spinner */
            border: 5px solid #f3f3f3; /* Light gray */
            border-top: 5px solid #3498db; /* Blue */
            border-radius: 50%;
            animation: spin 1s linear infinite; /* Animation */
            margin: 10px; /* Margin around the spinner */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
 
<body>
    <div class="container">
        <div>
            <!-- Include the Hamburger Menu -->
            <?php include 'cd_hamburger.php'; ?>
        </div>
        <!-- Refresh Button -->
        <button type="button" class="refresh-button" onclick="window.location.reload();">
            <i class="fas fa-sync-alt"></i> <!-- Font Awesome sync icon -->
        </button>
        <h1 class="contact-heading">Contacts</h1>
        <div class="input-group">
            <input type="text" id="searchInput" placeholder="Search contacts..." />
        </div>
        <div id="loadingSpinner" class="spinner" style="display: none;"></div>
        <div id="searchMessage"></div>

        <!-- Cards Container -->
        <div class="cards-container">
            <?php
                // Check if there are any contacts to display
                if ($result->num_rows > 0) {
                    $cardCount = 0; // Initialize a counter for the number of cards

                    // First loop to count cards
                    while ($row = $result->fetch_assoc()) {
                        $lastSentMessage = htmlspecialchars($row['last_sent_message']);
                        $lastReceivedMessage = htmlspecialchars($row['last_received_message']);
                        
                        // Check if there is at least one sent or received message
                        if ($lastSentMessage || $lastReceivedMessage) {
                            $cardCount++; // Increment the card count
                        }
                    }

                    // Reset result pointer
                    $result->data_seek(0); 

                    // Output each contact as a card
                    while ($row = $result->fetch_assoc()) {
                        $unreadCount = $row['unread_count'];
                        $contactName = htmlspecialchars($row['username']);
                        // Check if the contact is the current user
                        if ($row['office_id'] == $current_office_id) {
                            $contactName .= " [myself]"; // Append "[myself]" to the username
                        }

                        // Sent message details
                        $lastSentMessage = htmlspecialchars($row['last_sent_message']);
                        $lastSentTime = ($row['last_sent_time']) ? date('h:i A', strtotime($row['last_sent_time'])) : null; 
                        
                        // Received message details
                        $lastReceivedMessage = htmlspecialchars($row['last_received_message']);
                        $lastReceivedTime = ($row['last_received_time']) ? date('h:i A', strtotime($row['last_received_time'])) : null; 
                        
                        $contactId = $row['office_id'];

                        // Check if there is at least one sent or received message
                        if ($lastSentMessage || $lastReceivedMessage) {
                            // Apply class for larger card if there is only one card
                            $cardClass = ($cardCount === 1) ? 'single-card' : '';

                            echo "<a href='chatting.php?contactId=$contactId' style='text-decoration: none; color: inherit;' onclick='markAsRead($contactId)'>
                                    <div class='card $cardClass' data-id='$contactId'>
                                        <div class='profile-img'></div>
                                        <div class='message-info'>
                                            <h2>$contactName</h2>";
                            
                            if ($unreadCount > 0) {
                                echo "<span class='badge'>$unreadCount</span>";
                            }

                            echo "</div>
                                    <div class='message-cards'>";

                            // Only display the sent message if it exists
                            if ($lastSentMessage) {
                                echo "<div class='message-card sent-card'>
                                        <p class='last-sent-message' style='color: blue;'><strong>Last Sent:</strong> $lastSentMessage</p>
                                        <span class='last-message-time'>$lastSentTime</span>
                                    </div>";
                            } else {
                                // Display no messages if last sent message is empty
                                echo "<div class='message-card sent-card'>
                                        <p class='no-messages'>No messages sent</p>
                                    </div>";
                            }

                            // Only display the received message if it exists
                            if ($lastReceivedMessage) {
                                echo "<div class='message-card received-card'>
                                        <p class='last-received-message' style='color: black;'><strong>Received:</strong> $lastReceivedMessage</p>
                                        <span class='last-message-time'>$lastReceivedTime</span>
                                    </div>";
                            } else {
                                // Display no messages if last received message is empty
                                echo "<div class='message-card received-card'>
                                        <p class='no-messages'>No messages received</p>
                                    </div>";
                            }

                            echo "</div>
                                </div>
                            </a>";
                        }
                    }
                } else {
                    echo "<div class='card' style='text-align: center;'><p>No contacts found.</p></div>";
                }
            ?>
        </div>  
    </div>
    <script>
        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        const searchMessage = document.getElementById('searchMessage');
        const cardsContainer = document.querySelector('.cards-container');

        searchInput.addEventListener('input', function () {
            const searchText = this.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.card');

            let found = false;
            cards.forEach(card => {
            const username = card.querySelector('.message-info h2').textContent.toLowerCase();
            if (username.includes(searchText)) {
                card.style.display = 'flex'; // Show the card
                found = true;
            } else {
                card.style.display = 'none'; // Hide the card
            }
        });

        // If no contacts are found, search the database via AJAX
        if (!found) {
            searchMessage.textContent = ''; // Clear any previous message
            searchDatabase(searchText); // Call the function to search the database
        } else {
            searchMessage.textContent = ''; // Clear the message if contacts are found
        }
    });

    // Function to search the database via AJAX
    function searchDatabase(searchText) {
        // Show loading spinner
        const loadingSpinner = document.getElementById('loadingSpinner');
        loadingSpinner.style.display = 'block'; // Display the spinner

        // Simulating AJAX call with setTimeout
        setTimeout(() => {
            // Hide loading spinner after 1 second
            loadingSpinner.style.display = 'none';
            
            // Display the 'No contacts found' message after 1 second
            searchMessage.textContent = 'No contacts found.';

            // Implement actual AJAX call here if needed
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `search_contacts.php?query=${searchText}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const results = xhr.responseText;
                    // Update cards container with new results
                    cardsContainer.innerHTML = results;  // Replace existing cards with new results

                    // If there are results, clear the 'No contacts found' message
                    if (results.trim().length > 0) {
                        searchMessage.textContent = ''; // Clear the message if results are found
                    }
                } else {
                    searchMessage.textContent = 'No contacts found.'; // Handle the case if no contacts found
                }
            };
            xhr.send();
        }, 1000); // 1000 ms = 1 second
    }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
