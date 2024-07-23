<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';

$mail = new PHPMailer(true);
$mail->SMTPAuth = true; 
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP(); 
$mail->Host = 'smtp.centrum.cz';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL/TLS encryption
$mail->Port = 465;    
$mail->Username = 'reactbrno@centrum.cz';
$mail->Password = 'Heslo12345';

$mail->isHtml(true);

return $mail;


//<?php
    

   // use PHPMailer\PHPMailer\PHPMailer;
   // use PHPMailer\PHPMailer\SMTP;
//   use PHPMailer\PHPMailer\Exception;
//   
//   require_once 'vendor/autoload.php';
//
//   $mail = new PHPMailer(true);
//   $mail->SMTPAuth = true; 
//   $mail->SMTPDebug = SMTP::DEBUG_SERVER;
//   $mail->isSMTP(); 
//
//   $mail->Host = 'smtp.centrum.cz';
//   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL/TLS encryption
//   $mail->Port = 465;    
//   $mail->Username = 'reactbrno@centrum.cz';
//   $mail->Password = 'Heslo12345';
//
//   $mail->isHtml(true);
//
//   return $mail;