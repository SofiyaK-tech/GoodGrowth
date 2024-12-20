<?php
// Start a session
session_start();

// Database connection credentials
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "crowdFund"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to check if email and password match an investor in the database
    $sql = "SELECT * FROM projectbuilder WHERE Email = ? AND Password = ?";

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password); // "ss" means two string parameters

    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if the result contains any rows
    if ($result->num_rows > 0) {
        // Successful login
        $row = $result->fetch_assoc();
        $_SESSION['Email'] = $row['Email']; // Store the email in the session
        $_SESSION['BuilderName'] = $row['BuilderName']; // Optionally store the name in session
        
        // Redirect to the projectbuilderdashboard.php page
        header("Location: projectbuilderdashboard.php");
        exit;
    } else {
        // Invalid login
        echo "Invalid email or password. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
