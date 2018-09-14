<?php
header("Content-Type: text/html;charset=UTF-8");

require_once('db.php');
require_once('mail.php');
require_once('resize.php');

//  заполнить поля для подключения к бд
$hostname = ""; // путь к Базе Данных
$user = ""; // имя пользователя с доступом к таблице
$pass = ""; // пароль пользователя 
$database = ""; // имя Базы Данных 

//настройки для отправки письма с помощью PHPMailer
$host = ''; // адрес сервера клиента почты
$login = ''; // имя почтового ящика/ логин
$passMail = ''; // пароль 
$smtpSecure = ''; // шифрование ssl / tls
$port = ''; // порт 
$from = ''; // от кого, укажите имя почтового ящик
$to = ''; // кому будете слать

// подготовим массив для сравнения типов файлов
$types = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif');
$root = $_SERVER['SCRIPT_FILENAME'];
$root = str_replace("upload.php", '', $root);
$uploaddir = 'uploads/'; 
$root .= $uploaddir;

if(!empty($_POST['file_upload'])){ 
	// подготовим массив сообщений для отправки
	$resultArray = array();
	try{
		// cоздадим папку если её нет
		if(!is_dir($uploaddir)) mkdir( $uploaddir, 0777 );
		$files  = $_FILES; // полученные файлы
		$resultArray = array();
		// подключаемся к БД
		$db = new DBHelper($hostname, $user, $pass, $database);
		// перемебираем каждый файл
		foreach($files as $key => $file){
			// проверим или файл соответствует типам
			if (in_array($file['type'], $types)){
				// получаем поле "название картинки"
				$dataName = $key;
				// удаляем HTML и PHP теги из строки
				$fileName = uniqid().strip_tags($file['name']);
				// получаем массив размеров файла
				$size = getimagesize($file['tmp_name']);
				// размер в колибайтах
				$sizeFile = intval($file['size']/1024).' кб';
				// переместим файлы из временной директории в указанную
				if(move_uploaded_file($file['tmp_name'],"$uploaddir/$fileName")){
					// если картинка больше 500px по ширине или высоте, 
					// создадим из неё новую с помощью подготовленной функции
					if($size[0] > 500 || $size[1] > 500) {
						$resultResize = resizeImage($fileName, $root, $file['type']);
						if($resultResize != false) array_push($resultArray, $resultResize);
					}
					// получим новый размер файла на диске
					$sizeFile = round(filesize($root.$fileName)/1024, 2). ' кб';
					// записываем данные в таблицу
					$resultQuery = $db->query("INSERT INTO images (name, path) VALUES (\"$dataName\", \"$fileName\")");
					if(!$resultQuery) array_push($resultArray, ['error' => 'Не удалось записать в базу данных']);
				} 
				// запишем параметры в массив
				$resultArray[] = ['path' => $fileName, 'size' => $sizeFile];
				array_push($arrayImageMessage, [$root.$fileName, $fileName]);
			} else{
				// если файл не соответствует типу, отправим сообщение
				array_push($resultArray, ['error' => $file['name'].' неверный формат файла.']);
			}
		}
		
		// отправляем сообщение на почту 
		$resulMail = sendMail($host, $login, $passMail, $smtpSecure, $port, $from, $to, $arrayImageMessage);
		if($resulMail != false) array_push($resultArray, $resulMail);
		echo json_encode($resultArray);

	} catch (Exception $err){
		echo json_encode(['error' => 'Случилась непредвиденная ошибка. ']);
	}
}

?>
