<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "crowdFund"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $category = $_POST['category']; // Get the selected category

    // Assign category IDs based on the selected category
    if ($category == 'guestuser') {
        $category_id = 1;
    } elseif ($category == 'projectbuilder') {
        $category_id = 2;
    } elseif ($category == 'investor') {
        $category_id = 3;
    }

    // Prepare and bind (insert both category and category_id into the correct columns)
    $stmt = $conn->prepare("INSERT INTO contact (FullName, Email, Message, category, id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $fullname, $email, $message, $category, $category_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Your message has been sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
