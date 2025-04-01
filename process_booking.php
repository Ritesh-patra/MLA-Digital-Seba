<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON header
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect form data
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $age = $_POST['age'] ?? '';
        $category = $_POST['category'] ?? '';
        $email = $_POST['email'] ?? '';

        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'patrasagarika654@gmail.com'; // Your email
        $mail->Password = 'dysj xwud kxel fxjq'; // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('noreply@yourdomain.com', 'Service Booking System');
        $mail->addAddress('patrasagarika654@gmail.com'); // Where to receive bookings
        if (!empty($email)) {
            $mail->addReplyTo($email, "$firstName $lastName");
        }

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Service Booking: $category";
        
        // HTML email body
        $mail->Body = "
        <h2 style='color: #3b82f6;'>New Service Booking Request</h2>
        <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
            <tr>
                <th style='text-align: left; padding: 8px; background-color: #f3f4f6; border: 1px solid #e5e7eb;'>Field</th>
                <th style='text-align: left; padding: 8px; background-color: #f3f4f6; border: 1px solid #e5e7eb;'>Details</th>
            </tr>
            <tr>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'><strong>Service Type</strong></td>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'>$category</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'><strong>Customer Name</strong></td>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'>$firstName $lastName</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'><strong>Mobile Number</strong></td>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'>$mobile</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'><strong>Email</strong></td>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'>" . (!empty($email) ? $email : 'Not provided') . "</td>
            </tr>
            <tr>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'><strong>Age</strong></td>
                <td style='padding: 8px; border: 1px solid #e5e7eb;'>$age</td>
            </tr>
        </table>
        ";

        // Plain text version
        $mail->AltBody = "New Booking Request\n\n" .
                        "Service: $category\n" .
                        "Name: $firstName $lastName\n" .
                        "Mobile: $mobile\n" .
                        "Email: " . (!empty($email) ? $email : 'Not provided') . "\n" .
                        "Age: $age";

        // Handle file attachments
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB

        // Process Aadhar Card
        if (!empty($_FILES['aadhar']['tmp_name'])) {
            $aadhar = $_FILES['aadhar'];
            $ext = strtolower(pathinfo($aadhar['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowedTypes) && $aadhar['size'] <= $maxFileSize) {
                $mail->addAttachment($aadhar['tmp_name'], 'AadharCard.' . $ext);
            }
        }

       

        // Send email
        $mail->send();
        
        echo json_encode([
            'success' => true,
            'message' => 'Your booking request has been submitted successfully! We will contact you shortly.'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to submit booking. Please try again later.',
            'error' => $mail->ErrorInfo
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>

// Server settings
// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com'; // Your SMTP server
// $mail->SMTPAuth = true;
// $mail->Username = 'patrasagarika654@gmail.com'; // Your email
// $mail->Password = 'dysj xwud kxel fxjq'; // Your app password
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// $mail->Port = 587;