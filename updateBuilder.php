<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crowdFund";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted to update investor details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $investorId = $_POST['projectbuilderId'];
    $InvestorName = $_POST['BuilderName'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];

    // Initialize file upload paths
    $aadharCardPath = null;
    $panCardPath = null;
    $domicilePath = null;

    // File handling for Aadhar Card
    if (!empty($_FILES['AadharUpload']['name'])) {
        $aadharCardPath = 'uploads/' . basename($_FILES['AadharUpload']['name']);
        move_uploaded_file($_FILES['AadharUpload']['tmp_name'], $aadharCardPath);
    }

    // File handling for Pan Card
    if (!empty($_FILES['PanUpload']['name'])) {
        $panCardPath = 'uploads/' . basename($_FILES['PanUpload']['name']);
        move_uploaded_file($_FILES['PanUpload']['tmp_name'], $panCardPath);
    }

    // File handling for Domicile
    if (!empty($_FILES['DomicileUpload']['name'])) {
        $domicilePath = 'uploads/' . basename($_FILES['DomicileUpload']['name']);
        move_uploaded_file($_FILES['DomicileUpload']['tmp_name'], $domicilePath);
    }

    // Prepare the SQL query with file paths if provided
    $sql = "UPDATE projectbuilder SET BuilderName = ?, PhoneNumber = ?, Email = ?, Address = ?, 
            AadharCard = COALESCE(?, AadharCard), 
            PanCard = COALESCE(?, PanCard), 
            Domicile = COALESCE(?, Domicile)
            WHERE projectbuilderId = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $BuilderName, $PhoneNumber, $Email, $Address, 
                      $aadharCardPath, $panCardPath, $domicilePath, $projectbuilderId);

    if ($stmt->execute()) {
        echo "<p class='success'>Project builder details updated successfully.</p>";
    } else {
        echo "<p class='error'>Error updating record: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// If investorId is provided, fetch details for editing
if (isset($_GET['id'])) {
    $projectbuilderId = $_GET['id'];

    // SQL query to fetch the investor details
    $sql = "SELECT projectbuilderId, BuilderName, PhoneNumber, Email, Address, AadharCard, PanCard, Domicile FROM projectbuilder WHERE projectbuilderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $projectbuilderId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch investor data
            $row = $result->fetch_assoc();
        } else {
            echo "<p class='error'>No record found.</p>";
            exit;
        }
    } else {
        echo "<p class='error'>Error executing query: " . $stmt->error . "</p>";
        exit;
    }

    $stmt->close();
} else {
    echo "<p class='error'>No investor ID provided.</p>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project Builder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: LightGray;
            padding: 20px;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 95%;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        img {
            max-width: 100px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Project Builder Details</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="projectbuilderId" value="<?php echo $row['projectbuilderId']; ?>">

            <label for="BuilderName">Name:</label>
            <input type="text" name="BuilderName" value="<?php echo htmlspecialchars($row['BuilderName']); ?>" required>

            <label for="PhoneNumber">Phone Number:</label>
            <input type="text" name="PhoneNumber" value="<?php echo htmlspecialchars($row['PhoneNumber']); ?>" required>

            <label for="Email">Email:</label>
            <input type="email" name="Email" value="<?php echo htmlspecialchars($row['Email']); ?>" required>

            <label for="Address">Address:</label>
            <input type="text" name="Address" value="<?php echo htmlspecialchars($row['Address']); ?>" required>

            <label for="AadharUpload">Aadhar Card:</label>
            <input type="file" name="AadharUpload">
            

            <label for="PanUpload">PAN Card:</label>
            <input type="file" name="PanUpload">
            
            <label for="DomicileUpload">Domicile:</label>
            <input type="file" name="DomicileUpload">
            
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
