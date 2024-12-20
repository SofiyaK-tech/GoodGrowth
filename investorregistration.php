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
$InvestorName = $_POST['InvestorName'];
$phoneNumber = $_POST['PhoneNumber'];
$email = $_POST['Email'];
$address = $_POST['Address'];
$Password = $_POST['Password'];

// Input validation flags
$valid = true;
$errors = "";

// Validate FullName (only alphabets)
if (!preg_match("/^[a-zA-Z\s]+$/", $InvestorName)) {
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

// Validate Password length
if (strlen($Password) < 8) {
    $valid = false;
    $errors .= "Password should be at least 8 characters long. ";
}

// Validate file uploads
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 2 * 1024 * 1024; // 2MB max file size

// Directory to store uploaded files
$uploadDir = 'uploads/';

// Validate AadharCard file
$aadharCardPath = $uploadDir . basename($_FILES['AadharUpload']['name']);
if ($_FILES['AadharUpload']['size'] > $maxFileSize || !in_array($_FILES['AadharUpload']['type'], $allowedMimeTypes)) {
    $valid = false;
    $errors .= "Aadhar Card image should be JPEG, PNG, or GIF and less than 2MB. ";
} elseif (!move_uploaded_file($_FILES['AadharUpload']['tmp_name'], $aadharCardPath)) {
    $valid = false;
    $errors .= "Failed to upload Aadhar Card image. ";
}

// Validate PanCard file
$panCardPath = $uploadDir . basename($_FILES['PanUpload']['name']);
if ($_FILES['PanUpload']['size'] > $maxFileSize || !in_array($_FILES['PanUpload']['type'], $allowedMimeTypes)) {
    $valid = false;
    $errors .= "PAN Card image should be JPEG, PNG, or GIF and less than 2MB. ";
} elseif (!move_uploaded_file($_FILES['PanUpload']['tmp_name'], $panCardPath)) {
    $valid = false;
    $errors .= "Failed to upload PAN Card image. ";
}

// Validate Domicile file
$domicilePath = $uploadDir . basename($_FILES['DomicileUpload']['name']);
if ($_FILES['DomicileUpload']['size'] > $maxFileSize || !in_array($_FILES['DomicileUpload']['type'], $allowedMimeTypes)) {
    $valid = false;
    $errors .= "Domicile image should be JPEG, PNG, or GIF and less than 2MB. ";
} elseif (!move_uploaded_file($_FILES['DomicileUpload']['tmp_name'], $domicilePath)) {
    $valid = false;
    $errors .= "Failed to upload Domicile image. ";
}

if ($valid) {
    // Prepare and bind to insert investor details into the database
    $stmt = $conn->prepare("INSERT INTO investor (InvestorName, PhoneNumber, Email, Address, Password, AadharCard, PanCard, Domicile) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $InvestorName, $phoneNumber, $email, $address, $Password, $aadharCardPath, $panCardPath, $domicilePath);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Display validation errors
    echo "Validation errors: " . $errors;
}

// Close the database connection
$conn->close();
?>
