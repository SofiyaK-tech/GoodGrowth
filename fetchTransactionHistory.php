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

// Check if the session contains investorId
if (isset($_SESSION['investorId'])) {
    $investorId = $_SESSION['investorId'];

    // Prepare SQL query to fetch transactions for the logged-in investor
    $sql = "SELECT * FROM transactions WHERE investorId = ?"; 

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $stmt->bind_param("i", $investorId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Display the transactions
            while ($row = $result->fetch_assoc()) {
                echo '
                <tr>
                    <td>' . $row["transactionId"] . '</td>
                    <td>' . $row["ProjectName"] . '</td>
                    <td>Rs' . $row["Amount"] . '</td>
                    <td>' . $row["Platform"] . '</td>
                    <td>' . $row["Date"] . '</td>
                    <td>' . $row["Time"] . '</td>
                </tr>';
            }
        } else {
            // No transactions found
            echo '<tr><td colspan="6">No records found</td></tr>';
        }
    } else {
        // Query execution failed
        echo "Error executing the query: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Investor ID not set in the session.";
}

$conn->close();
?>
