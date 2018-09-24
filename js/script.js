(function(){

	var url = document.location.href + "app/controller/controller.php";
	var src = document.location.href + "controller/uploads/";

	var form = document.getElementById("uploadForm");
	var addFiled = document.getElementById("addFiled");
	var mainList = document.getElementById("main-list");
	var preview = document.querySelector('.respond-preview');
	var errorMessage = document.querySelector('.messageLog');
	var inputUpload = document.querySelector('.item-hidden');

	addFiled.addEventListener("click", addItem, false);
	inputUpload.addEventListener("change", changeStatus, false);
	form.addEventListener("submit", formUpload, false);
	form.reset();

	function changeStatus(event) {
		var parent = event.target.parentNode;
		var spanItem = parent.querySelector('span');
		spanItem.innerText = "Файл выбран";
		spanItem.classList = 'loaded';
		event.target.removeEventListener("change", changeStatus, false);
	}

	function setErrorMessage(item, string) {
		clearErrorMessage();
		var parentOne = item.parentNode;
		var parent = parentOne.parentNode;
		var pItem = parent.querySelector('p.error');
		pItem.innerText = string;
	}

	function clearErrorMessage() {
		var error = document.querySelectorAll('.error');
		Array.prototype.forEach.call(error, function(item) {
			item.innerText = '';
		});
	}

	function resetList(){
		var spanLoaded = document.querySelectorAll('.loaded');
		var ul = document.querySelector('#main-list');
		var listItem = ul.children;

		var arrayItem = [];
		Array.prototype.forEach.call(listItem, function (item, index) {
			if (index > 0) arrayItem.push(item);
		});
		arrayItem.forEach(function (item) {
			item.remove();
		});

		Array.prototype.forEach.call(spanLoaded, function (item) {
			item.classList.remove('loaded');
		});
	}

	function createItem(){

		var labelItemImage = document.createElement('label');
		var labelItemName = document.createElement('label');

		var spanItem = document.createElement('span');
		spanItem.innerText = 'Выбрать файл';

		var inputName = document.createElement('input');
		inputName.setAttribute('type', "text");
		inputName.setAttribute('placeholder',"Имя картинки");
		inputName.className = "name"; 

		var inputFile = document.createElement('input');
		inputFile.setAttribute( 'type', "file");
		inputFile.name = "images";
		inputFile.accept = "image/*";
		inputFile.className = "item-hidden";
		inputFile.addEventListener("change", changeStatus, false);

		var pItem = document.createElement('p');
		pItem.className = 'error';

		var listItem = document.createElement('li');
		listItem.className = "item";

		labelItemImage.appendChild(inputFile);
		labelItemImage.appendChild(spanItem);
		labelItemName.appendChild(inputName);
		listItem.appendChild(labelItemName);
		listItem.appendChild(labelItemImage);
		listItem.appendChild(pItem);
		
		return listItem;
	}

	function formUpload(event) {
		event.preventDefault();
		var inputForm = form.querySelector('input[type="submit"]');
		var files = form.querySelectorAll('input[type="file"]');
		var names = form.querySelectorAll('input[type="text"]');
		var data = new FormData();
		data.append('file_upload', 1);
		var chek = true;
		Array.prototype.forEach.call(files, function(file, index) {
			if (!validateFiles(file)) chek = false;
			if (!validateName(names[index])) chek = false;
			data.append(names[index].value, file.files[0]);
		});
		if(!chek) return;
		inputForm.disabled = true;
		var dataSender = new XMLHttpRequest();
		dataSender.open("POST", url, true);
		dataSender.onload  = function (data) {
			if (data.target.response) {
				errorMessage.innerHTML = data.target.response;
			} else {
				errorMessage.innerHTML = "Ошибка: Не удалось связаться с сервером";
			}
		};
		dataSender.send(data);
		inputForm.disabled = false;
		clearErrorMessage();
		resetList();
		form.reset();
		inputUpload.addEventListener("change", changeStatus, false);
	}

	function inArray(type, array) {
		var respond = false;
		array.forEach(function(item){
			if (item == type) respond = true;
		});
		return respond;
	}

	function validateName(item){
		var regexp = /(&nbsp;|<([^>]+)>|[$-/:-?{-~!№"^_`\[\]])/ig;
		if (item.value == ''){
			item.focus();
			setErrorMessage(item, 'Заполните поле \"Имя картинки\"');
			return false;
		} else if(item.value.match(regexp)) {
			item.focus();
			setErrorMessage(item, 'Поле должно содержать символы А-Я, A-Z или цифры');
			return false;
		} 
		return true;
	}
	
	function validateFiles(item){
		var array = ['image/jpeg', 'image/jpg', 'image/png','image/gif'];
		if(item.files.length != 0){
			var type = item.files[0].type;
			if (!inArray(type.toLowerCase(), array)){
				item.focus();
				setErrorMessage(item, 'Допустимые форматы: JPG, JPEG, PNG, GIF');
				return false;
			} else{
				 return true;
			}
		} else {
			item.focus();
			setErrorMessage(item, 'Выберете файл');
			return false;
		}
	}
		
	function addItem(){
		var item = createItem();
		mainList.appendChild(item);
	}
	
})();