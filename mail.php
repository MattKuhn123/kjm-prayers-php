<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (!isset($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "invalid email";
    return;
}

try {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 4;
    $mail->isSMTP();
    $mail->Host = "smtp-mail.outlook.com";
    $mail->SMTPAuth = true;
    $mail->Username = get_cfg_var("mail_user");
    $mail->Password = get_cfg_var("mail_pass");
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAutoTLS = true;
    $mail->Port = 587;
    $mail->setFrom(get_cfg_var("mail_user"));
    $mail->addAddress(trim($_POST["email"]));
    $mail->isHTML(true);
    $mail->Subject = 'Here is the subject';
    $mail->Body = 'This is the HTML message body <b>in bold!</b>';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
