<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Make sure the autoload path is correct

class MailHelper {
    public function sendMail($to, $subject, $message) {
        $mail = new PHPMailer(true); // Instantiate PHPMailer

        try {
            // Enable verbose debug output
            $mail->SMTPDebug = 0; // Set to 2 for debugging (0 to disable)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP host for Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'mishrutisanchaniya1104@gmail.com'; // Your email address (Gmail)
            $mail->Password = 'iwfv pxwtjezf gmqr'; // Use the app password here
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set the sender and recipient
            $mail->setFrom('your_email@gmail.com', 'NovelNest'); // Sender email
            $mail->addAddress($to); // Recipient email (dynamically passed)

            // Set the email content
            $mail->isHTML(true);
            $mail->Subject = $subject; // Subject of the email
            $mail->Body = $message; // Email body (message content)

            // Attempt to send the email
            if ($mail->send()) {
                return true; // Email sent successfully
            } else {
                return false; // Failed to send email
            }
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo; // Show detailed error message
            return false; // Return false if email fails to send
        }
    }
}
?>
