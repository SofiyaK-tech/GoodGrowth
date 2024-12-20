<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "crowdFund"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$BuilderName = $_POST['BuilderName'];
$phoneNumber = $_POST['PhoneNumber'];
$email = $_POST['Email'];
$address = $_POST['Address'];
$Password = $_POST['Password'];

// Input validation flags
$valid = true;
$errors = "";

// Validate FullName (only alphabets)
if (!preg_match("/^[a-zA-Z\s]+$/", $BuilderName)) {
    $valid = false;
    $errors .= "Name should contain alphabets only. ";
}

// Validate PhoneNumber (only numeric, 10 digits)
if (!preg_match("/^\d{10}$/", $phoneNumber)) {
    $valid = false;
    $errors .= "Phone number should contain 10 numeric digits only. ";
}

// Validate Email (contains @ symbol)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $valid = false;
    $errors .= "Invalid email format. ";
}

// Validate Address (contains at least letters and numbers)
if (!preg_match("/[A-Za-z]/", $address) || !preg_match("/[0-9]/", $address)) {
    $valid = false;
    $errors .= "Address should contain both letters and numbers. ";
}
if (strlen($Password) < 8) {
    echo "Password should be at least 8 characters long.";
    exit;
}
// Validate file uploads
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 2 * 1024 * 1024; // 2MB max file size

// Validate AadharCard file
if ($_FILES['AadharUpload']['size'] > $maxFileSize || !in_array($_FILES['AadharUpload']['type'], $allowedMimeTypes)) {
    $valid = false;
    $errors .= "Aadhar Card image should be JPEG, PNG, or GIF and less than 2MB. ";
}

// Validate PanCard file
if ($_FILES['PanUpload']['size'] > $maxFileSize || !in_array($_FILES['PanUpload']['type'], $allowedMimeTypes)) {
    $valid = false;
    $errors .= "PAN Card image should be JPEG, PNG, or GIF and less than 2MB. ";
}

// Validate Domicile file
if ($_FILES['DomicileUpload']['size'] > $maxFileSize || !in_array($_FILES['DomicileUpload']['type'], $allowedMimeTypes)) {
    $valid = false;
    $errors .= "Domicile image should be JPEG, PNG, or GIF and less than 2MB. ";
}

if ($valid) {
    // Handle file uploads
    $aadharCard = file_get_contents($_FILES['AadharUpload']['tmp_name']);
    $panCard = file_get_contents($_FILES['PanUpload']['tmp_name']);
    $domicile = file_get_contents($_FILES['DomicileUpload']['tmp_name']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO projectbuilder (BuilderName, PhoneNumber, Email, Address,Password, AadharCard, PanCard, Domicile) VALUES ( ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssssss", $fullName, $phoneNumber, $email, $address,$Password, $aadharCard, $panCard, $domicile);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
} else {
    // Display errors
    echo "Validation errors: " . $errors;
}

$conn->close();
?>
