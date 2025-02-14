<?php
require_once('mailHelper.php');

$mailHelper = new MailHelper();
$email = 'recipient_email@example.com'; // Change to a real email
$subject = 'Test Email';
$message = 'This is a test email from PHPMailer.';

if ($mailHelper->sendMail($email, $subject, $message)) {
    echo "✅ Email sent successfully!";
} else {
    echo "❌ Failed to send email.";
}
?>
