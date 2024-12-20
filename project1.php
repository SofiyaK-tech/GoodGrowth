<?php
session_start();
$investorId = $_SESSION['investorId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption - Donate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #8BAA30;
            color: white;
            padding: 15px;
            text-align: center;
        }
        main {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        .pet-section {
            display: flex;
            gap: 20px;
        }
        .pet-section img {
            max-width: 200px;
            border-radius: 8px;
        }
        .pet-details {
            flex: 1;
        }
        .form-section {
            margin-top: 40px;
        }
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-full-width {
            grid-column: span 2;
        }
        .button-wrapper {
            grid-column: span 2; /* Ensures the button takes full width in the grid */
            display: flex;
            justify-content: center; /* Centers the button horizontally */
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 20px 80px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            
        }
        button:hover {
            background-color: #45a049;
        }
        .qr-section {
            text-align: center;
            grid-column: span 2;
            margin-bottom: 15px;
        }
        .qr-section img {
            max-width: 150px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Pet Re Homing</h1>
        <p>Help us by adopting a pet or supporting our cause!</p>
    </header>

    <main>
        <h2>Meet Max - The Friendly Dog!</h2>
        <div class="pet-section">
            <img src="dog3.jpg" alt="Max the Dog">
            <div class="pet-details">
                <p><strong>Name:</strong> Max</p>
                <p><strong>Age:</strong> 3 years</p>
                <p><strong>Breed:</strong> Golden Retriever</p>
                <p><strong>Description:</strong> Max is a friendly, playful dog looking for a loving home. He gets along well with children and other pets.</p>
                <p><strong>Adoption Fee:</strong> 20/-</p>
            </div>
        </div>

        <div class="form-section">
            <h2>Support the Cause - Payment Details</h2>
            <form action="transactions.php" method="POST" enctype="multipart/form-data">
    <label for="projectName">Project Name:</label>
    <input type="text" id="projectName" name="ProjectName" required>

    <label for="amount">Money Invested:</label>
    <input type="number" id="amount" name="Amount" required min="1">

    <label for="paymentDate">Payment Date:</label>
   <input type="date" id="paymentDate" name="Date" required>

    <label for="paymentPlatform">Payment Platform:</label>
    <select id="paymentPlatform" name="PaymentPlatform" required>
        <option value="">Select Platform</option>
        <option value="Paypal">Paypal</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Bank Transfer">Bank Transfer</option>
        <option value="UPI">UPI</option>
        <option value="Other">Other</option>
    </select>
    <div class="qr-section">
                    <img src="qr.png" alt="QR Code">
                    <p>Scan this QR code for UPI payment</p>
                </div>

    <label for="paymentTime">Payment Time:</label>
    <input type="time" id="paymentTime" name="PaymentTime" required>

    <label for="paymentScreenshot">Upload Payment Screenshot:</label>
    <input type="file" id="paymentScreenshot" name="PaymentScreenshot" accept="image/*" required>

    <div class="button-wrapper">
                    <button type="submit">Submit Payment Details</button>
                </div>
</form>

        </div>
    </main>
    <script>
    const dateInput = document.getElementById('paymentDate');
    const timeInput = document.getElementById('paymentTime');

    // Set today's date as the only valid date for the payment date
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
    dateInput.setAttribute('max', today);
    dateInput.value = today; // Pre-fill today's date

    // Set the current time as the minimum valid time if today is selected
    function setMinTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const currentTime = `${hours}:${minutes}`;
        
        if (dateInput.value === today) {
            timeInput.setAttribute('min', currentTime); // Restrict time to the current time or later
            timeInput.value = currentTime; // Pre-fill with current time
        } else {
            timeInput.removeAttribute('min'); // Allow any time if another date is selected
        }
    }

    // Run the time restriction logic on page load and whenever the date changes
    setMinTime();
    dateInput.addEventListener('change', setMinTime);
</script>
</body>
</html>
