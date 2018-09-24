<?php

require_once('db.php');
require_once('resize.php');

function loadImages($files){

	$config = require('../config/config.php');
	$dataBase = $config['db_config'];
	
	//заполним поля для подключения к бд
	$hostname = $dataBase['host']; 
	$user = $dataBase['username']; 
	$pass = $dataBase['pass']; 
	$database = $dataBase['database']; 
		
	// подключаемся к базе данных
	$db = new DBHelper($hostname, $user, $pass, $database);
	
	$uploaddir = 'uploads'. DIRECTORY_SEPARATOR ;
	$path = __DIR__;
	$root = str_replace("model", '', $path).'controller'.DIRECTORY_SEPARATOR.$uploaddir;
	$pathFile = str_replace("model", '', $path).'controller/';

	// cоздадим папку если её нет
	if(!is_dir($pathFile.$uploaddir)) mkdir($pathFile.$uploaddir, 0777 );
	// массив значений типов файлов для проверки MIME type
	$types = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif');
	$resultArray = array();
	$resultDB = array();
	// перемебираем каждый файл
	foreach($files as $key => $file){

		if (in_array($file['type'], $types)){
			$dataName = $key;
			// удаляем HTML и PHP теги из строки
			$fileName = uniqid().strip_tags($file['name']);
			$size = getimagesize($file['tmp_name']);
			$sizeFile = intval($file['size']/1024).' кб';
			// переместим файлы из временной директории в указанную
			if(move_uploaded_file($file['tmp_name'],"$root$fileName")){
				if($size[0] > 500 || $size[1] > 500) resizeImage($fileName, $root, $file['type']);	
				$sizeFile = round(filesize($root.$fileName)/1024, 2). ' кб';
				// записываем данные в таблицу
				$resultDB =  $db->query("INSERT INTO images (name, path) VALUES (\"$dataName\", \"$fileName\")");
			}
			$resultArray[] = ['name' => $fileName, 'size' => $sizeFile];

		} else{
			$message = $file['name'].' неверный формат файла.';
			include '../view/view.message.php';
		}
	}
	if(!$resultDB){
		$message = 'Запись в базу данных не выполнена.';
		include '../view/view.message.php';
	}
	return $resultArray;
}
?>