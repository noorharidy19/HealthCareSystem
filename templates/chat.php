<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Group Chat</title>
    <link rel="stylesheet" href="../assets/css/chat.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-title">Support Group Chat</div>
        <div class="chat-history" id="chat-history"></div>
        <input type="text" id="username" placeholder="Enter your username">
        <input type="text" id="room" placeholder="Enter room name" value="{{ room }}" readonly>
        <button id="join-button">Join</button>
        <input type="text" id="user-input" placeholder="Type your message here...">
        <button id="send-button">Send</button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script src="../assets/js/chat.js"></script>
</body>
</html>