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

// SQL query to fetch transaction and investor details
$sql = "SELECT t.transactionId, t.investorId, i.InvestorName, t.ProjectName, t.Date, t.Time, t.Amount, t.Platform, t.Screenshot 
        FROM transactions t
        JOIN investor i ON t.investorId = i.investorId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output transaction data for each row
    while ($row = $result->fetch_assoc()) {
        // Check if the screenshot exists and convert it to base64 for display
        $screenshot  = (!empty($row["Screenshot"]) && file_exists($row["Screenshot"])) 
        ? htmlspecialchars($row["Screenshot"]) 
        : 'uploads/default_pan.png';

        echo '
        <tr>
            <td>' . htmlspecialchars($row['transactionId']) . '</td>
            <td>' . htmlspecialchars($row['investorId']) . '</td>
            <td>' . htmlspecialchars($row['InvestorName']) . '</td>
            <td>' . htmlspecialchars($row['ProjectName']) . '</td>
            <td>' . htmlspecialchars($row['Date']) . '</td>
            <td>' . htmlspecialchars($row['Time']) . '</td>
            <td>' . htmlspecialchars($row['Amount']) . '</td>
            <td>' . htmlspecialchars($row['Platform']) . '</td>
            <td><img src="' . $screenshot . '" alt="Domicile" width="100"></td>
        </tr>';
    }
} else {
    // No transactions found
    echo '<tr><td colspan="9">No transactions found.</td></tr>';
}

$conn->close();
?>
