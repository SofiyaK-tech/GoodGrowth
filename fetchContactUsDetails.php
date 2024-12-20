<?php
// Include PHPMailer files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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

// Check if the email parameter is set and valid
if (isset($_GET['email'])) {
    $to = $_GET['email'];
    if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through (e.g., smtp.gmail.com)
            $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
            $mail->Username   = 'sofiya13feb@gmail.com';             // SMTP username (your email)
            $mail->Password   = 'ueohbolbdmkhrvkg';                      // SMTP password
            $mail->SMTPSecure = 'ssl';      // Enable TLS encryption
            $mail->Port       = 465;                                  // TCP port to connect to

            // Recipients
            $mail->setFrom('sofiya13feb@gmail.com', 'Sofiya');    // Sender email and name
            $mail->addAddress($to);                                   // Add a recipient

            // Content
            $mail->isHTML(true);                                      // Set email format to HTML
            $mail->Subject = "Reply to Your Inquiry";
            $mail->Body    = "Thank you for reaching out to us. We will get back to you shortly.";
            $mail->AltBody = "Thank you for reaching out to us. We will get back to you shortly.";

            $mail->send();
            echo "Email sent successfully.";
            header("Location: admindashboard.php"); // Redirect to dashboard after sending email
            exit();
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No valid email address provided.";
    }
}

// SQL query to fetch contact us details
$sql = "SELECT ContactId, FullName, Email, Message, category FROM contact";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        echo '
        <tr>
            <td>' . htmlspecialchars($row['ContactId']) . '</td>
            <td>' . htmlspecialchars($row['FullName']) . '</td>
            <td>' . htmlspecialchars($row['Email']) . '</td>
            <td>' . htmlspecialchars($row['Message']) . '</td>
            <td>' . htmlspecialchars($row['category']) . '</td>
            <td><a href="fetchContactUsDetails.php?email=' . urlencode($row['Email']) . '" class="reply-btn">Reply</a></td> <!-- Reply button -->
        </tr>';
    }
    echo '</table>';
} else {
    // No contact us entries found
    echo '<tr><td colspan="6">No contact us details found.</td></tr>'; // Adjusted colspan to 6
}

$conn->close();
?>
