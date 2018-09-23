
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Демонстрация</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="content">
		<div class="section border-bottom">
			<div class="title-logo"><strong>Загрузка</strong></div>
			<div class="title">Это демонстрационная платформа.<br> 
				Здесь отображаются некоторые сценарии или примеры,<br>
				 включая скрипты PHP, Javascript, MySQL.<br> 
				 Пусть вам понравится.
			</div>
		</div>

		<div class="section border-bottom">
			<div class="messageLog"></div>
			<form id="uploadForm" method="post" enctype="multipart/form-data" action="controller/upload.php">
				<div class="list-title">Добавьте желаемое колличество картинок.<br>
										Введите имена, затем выберете картинки.<br>
										После заполнения всех полей - нажмите "Отправить на сервер"</div>
				<div class="list-title">Допустимые форматы JPG, JPEG, PNG, GIF</div>
				<ul id="main-list">
					<li class="item">
						<label>
						<input class="name" type="text" placeholder="Имя картинки"/></label>
						<label>
						<input class="item-hidden" type="file" accept="image/*;capture=camera" name="" />
						<span>Выбрать файл</span></label>
						<p class="error"></p>
					</li>
				</ul>
				
				<input type="button" name="add" id="addFiled" value="Добавить поле"/>
				<input type="submit" value="Отправить на сервер" />
				
			</form>
		</div>
		<div class="section">
			<div class="containerDemo">
				<div class="respond-preview"></div>
				
			</div>
			<div class="date-container"><?=date('d.m.Y');?></div>
		</div>
	</div>
	<script src="js/script.js"></script>
</body>
</html>