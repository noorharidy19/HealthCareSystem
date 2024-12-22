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