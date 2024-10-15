<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0); // Keep the script running

$host = '127.0.0.1'; // Your host
$port = 8080; // Port to listen on

// Create a TCP/IP socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die('Could not create socket: ' . socket_strerror(socket_last_error()));
}

socket_bind($socket, $host, $port);
socket_listen($socket);

$clients = [];

// Function to handle WebSocket handshake
function doHandshake($clientSocket, $headers) {
    $key = null;
    foreach ($headers as $header) {
        if (preg_match('/Sec-WebSocket-Key: (.*)$/', $header, $matches)) {
            $key = trim($matches[1]);
        }
    }
    $acceptKey = base64_encode(pack('H*', sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $response = "HTTP/1.1 101 Switching Protocols\r\n" .
                "Upgrade: websocket\r\n" .
                "Connection: Upgrade\r\n" .
                "Sec-WebSocket-Accept: $acceptKey\r\n\r\n";
    socket_write($clientSocket, $response, strlen($response));
}

// Function to unmask the message
function unmask($text) {
    $length = ord($text[1]) & 127;
    if ($length === 126) {
        $length = unpack('n', substr($text, 2, 2))[1];
        $mask = substr($text, 4, 4);
        $data = substr($text, 8);
    } elseif ($length === 127) {
        // Handle large messages (not implemented for simplicity)
        return '';
    } else {
        $mask = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    return $data ^ str_repeat($mask, ceil(strlen($data) / 4));
}

// Function to mask the message
function mask($text) {
    $length = strlen($text);
    $mask = str_repeat(chr(rand(0, 255)), 4);
    $maskedData = '';
    for ($i = 0; $i < $length; $i++) {
        $maskedData .= $text[$i] ^ $mask[$i % 4];
    }
    return chr(129) . (strlen($maskedData) < 126 ? chr(strlen($maskedData)) : chr(126)) . $mask . $maskedData;
}

while (true) {
    $readSockets = array_merge([$socket], $clients);
    socket_select($readSockets, $null, $null, 0, 10);

    // Accept new connections
    if (in_array($socket, $readSockets)) {
        $clientSocket = socket_accept($socket);
        $clients[] = $clientSocket;
        $headers = socket_read($clientSocket, 1024);
        doHandshake($clientSocket, explode("\r\n", $headers));
        socket_getpeername($clientSocket, $ip);
        echo "Client connected: $ip\n";
        $readSockets = array_diff($readSockets, [$socket]);
    }

    // Handle messages from clients
    foreach ($readSockets as $readSocket) {
        $data = @socket_read($readSocket, 1024, PHP_NORMAL_READ);
        if ($data === false) {
            // Remove client if disconnected
            $index = array_search($readSocket, $clients);
            unset($clients[$index]);
            echo "Client disconnected\n";
            continue;
        }

        // Decode the message
        $message = unmask($data);
        echo "Received message: $message\n";

        // Broadcast message to all clients
        foreach ($clients as $client) {
            socket_write($client, mask($message), strlen(mask($message)));
        }
    }
}
?>
