<?php
// Ensure session_start() is at the very top, no output before this line
session_start();

// Database connection (replace with your actual database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdFund";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the session contains investorEmail
if (isset($_SESSION['Email'])) {
    $Email = $_SESSION['investorEmail'];
    

    // Prepare SQL query to fetch contact history where the email matches the investor's email
    $sql = "SELECT ContactId, message FROM contact WHERE Email = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    // Bind the investor's email to the query
    $stmt->bind_param("s", $Email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Display the contact history
            while ($row = $result->fetch_assoc()) {
                echo '
                <tr>
                    <td>' . $row["ContactId"] . '</td>
                    <td>' . $row["message"] . '</td>
                </tr>';
            }
        } else {
            // No contact history found
            echo '<tr><td colspan="2">No contact history found</td></tr>';
        }
    } else {
        // Query execution failed
        echo "Error executing the query: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Investor email not set in the session.";
}

$conn->close();
?>
