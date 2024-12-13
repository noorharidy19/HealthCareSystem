<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Group Chat</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .chat-container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .chat-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #00796b;
        }
        .chat-history {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fafafa;
            border-radius: 5px;
        }
        .message {
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .message.user {
            text-align: right;
            background-color: #e0f7fa;
            color: #00796b;
        }
        .message.bot {
            text-align: left;
            background-color: #e8eaf6;
            color: #3f51b5;
        }
        #username, #room, #user-input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        #join-button, #send-button {
            width: 100%;
            padding: 10px;
            background-color: #00796b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        #join-button:hover, #send-button:hover {
            background-color: #004d40;
        }
    </style>
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
    <script>
        const socket = io();

        document.getElementById('join-button').addEventListener('click', () => {
            const username = document.getElementById('username').value;
            const room = document.getElementById('room').value;
            socket.emit('join', { username, room });
        });

        document.getElementById('send-button').addEventListener('click', () => {
            const username = document.getElementById('username').value;
            const message = document.getElementById('user-input').value;
            const room = document.getElementById('room').value;
            socket.emit('message', { username, message, room });
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