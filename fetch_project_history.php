
<?php


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdFund";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the email from the session
$email = $_SESSION['Email'];

// Fetch data from the database
$sql = "SELECT uploadproject.ProjectNo, uploadproject.Name, uploadproject.Description, uploadproject.Category, uploadproject.Status, uploadproject.Date, uploadproject.Funds 
        FROM uploadproject
        JOIN projectbuilder ON uploadproject.Email = projectbuilder.Email
        WHERE projectbuilder.Email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table>
            <thead>
                <tr>
                    <th>ProjectNo</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Funds</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["ProjectNo"]) . "</td>
                <td>" . htmlspecialchars($row["Name"]) . "</td>
                <td>" . htmlspecialchars($row["Description"]) . "</td>
                <td>" . htmlspecialchars($row["Category"]) . "</td>
                <td>" . htmlspecialchars($row["Status"]) . "</td>
                <td>" . htmlspecialchars($row["Date"]) . "</td>
                <td>" . htmlspecialchars($row["Funds"]) . "</td>
                <td><a href='update_fetchprojecthistory.php?ProjectNo=" . htmlspecialchars($row["ProjectNo"]) . "'>Update</a></td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<tr><td colspan='8'>No records found</td></tr>";
}

$stmt->close();
$conn->close();
?>