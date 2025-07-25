<?php
mb_internal_encoding("UTF-8");
require_once 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$to = 'hello@example.com';
$subject = 'Message from Cryptex';

$name = "";
$email = "";
$phone = "";
$message = "";
$body = "";

if( isset($_POST['name']) ){
    $name = $_POST['name'];
    $body .= "Name: ";
    $body .= $name;
    $body .= "\n\n";
}
if( isset($_POST['subject']) ){
    $subject = $_POST['subject'];
}
if( isset($_POST['email']) ){
    $email = $_POST['email'];
    $body .= "";
    $body .= "Email: ";
    $body .= $email;
    $body .= "\n\n";
}
if( isset($_POST['phone']) ){
    $phone = $_POST['phone'];
    $body .= "";
    $body .= "Phone: ";
    $body .= $phone;
    $body .= "\n\n";
}
if( isset($_POST['message']) ){
    $message = $_POST['message'];
    $body .= "";
    $body .= "Message: ";
    $body .= $message;
    $body .= "\n\n";
}

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_FROM, $name);
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo '<div class="status-icon valid"><i class="fa fa-check"></i></div>';
    } catch (Exception $e) {
        echo '<div class="status-icon invalid"><i class="fa fa-times"></i></div>';
    }
} else {
    echo '<div class="status-icon invalid"><i class="fa fa-times"></i></div>';
}
