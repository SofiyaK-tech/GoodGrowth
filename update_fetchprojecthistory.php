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

// Check if ProjectNo is set
if (isset($_GET['ProjectNo'])) {
    $projectNo = $_GET['ProjectNo'];

    // Fetch project details
    $sql = "SELECT * FROM uploadproject WHERE ProjectNo = $projectNo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Pre-fill form fields with existing project data
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Update Project</title>
            <style>
                body {
                    font-family: 'Poppins', sans-serif;
                    background-color: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .form-container {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    width: 100%;
                }
                h2 {
                    text-align: center;
                    color: #333;
                    margin-bottom: 20px;
                }
                label {
                    display: block;
                    font-size: 14px;
                    margin-bottom: 5px;
                    color: #555;
                }
                input[type='text'],
                input[type='date'],
                input[type='number'],
                textarea {
                    width: 95%;
                    padding: 10px;
                    font-size: 14px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    outline: none;
                    margin-bottom: 15px;
                    transition: border-color 0.3s ease;
                }
                input:focus,
                textarea:focus {
                    border-color: #007bff;
                }
                button {
                    width: 100%;
                    padding: 10px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }
                button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class='form-container'>
                <h2>Update Project</h2>
                <form action='statusupdatebuilder.php' method='post'>
                    <input type='hidden' name='ProjectNo' value='" . $row["ProjectNo"] . "'>
                    <label for='Name'>Project Name:</label>
                    <input type='text' name='Name' value='" . $row["Name"] . "' required>
                    <label for='Description'>Description:</label>
                    <textarea name='Description' required>" . $row["Description"] . "</textarea>
                    <label for='Category'>Category:</label>
                    <input type='text' name='Category' value='" . $row["Category"] . "' required>
                    <label for='Status'>Status:</label>
                    <input type='text' name='Status' value='" . $row["Status"] . "' required>
                    <label for='Date'>Date:</label>
                    <input type='date' name='Date' value='" . $row["Date"] . "' required>
                    <label for='Funds'>Funds:</label>
                    <input type='number' name='Funds' value='" . $row["Funds"] . "' required>
                    <button type='submit'>Update Project</button>
                </form>
            </div>
        </body>
        </html>";
    } else {
        echo "Project not found!";
    }
} else {
    echo "No ProjectNo provided!";
}

$conn->close();
?>
