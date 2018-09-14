# "ЗАГРУЗКА"
***
	Для выполнения скрипта необходимо внести (в файле  по пути: controller/upload.php) 
настройки подключения к базе данных вашего сервера, а также настройки подключения почтового сервера SMTP

## Кратко о работе
***
	Скрипт выполняет загрузку файлов типа: JPEG, JPG, GIF и PNG, на сервер. 
Проверяет поля на заполненость с помощью javascript, в случае пустых полей выводит сообщение. 
Также с помощью регулярного выражения и функции strip_tags проверяет или вырезает присутствующие HTML, PHP теги или другие символы. Проверяет загружаемый файл на соответствующий условиям тип воспользовавшись параметром свойства файла (как клиент так и сервер).
После загрузки на сервер картинки с размером больше чем 500*500px обрезаються. Записывает имена и названия файлов в базу данных, посылает информацию о загрузке на почту и выводит клиенту в браузер загруженные изображения.
В случае невыполнения одного из сценариев, пользователю выводится сообщение с ошибкой.
## тестовое задание "Загрузка"
***
	Сделать веб-страницу с формой для загрузки изображений на сервер, скрипт, 
загружающий изображения с этой формы и выводом загруженных изображений на страницу
***
## ТРЕБОВАНИЯ К ФОРМЕ:
***
 - посетитель самостоятельно может выбрать количество картинок, которые он может загрузить за одну отправку формы (возможность добавления полей ввода на javascript без перезагрузки страницы на клиентской стороне).
 - каждый файл имеет обязательное текстовое поле "название" (не забываем, что поля добавляются посетителем).
 ***
 ## ТРЕБОВАНИЯ К СКРИПТУ, ПРИНИМАЮЩЕМУ ФОРМУ:
 ***
 - отправка файлов происходит без перезагрузки страницы.
 - скрипт записывает файлы в папку на диске сервера.
 - делает запись в базе данных mysql с информацией о каждом файле (название, имя файла на диске).
 - если какой-либо файл имеет размер больше 500х500 px, то скрипт уменьшает эту картинку и записывает на диск пропорционально уменьшенную до  500х500px.
 - скрипт отправляет администратору e-mail уведомление, о том, что загружены новые картинки со ссылкой на их просмотр.
 - после загрузки файлов, скрипт дополняет страницу таблицей с уже загруженными файлами, с информацией о размере каждого на диске, маленькой картинкой 100х100 (все это без перезагрузки страницы).
 ## ТАКЖЕ НЕОБХОДИМО:
 *** 
 - Необходимо скрипты написать в рамках концепции MVC, так как все современные фреймворки работают именно по этой концепции.
 - Обязательно продумать и сделать защиту от злоумышленников и идиотов, обязательно при отправке выполненного задания кратко описать от чего она защищает и как работает.
 - продумать и сделать сообщения об ошибках, в случае неудачной загрузки картинок. Сообщения должны быть на литературном русском языке, написаны понятно.
 - продумать как следить за уникальностью имен файлов, обязательно при отправке выполненного задания кратко описать как работает. 
 - таблицы mysql должны сами создаваться при первом запуске.
 - крайне приветствуется приличный внешний вид – минимальное творчество и обязательное использование css – ВАЖНО обратить на это внимание.
 ## ВАЖНО:
 ***
 - кодировка utf-8.
- скрипт должен запускаться по любому пути – в корне, в подпапке и т.д.
- ПРОВЕРЬТЕ то, что у Вас получилось, на разных разрешениях и в разных браузерах.
***