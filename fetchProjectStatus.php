<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdFund";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch project statuses
$sql = "SELECT ProjectNo, Name, Status FROM uploadproject"; // Adjust according to your actual table structure
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    // Log error message
    die("SQL error: " . $conn->error); // This will help you identify the issue
}

if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="notification-card">
            <h3>' . htmlspecialchars($row['Name']) . '</h3>
            <p>Status: ' . htmlspecialchars($row['Status']) . '</p>
        </div>';
    }
} else {
    echo '<p>No project updates available.</p>';
}

$conn->close();
?>
