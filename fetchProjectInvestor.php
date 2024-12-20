<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdFund";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search category from the request
$searchCategory = isset($_GET['category']) ? $_GET['category'] : '';

// Prepare the SQL query with filtering
$query = "SELECT PhotoImg, ProjectNo, Name, Description, FullName, Date, Funds, Category, Status, ProjectURL FROM uploadproject";
if ($searchCategory) {
    $query .= " WHERE Category LIKE ?";
    $stmt = $conn->prepare($query);
    $likeCategory = "%" . $searchCategory . "%";
    $stmt->bind_param("s", $likeCategory);
} else {
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    // Display error message if the query fails
    echo "Error: " . $conn->error;
} else {
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="project-card">
                <img src="' . htmlspecialchars($row["PhotoImg"]) . '" alt="' . htmlspecialchars($row["Name"]) . '" style="width:100%; height:auto; border-radius: 8px; margin-bottom: 10px;">
                <h3>' . htmlspecialchars($row["Name"]) . '</h3>
                <p><strong>Project ID:</strong> ' . htmlspecialchars($row["ProjectNo"]) . '</p>
                <p><strong>Description:</strong> ' . htmlspecialchars($row["Description"]) . '</p>
                <p><strong>Builder:</strong> ' . htmlspecialchars($row["FullName"]) . '</p>
                <p><strong>Date:</strong> ' . htmlspecialchars($row["Date"]) . '</p>
                <p><strong>Amount:</strong> ' . htmlspecialchars($row["Funds"]) . '</p>
                <p><strong>Category:</strong> ' . htmlspecialchars($row["Category"]) . '</p>
                <p><strong>Status:</strong> ' . htmlspecialchars($row["Status"]) . '</p>
               <a href="' . htmlspecialchars($row["ProjectURL"]) . '" class="invest-btn" target="_blank">Invest Now</a>
            
            </div>';
        }
    } else {
        echo "<p>No projects found.</p>";
    }
}

$stmt->close();
$conn->close();
?>
