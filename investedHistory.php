<?php
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
$payment_platform = $_POST['PaymentPlatform'];
$payment_time = $_POST['PaymentTime'];

// Handle payment screenshot upload
$target_dir = "uploads/"; // Directory where the file will be saved
$target_file = $target_dir . basename($_FILES["PaymentScreenshot"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validate file type (optional)
$allowed_types = array("jpg", "jpeg", "png", "gif");
if (in_array($imageFileType, $allowed_types)) {
    // Move the uploaded file to the server
    if (move_uploaded_file($_FILES["PaymentScreenshot"]["tmp_name"], $target_file)) {
        // Insert data into investedhistory table
        $sql = "INSERT INTO investedhistory (ProjectName, Amount, Date, PaymentPlatform, PaymentTime, PaymentScreenshot)
                VALUES ('$project_name', '$money', '$date', '$payment_platform', '$payment_time', '$target_file')";

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

$conn->close();
?>
