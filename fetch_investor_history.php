<?php


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdFund";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the email from the session
$email = $_SESSION['Email'];

// Fetch data from the database
$sql = "SELECT investor.InvestorName, investor.PhoneNumber, transactions.Amount, transactions.Date, transactions.ProjectName, projectbuilder.Email
FROM transactions
JOIN investor ON investor.investorId = transactions.investorId 
JOIN projectbuilder ON projectbuilder.projectbuilderId = transactions.pbid
WHERE projectbuilder.Email = ?";


$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<p>Error preparing statement: " . htmlspecialchars($conn->error) . "</p>";
}

$stmt->bind_param("s", $email);
if (!$stmt->execute()) {
    echo "<p>Error executing statement: " . htmlspecialchars($stmt->error) . "</p>";
}

$result = $stmt->get_result();

// Check if query failed
if ($result === false) {
    echo "<p>Error: " . htmlspecialchars($conn->error) . "</p>";
} else {
    
    // Generate HTML table
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Investor Name</th>
                        <th>Phone Number</th>
                        <th>Amount</th>
                        <th>Invested Date</th>
                        <th>Project Name</th>
                    </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["InvestorName"]) . "</td>
                    <td>" . htmlspecialchars($row["PhoneNumber"]) . "</td>
                    <td>" . htmlspecialchars($row["Amount"]) . "</td>
                    <td>" . htmlspecialchars($row["Date"]) . "</td>
                    <td>" . htmlspecialchars($row["ProjectName"]) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No records found</p>";
    }
}

$stmt->close();
$conn->close();
?>
