<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Chatbot</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="../assets/css/maicons.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="../assets/vendor/animate/animate.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <link rel="stylesheet" href="../assets/css/chatbot.css">
</head>
<body>
    <header>
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 text-sm">
                        <div class="site-info">
                            <a href="#"><span class="mai-call text-primary"></span> +00 123 4455 6666</a>
                            <span class="divider">|</span>
                            <a href="#"><span class="mai-mail text-primary"></span> mail@example.com</a>
                        </div>
                    </div>
                    <div class="col-sm-4 text-right text-sm">
                        <div class="social-mini-button">
                            <a href="#"><span class="mai-logo-facebook-f"></span></a>
                            <a href="#"><span class="mai-logo-twitter"></span></a>
                            <a href="#"><span class="mai-logo-dribbble"></span></a>
                            <a href="#"><span class="mai-logo-instagram"></span></a>
                        </div>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .container -->
        </div> <!-- .topbar -->

        <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#"><span class="text-primary">One</span>-Health</a>

                <form action="#">
                    <div class="input-group input-navbar">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="icon-addon1"><span class="mai-search"></span></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter keyword.." aria-label="Username" aria-describedby="icon-addon1">
                    </div>
                </form>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupport">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="doctors.php">Doctors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.php">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ml-lg-3" href="#">Login / Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="chatbot.php" id="chatbot-icon" title="chatbot">
                                <i class="fas fa-robot"></i>
                            </a>
                        </li>
                    </ul>
                </div> <!-- .navbar-collapse -->
            </div> <!-- .container -->
        </nav>
    </header>

    <div class="cat-bot-icon">
        <i class="fas fa-robot"></i>
    </div>

    <div class="chat-container">
        <div class="chat-history" id="chat-history">
            <div class="message bot">Healthcare Chatbot: How can I help you?</div>
        </div>
        <div class="chat-message">
            <input type="text" id="user-input" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
    <script>
    // Function to send message to chatbot
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


    document.querySelector('button').addEventListener('click', sendMessage);
</script>

</body>
</html>