<?php
// Database connection
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $FullName = $_POST['FullName'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $name = $_POST['project_name'] ?? ''; // Updated to match form field
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';
    $status = $_POST['status'] ?? '';
    $date = $_POST['date'] ?? '';
    $funds_money = $_POST['funds_money'] ?? 0;

    // Handle project image upload
    $target_dir = "uploads/"; // Directory where the file will be saved
    $target_file = $target_dir . basename($_FILES["PhotoImg"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (in_array($imageFileType, $allowed_types)) {
        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES["PhotoImg"]["tmp_name"], $target_file)) {
            // Prepare SQL statement to insert data into 'uploadproject' table
            $sql = "INSERT INTO uploadproject (FullName, Email, Name, Description, Category, Status, Date, Funds, PhotoImg) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            // Check if prepare() was successful
            if ($stmt === false) {
                die("Error preparing the SQL statement: " . $conn->error);
            }

            // Bind parameters
            $stmt->bind_param('sssssssis', $FullName, $Email, $name, $description, $category, $status, $date, $funds_money, $target_file);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Project uploaded successfully!";
            } else {
                echo "Error: Could not upload project. " . $stmt->error;
            }

            // Close statement and connection
            $stmt->close();
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    $conn->close();
}
?>
