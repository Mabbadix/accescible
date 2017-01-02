<?php
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'SSL0.OVH.NET';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'administrateur@projetdev.ovh';                 // SMTP username
$mail->Password = 'Tu10madu1';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('microsoftfrance@contact.com', 'Pole recrutement Microsoft France');
$mail->addAddress('stephdumonceau@gmail.com', 'Stephane Dumonceau');     // Add a recipient
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Proposition d\'emploi';
$mail->Body    = 'Pôle recrutement Microsoft France<br />Bonjour Stephane Dumonceau,<br />plusieurs contact au sein de votre formation nous ont fais part de vôtre talent en programmation.<br />C\'est pourquoi je vous contacte aujourd\'hui.<br />Depuis des année Microsoft France recrute nombres de jeunes talent et nous serions honoré de vous comptez dans nos effectif.<br />Je reste a votre disposition pour d\'avantage d\'informaton.<br />Cordialement,<br />Le Pôle recrutement Microsoft France.'  ;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
 ?>
