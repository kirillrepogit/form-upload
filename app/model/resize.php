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
		$image_p = imagecreatetruecolor($width, $height);
		imagecopyresized($image_p, $source, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		unlink($file);
		imagejpeg($image_p, $file, 100);
		imagedestroy($image_p);
		imagedestroy($source); 

	} catch (Exception $err){
		$message = 'Ошибка во время изменения размера картинки.';
		include '../view/view.message.php';
	}
}

?>