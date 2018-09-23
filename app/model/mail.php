<?php

require('lib/PHPMailer/PHPMailer.php');
require('lib/PHPMailer/SMTP.php');

function sendMail($arrayImages){
	
	$config = require('../config/config.php');
	$path = __DIR__;
	$pathFile = str_replace("model", '', $path).'controller'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
	//настройки для отправки письма с помощью PHPMailer
	$mail = $config['mail_config'];

	$host = $mail['host'];
	$login = $mail['login'];
	$pass = $mail['pass'];
	$secure = $mail['secure'];
	$port = $mail['port'];
	$from = $mail['from'];
	$to = $mail['to'];
	
	$mail = new PHPMailer;
	$mail->isSMTP(); 
	$mail->Host = $host; 
	$mail->SMTPAuth = true; 
	$mail->Username = $login; 
	$mail->Password = $pass; 
	$mail->SMTPSecure = $secure; 
	$mail->Port = $port;
	$mail->setFrom($from); 
	$mail->addAddress($to); 
	$mail->isHTML(true); 
	$mail->CharSet = 'UTF-8'; 
	$mail->Subject = 'Новые Картинки'; 
	
	$letter = "<div style=\"color:#1782c5;font-size: 20px;\">";
	$letter .= "Привет, Админ! Есть пару новых картинок.";
	$letter .= "</div>";
	
	foreach($arrayImages as $image){
		$file = $pathFile.$image['name'];
		$mail->addStringAttachment(file_get_contents($file), $image['name']);
	}

	$mail->Body = $letter; 
	$mail->AltBody = 'Привет, Админ! Есть пару новых картинок.'; 
						
	
	if(!$mail->send()) {
		//echo ['error' => 'Письмо не отправлено. Проверте настройки почты.'];
		$message = 'Письмо не отправлено. Проверте настройки почты.';
		include '../view/view.message.php';
	}
}

?>