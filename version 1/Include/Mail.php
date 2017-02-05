<?php

require_once('/var/www/PHPMailer/class.phpmailer.php');

function SendMail($to , $subject , $body)
{
	$body = urldecode($body);

	$mail = new PHPMailer;

	$mail->IsSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.plychannel.com';  				// Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'support@plychannel.com';                            // SMTP username
	$mail->Password = 'Zeeshan1';                           // SMTP password
	//$mail->SMTPSecure = 'tls';   //ssl                         // Enable encryption, 'ssl' also accepted
	$mail->Port = 587;

	$mail->From = 'support@plychannel.com';
	$mail->FromName = 'Plychannel Support';
	$mail->AddAddress($to);  // Add a recipient

	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = "Please enable html in your email to view this properly.\n" . strip_tags($body);

	if(!$mail->Send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}
}

?>