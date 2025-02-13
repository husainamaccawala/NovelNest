<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure Composer's autoload file is correctly referenced

class MailHelper {
    public function sendMail($to, $subject, $message) {
        $mail = new PHPMailer(true); // Create a new PHPMailer instance

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server (Gmail example)
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // Your email address
            $mail->Password = 'your_email_password'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // Use port 587 for STARTTLS encryption

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'Mailer'); // Sender email and name
            $mail->addAddress($to); // Add recipient email

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Send the email
            $mail->send();
            return json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
        } catch (Exception $e) {
            // Send a JSON response with the error message
            return json_encode(['status' => 'error', 'message' => 'Failed to send OTP. Mailer Error: ' . $mail->ErrorInfo]);
        }
    }
}
?>
