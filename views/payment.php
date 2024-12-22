<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Payment</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
       * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f6f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 20px;
}

.container {
    width: 350px;
    max-width: 100%;
    perspective: 1000px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    overflow: hidden;
    background: white;
    padding: 20px;
}

.card {
    width: 100%;
    height: 200px;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.6s;
    border-radius: 15px;
}

.card.flipped {
    transform: rotateY(180deg);
}

.front, .back {
    width: 100%;
    height: 100%;
    position: absolute;
    backface-visibility: hidden;
    border-radius: 15px;
}

.front {
    background-color: black; /* Dark background */
    color: white;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    font-family: 'Helvetica Neue', sans-serif;
}

.back {
    background-color: #2c3e50;
    color: white;
    transform: rotateY(180deg);
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.strip {
    height: 40px;
    background-color: #34495e;
    border-radius: 10px;
    margin-bottom: 20px;
}

.logo {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    height: 30px;
}

.number, .name, .expiry, .cvv {
    font-size: 16px;
    font-weight: bold;
}

.number {
    font-size: 22px;
    letter-spacing: 2px;
}

.expiry {
    font-size: 16px;
}

/* Card Chip */
.chip {
    width: 45px;
    height: 30px;
    background-color: #d1af66;
    border-radius: 5px;
    display: inline-block;
    position: relative;
}

.chip::after {
    content: '';
    position: absolute;
    width: 5px;
    height: 20px;
    background-color: #fff;
    left: 50%;
    top: 5px;
    transform: translateX(-50%);
}

/* Card Hologram */
.hologram {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff9966, #ff5f5f);
    display: inline-block;
    margin-top: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

/* Added specific styling for the card number and name */
.number {
    font-size: 20px;
    letter-spacing: 3px;
    color: white;
}

.name {
    font-size: 16px;
    color: white;
}

.expiry {
    font-size: 14px;
    color: white;
}

/* Button and form */
form {
    margin-top: 30px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 16px;
    transition: all 0.3s;
}

input:focus {
    border-color: #4c6ef5;
    background-color: #f1f8ff;
    outline: none;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #4c6ef5;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #3e58e1;
}

.form-group input::placeholder {
    color: #aaa;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="card" id="creditCard">
            <div class="front">
                <div class="strip"></div>
                <div class="logo">
                    <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa">
                    <div class="chip"></div>
                </div>
                <div class="number" id="card-number-display">#### #### #### ####</div>
                <div class="name" id="card-name-display">CardHolder Name</div>
                <div class="expiry" id="card-expiry-display">MM/YY</div>
                <div class="hologram"></div>
            </div>
            <div class="back">
                <div class="strip"></div>
                <div class="cvv" id="card-cvv-display">###</div>
            </div>
        </div>
        <form id="paymentForm">
            <div class="form-group">
                <label for="cardNumber">Card Number</label>
                <input type="text" id="cardNumber" maxlength="16" required placeholder="#### #### #### ####">
            </div>
            <div class="form-group">
                <label for="cardName">Cardholder Name</label>
                <input type="text" id="cardName" required placeholder="CardHolder Name">
            </div>
            <div class="form-group">
                <label for="expiryDate">Expiry Date</label>
                <input type="text" id="expiryDate" maxlength="5" placeholder="MM/YY" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" maxlength="3" required placeholder="###">
            </div>
            <button type="submit">Submit Payment</button>
        </form>
    </div>

    <script>
        // Update card details in real-time
        document.getElementById('cardNumber').addEventListener('input', function() {
            let formattedCardNumber = this.value.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim();
            document.getElementById('card-number-display').textContent = formattedCardNumber || '#### #### #### ####';
        });

        document.getElementById('cardName').addEventListener('input', function() {
            document.getElementById('card-name-display').textContent = this.value || 'John Doe';
        });

        document.getElementById('expiryDate').addEventListener('input', function() {
            document.getElementById('card-expiry-display').textContent = this.value || 'MM/YY';
        });

        document.getElementById('cvv').addEventListener('focus', function() {
            // Trigger card flip when CVV input is focused
            document.getElementById('creditCard').classList.add('flipped');
        });

        document.getElementById('cvv').addEventListener('blur', function() {
            // Reverse card flip when CVV input loses focus
            document.getElementById('creditCard').classList.remove('flipped');
        });

        document.getElementById('cvv').addEventListener('input', function() {
            document.getElementById('card-cvv-display').textContent = this.value || '###';
        });
    </script>
</body>
</html>
