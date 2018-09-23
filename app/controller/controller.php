<?php

require_once('../model/load.php');
require_once('../model/mail.php');

if(!empty($_POST['file_upload'])){ 

	// загружаем полученные файлы
	$images = loadImages($_FILES); 
	
	if(!empty($images)){

		// отправляем сообщение на почту 
		sendMail($images);
		// подключаем файл с отображением картинок из массива $images
		include_once '../view/view.image.php';
	} 
}
?>
