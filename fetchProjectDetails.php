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

// SQL query to fetch project details
$sql = "SELECT ProjectNo, FullName, Email, Name, Description, Category, Status, Date, Funds, PhotoImg FROM uploadproject";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output project data for each row
    while ($row = $result->fetch_assoc()) {
        // Check if image exists, else leave the cell empty
        $imagePath = (!empty($row["PhotoImg"]) && file_exists($row["PhotoImg"])) 
        ? htmlspecialchars($row["PhotoImg"]) 
        : 'uploads/pet.png';

        echo '
        <tr>
            <td>' . htmlspecialchars($row['ProjectNo']) . '</td>';

        // Only display the image if the path is not empty
        if (!empty($imagePath)) {
            echo '<td><img src="' . $imagePath . '" alt="Project Image" width="100"></td>';
        } else {
            echo '<td>No Image Available</td>';
        }

        echo '
            <td>' . htmlspecialchars($row['Name']) . '</td>
            <td>' . htmlspecialchars($row['Description']) . '</td>
            <td>' . htmlspecialchars($row['Category']) . '</td>
            <td>' . htmlspecialchars($row['Funds']) . '</td>
            <td>' . htmlspecialchars($row['Date']) . '</td>
            <td>' . htmlspecialchars($row['Status']) . '</td>
            <td>' . htmlspecialchars($row['FullName']) . '</td>
            <td>' . htmlspecialchars($row['Email']) . '</td>
        </tr>';
    }
} else {
    // No projects found
    echo '<tr><td colspan="10">No projects found.</td></tr>';
}

$conn->close();
?>
