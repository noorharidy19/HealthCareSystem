<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Group Chat</title>
    <style>
        /* Add your CSS styles here */
        .chat-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .chat-history {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .message {
            margin: 5px 0;
        }
        .message.user {
            text-align: right;
        }
        .message.bot {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-history" id="chat-history"></div>
        <input type="text" id="username" placeholder="Enter your username">
        <input type="text" id="room" placeholder="Enter room name">
        <button id="join-button">Join</button>
        <input type="text" id="user-input" placeholder="Type your message here...">
        <button id="send-button">Send</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        const socket = io();

        document.getElementById('join-button').addEventListener('click', () => {
            const username = document.getElementById('username').value;
            const room = document.getElementById('room').value;
            socket.emit('join', { username, room });
        });

        document.getElementById('send-button').addEventListener('click', () => {
            const message = document.getElementById('user-input').value;
            const room = document.getElementById('room').value;
            socket.emit('message', { message, room });
            document.getElementById('user-input').value = '';
        });

        socket.on('message', (message) => {
            const chatHistory = document.getElementById('chat-history');
            const messageElement = document.createElement('div');
            messageElement.className = 'message';
            messageElement.textContent = message;
            chatHistory.appendChild(messageElement);
            chatHistory.scrollTop = chatHistory.scrollHeight;
        });
    </script>
</body>
</html>