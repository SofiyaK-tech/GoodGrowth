<?php

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

// Fetch investor details as before
$sql = "SELECT investorId, InvestorName, PhoneNumber, Email, Address, AadharCard, PanCard, Domicile FROM investor";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing the query: " . $conn->error);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Check if image file exists, else use default
            $aadharCardPath = (!empty($row["AadharCard"]) && file_exists($row["AadharCard"])) 
            ? htmlspecialchars($row["AadharCard"]) 
            : 'uploads/pet.png';

$panCardPath = (!empty($row["PanCard"]) && file_exists($row["PanCard"])) 
         ? htmlspecialchars($row["PanCard"]) 
         : 'uploads/default_pan.png';

$domicilePath = (!empty($row["Domicile"]) && file_exists($row["Domicile"])) 
          ? htmlspecialchars($row["Domicile"]) 
          : 'uploads/default_domicile.png';

            // Display investor data along with images
            echo '
            <tr>
                <td>' . htmlspecialchars($row["investorId"]) . '</td>
                <td>' . htmlspecialchars($row["InvestorName"]) . '</td>
                <td>' . htmlspecialchars($row["PhoneNumber"]) . '</td>
                <td>' . htmlspecialchars($row["Email"]) . '</td>
                <td>' . htmlspecialchars($row["Address"]) . '</td>
                
                <td><img src="' . $aadharCardPath . '" alt="Aadhar Card" width="100"></td>
                <td><img src="' . $panCardPath . '" alt="Pan Card" width="100"></td>
                <td><img src="' . $domicilePath . '" alt="Domicile" width="100"></td>

                <td>
                    <a href="updateInvestor.php?id=' . htmlspecialchars($row["investorId"]) . '">Update</a>
                    
                </td>
            </tr>';
        }
    } else {
        echo '<tr><td colspan="9">No records found</td></tr>';
    }
} else {
    echo "Error executing the query: " . $stmt->error;
}



$stmt->close();
$conn->close();
?>
