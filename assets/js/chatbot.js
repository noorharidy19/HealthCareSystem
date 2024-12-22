

function sendMessage() {
    const userInput = document.getElementById('user-input');
    const chatHistory = document.getElementById('chat-history');
   
    if (userInput.value.trim() !== "") {
        // Display user message
        const userMessage = document.createElement('div');
        userMessage.className = 'message user';
        userMessage.textContent = userInput.value;
        chatHistory.appendChild(userMessage);
   
        // Capture user input
        const prompt = userInput.value;
   
        // Clear input field
        userInput.value = "";
   
        // Send the prompt to the backend
        fetch("http://127.0.0.1:5000/generate", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ prompt: prompt })
        })
        .then(response => response.json())
        .then(data => {
            const botMessage = document.createElement('div');
            botMessage.className = 'message bot';
            if (data.response) {
                botMessage.textContent = data.response; // AI response
            } else {
                botMessage.textContent = "Sorry, there was an error.";
            }
            chatHistory.appendChild(botMessage);
   
            // Scroll to the bottom
            chatHistory.scrollTop = chatHistory.scrollHeight;
        })
        .catch(error => {
            console.error("Error:", error);
            const errorMessage = document.createElement('div');
            errorMessage.className = 'message bot';
            errorMessage.textContent = "There was an error connecting to the server.";
            chatHistory.appendChild(errorMessage);
        });
    }
   }
   document.getElementById("image-input").addEventListener("change", handleImageUpload);
   
   
   function handleImageUpload(event) {
    const chatHistory = document.getElementById("chat-history");
    const file = event.target.files[0];
    if (!file) return;
   
    // Display user's image in the chat
    const imageMessage = document.createElement('div');
    imageMessage.className = 'message user';
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.style.maxWidth = '200px'; // Adjust the size as needed
    imageMessage.appendChild(img);
    chatHistory.appendChild(imageMessage);
   
    // Send image to the backend for text extraction (OCR)
    const formData = new FormData();
    formData.append("image", file);
   
    fetch("http://127.0.0.1:5000/upload", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const botMessage = document.createElement('div');
        botMessage.className = 'message bot';
        if (data.response) {
            botMessage.textContent = data.response; // AI response
        } else {
            botMessage.textContent = "Sorry, there was an error extracting text from the image.";
        }
        chatHistory.appendChild(botMessage);
   
        // Scroll to the bottom
        chatHistory.scrollTop = chatHistory.scrollHeight;
    })
    .catch(error => {
        console.error("Error:", error);
        const errorMessage = document.createElement('div');
        errorMessage.className = 'message bot';
        errorMessage.textContent = "There was an error connecting to the server.";
        chatHistory.appendChild(errorMessage);
    });
   }
   // Event listener for image input
   document.getElementById('image-input').addEventListener('change', function(event) {
    const imageFile = event.target.files[0];
    if (imageFile) {
        sendImage(imageFile);
    }
   });
   
   // Add event listener for the Enter key
   document.getElementById('user-input').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent default action (like form submission)
        sendMessage();
    }
   });
   // New Speech Recognition function
   const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
   recognition.lang = 'en-US'; // Set the language for speech recognition
   recognition.interimResults = false;
   
   // Function to handle the speech input
   function startSpeechRecognition() {
       recognition.start(); // Start speech recognition
   }
   
   // Event listener for speech recognition results
   recognition.onresult = function(event) {
       const speechText = event.results[0][0].transcript; // Get the recognized text
       const userInput = document.getElementById('user-input');
       userInput.value = speechText; // Set the recognized speech into the input field
   
       sendMessage(); // Automatically send the message
   };
   
   // Handle errors during speech recognition
   recognition.onerror = function(event) {
       console.error('Speech recognition error:', event.error);
   };
   
   // Add event listener for the speech button
   document.getElementById('speakButton').addEventListener('click', startSpeechRecognition);
   