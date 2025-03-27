<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $service_provider = $_POST['ServicesManname'];
    $service_category = $_POST['category'];
    $name = $_POST['name'];
    $phone = '+91 ' . $_POST['phone'];
    $email = isset($_POST['email']) ? $_POST['email'] : 'Not provided';
    $date = $_POST['date'];
    $time = $_POST['time'];
    $address = $_POST['address'];
    $message = isset($_POST['message']) ? $_POST['message'] : 'No additional information';

    // Generate a booking ID
    $booking_id = 'MLA' . rand(100000, 999999);
    
    // Create email content
    $email_subject = "New Booking Request: $service_category";
    $email_body = "
    <h2>New Service Booking</h2>
    <p><strong>Service Provider:</strong> $service_provider</p>
    <p><strong>Service Category:</strong> $service_category</p>
    <h3>Customer Details</h3>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Phone:</strong> $phone</p>
    <p><strong>Email:</strong> $email</p>
    <h3>Service Request</h3>
    <p><strong>Date:</strong> $date</p>
    <p><strong>Time Slot:</strong> $time</p>
    <p><strong>Address:</strong> $address</p>
    <p><strong>Additional Information:</strong> $message</p>
    ";

    // Configure PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'patrasagarika654@gmail.com';
        $mail->Password = 'dysj xwud kxel fxjq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('patrasagarika654@gmail.com', 'MLA Booking System');
        $mail->addAddress('patrasagarika654@gmail.com');
        
        // Add reply-to if email is provided
        if ($email != 'Not provided') {
            $mail->addReplyTo($email, $name);
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $email_subject;
        $mail->Body = $email_body;
        $mail->AltBody = strip_tags($email_body);

        $mail->send();
        
        // Format date for URL
        $formatted_date = date('F j, Y', strtotime($date));
        
        // Redirect to booking.html with success parameters
        header("Location: booking.html?success=true&service=" . urlencode($service_category) . 
               "&provider=" . urlencode($service_provider) . 
               "&date=" . urlencode($formatted_date) . 
               "&time=" . urlencode($time) . 
               "&booking_id=" . urlencode($booking_id));
        exit;
    } catch (Exception $e) {
        // Log the error
        error_log("Mailer Error: " . $mail->ErrorInfo);
        
        // Simple error response
        echo "Error sending email: " . $mail->ErrorInfo;
        echo "<br><a href='javascript:history.back()'>Go Back</a>";
    }
} else {
    // Not a POST request
    echo "Invalid request method";
}
?>

<!-- dysj xwud kxel fxjq -->