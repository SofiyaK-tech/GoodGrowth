<?php
session_start();
$investorId = $_SESSION['investorId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Adoption - Donate</title>
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
        .plant-section {
            display: flex;
            gap: 20px;
        }
        .plant-section img {
            max-width: 200px;
            border-radius: 8px;
        }
        .plant-details {
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
        <h1>Plant Adoption Center</h1>
        <p>Help us by adopting a plant or supporting our cause!</p>
    </header>

    <main>
        <h2>Adopt a Peace Lily!</h2>
        <div class="plant-section">
            <img src="plant1.jpg" alt="Peace Lily">
            <div class="plant-details">
                <p><strong>Name:</strong> Peace Lily</p>
                <p><strong>Age:</strong> 1 year</p>
                <p><strong>Type:</strong> Indoor Plant</p>
                <p><strong>Description:</strong> The Peace Lily is a beautiful indoor plant known for its air-purifying properties. It's easy to care for and thrives in low-light conditions.</p>
                <p><strong>Adoption Fee:</strong> $25</p>
            </div>
        </div>

        <div class="form-section">
            <h2>Support the Cause - Payment Details</h2>
            <form action="transactions.php" method="POST" enctype="multipart/form-data">
                <!-- Form section remains unchanged -->
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
                    <img src="https://via.placeholder.com/150x150.png?text=QR+Code" alt="QR Code">
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

</body>
</html>
