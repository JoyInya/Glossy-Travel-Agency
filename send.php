<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glossy travel agency";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST["send"])) {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert log into the database
    $stmt = $conn->prepare("INSERT INTO email_logs (email, subject, message, status) VALUES (?, ?, ?, ?)");
    $status = 'pending';
    $stmt->bind_param("ssss", $email, $subject, $message, $status);
    $stmt->execute();

    $mail = new PHPMailer(true);

    try {
        // Enable SMTP debugging
        $mail->SMTPDebug = 2;  // Enable detailed output

        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'joyinyamuthusi@gmail.com'; // Your Gmail address
        $mail->Password = 'tajlbwukzclqzxxp'; // App Password (if 2FA is enabled)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('joyinyamuthusi@gmail.com', 'Glossy Travel Agency');
        $mail->addAddress($email); // Recipient email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();

        // Update email status to 'sent' in the database
        $status = 'sent';
        $stmt = $conn->prepare("UPDATE email_logs SET status=? WHERE email=? AND subject=?");
        $stmt->bind_param("sss", $status, $email, $subject);
        $stmt->execute();

        echo "<script>
            alert('Email Sent Successfully');
            document.location.href = 'index.php'; 
        </script>";

    } catch (Exception $e) {
        // Update email status to 'failed' in the database
        $status = 'failed';
        $stmt = $conn->prepare("UPDATE email_logs SET status=? WHERE email=? AND subject=?");
        $stmt->bind_param("sss", $status, $email, $subject);
        $stmt->execute();

        echo "<script>
            alert('Error: Could not send email. Error: " . $mail->ErrorInfo . "');
            document.location.href = 'index.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
