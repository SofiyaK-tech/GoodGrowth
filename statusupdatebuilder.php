<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "crowdFund";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $projectNo = $_POST['ProjectNo'];
    $name = $_POST['Name'];
    $description = $_POST['Description'];
    $category = $_POST['Category'];
    $status = $_POST['Status'];
    $date = $_POST['Date'];
    $funds = $_POST['Funds'];

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE uploadproject SET Name=?, Description=?, Category=?, Status=?, Date=?, Funds=? WHERE ProjectNo=?");
    $stmt->bind_param("sssssdi", $name, $description, $category, $status, $date, $funds, $projectNo);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Project updated successfully!";
    } else {
        echo "Error updating project: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
