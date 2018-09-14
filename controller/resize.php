<?php

function resizeImage($filename, $src, $type){
	
	try{
		$width = 500;
		$height = 500;
		$file = $src.$filename;
		$size = getimagesize($file);
		$width_orig = $size[0];
		$height_orig = $size[1];
		$ratio_orig = $width_orig/$height_orig;
		if ($width/$height > $ratio_orig) {
			$width = $height*$ratio_orig;
		} else {
			$height = $width/$ratio_orig;
		}
		if ($type == 'image/jpg') $source = imagecreatefromjpeg($file);
		if ($type == 'image/jpeg') $source = imagecreatefromjpeg($file);
    	if ($type == 'image/png') $source = imagecreatefrompng($file);
		if ($type == 'image/gif') $source = imagecreatefromgif($file);
		// создаём новый файл с новыми размерами
		$image_p = imagecreatetruecolor($width, $height);
		// копируем данные из старого в новый
		imagecopyresized($image_p, $source, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		// удаляем старый
		unlink($file);
		// сохраняем новый
		imagejpeg($image_p, $file, 100);
		imagedestroy($image_p);
		imagedestroy($source); 

		return false;
		
	} catch (Exception $err){
		return ['error' => $err->getMessage()];
	}
}

?>