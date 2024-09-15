<?php

require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$name = htmlspecialchars($_POST['Name']);
$company = htmlspecialchars($_POST['Company']);
$email = htmlspecialchars($_POST['E-mail']);
$phone = htmlspecialchars($_POST['Phone']);
$message = htmlspecialchars($_POST['Message']);

$emailBody = "Name: $name\n";
$emailBody .= "Company: $company\n";
$emailBody .= "Email: $email\n";
$emailBody .= "Phone: $phone\n";
$emailBody .= "Message:\n$message";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $_ENV['MAIL_HOST'];
    $mail->Port = $_ENV['MAIL_PORT'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USERNAME'];
    $mail->Password = $_ENV['MAIL_PASSWORD'];
    $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];

    $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $name);
    $mail->addAddress($_POST['admin_email']);

    $mail->isHTML(false);
    $mail->Subject = $_POST['form_subject'];
    $mail->Body = $emailBody;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
