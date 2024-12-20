<?php
session_start();
$investorId = $_SESSION['investorId']; // Ensure the investorId is set in the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdFund";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$project_name = $_POST['ProjectName'];
$money = $_POST['Amount'];
$date = $_POST['Date'];
$payment_time = $_POST['PaymentTime'];
$payment_platform = $_POST['PaymentPlatform'];

// Get today's date and current time
$today = date('Y-m-d');
$current_time = date('H:i');

// Check if the selected date is today and validate the time
if ($date === $today && $payment_time < $current_time) {
    echo "Invalid time. Payment time cannot be in the past for today's date.";
} else {
    // Handle payment screenshot upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["PaymentScreenshot"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (in_array($imageFileType, $allowed_types)) {
        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES["PaymentScreenshot"]["tmp_name"], $target_file)) {
            // Insert data into transactions table, including investorId
            $sql = "INSERT INTO transactions (ProjectName, Amount, Date, Platform, Time, Screenshot, investorId)
                    VALUES ('$project_name', '$money', '$date', '$payment_platform', '$payment_time', '$target_file', '$investorId')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                header("Location: investordashboard.php"); // Redirect to the dashboard after successful insertion
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
}
}
$conn->close();
?>