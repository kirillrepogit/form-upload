<?php

require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');

function sendMail($host, $login, $pass, $smtpSecure, $port, $from, $to, $arrayImages){
	
	try{
		
		$mail = new PHPMailer;
		$mail->isSMTP(); 
		$mail->Host = $host; 
		$mail->SMTPAuth = true; 
		$mail->Username = $login; 
		$mail->Password = $pass; 
		$mail->SMTPSecure = $smtpSecure; 
		$mail->Port = $port;
		$mail->setFrom($from); 
		$mail->addAddress($to); 
		$mail->isHTML(true); 
		$mail->CharSet = 'UTF-8'; 
		$mail->Subject = 'Новые Картинки'; 
		
		$message = "<div style=\"color:#1782c5;font-size: 20px;\">";
		$message .= "Привет, Админ! Есть пару новых картинок.";
		$message .= "</div>";
		
		foreach($arrayImages as $val){
			$mail->addStringAttachment(file_get_contents($val[0]), $val[1]);
		}
	
		$mail->Body = $message; 
		$mail->AltBody = 'Привет, Админ! Есть пару новых картинок.'; 
							
		
		if(!$mail->send()) {
			return ['error' => 'Не удалось отправить сообщение на почту. Проверте настройки почтового сервиса.'];
		} else {
			return false;
		}
	} catch (Exception $err){
		return ['error' => 'Ошибка при отправке письма.'];
	}
}

?>