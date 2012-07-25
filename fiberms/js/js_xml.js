/*
Функция создания XMLHttpRequest
*/
function CreateRequest()
{
	var Request = false;

	if (window.XMLHttpRequest)
	{
		//Gecko-совместимые браузеры, Safari, Konqueror
		Request = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		//Internet explorer
		Request = new ActiveXObject("Microsoft.XMLHTTP");
	
		if (!Request)
		{
			HRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}
	}
 
	if (!Request)
	{
		alert("Невозможно создать XMLHttpRequest");
	}
	
	return Request;
}

/*
Функция посылки запроса к файлу на сервере
r_method  — тип запроса: GET или POST
r_path    — путь к файлу
r_args    — аргументы вида a=1&b=2&c=3...
r_handler — функция-обработчик ответа от сервера
*/
function SendRequest(r_method, r_path, r_args, r_handler)
{
	//Создаём запрос
	var Request = CreateRequest();
	
	//Проверяем существование запроса еще раз
	if (!Request)
	{
		return;
	}
	
	//Назначаем пользовательский обработчик
	Request.onreadystatechange = function()
	{
		//Если обмен данными завершен
		if (Request.readyState == 4)
		{
			//Передаем управление обработчику пользователя
			r_handler(Request);
		}
	}
	
	//Проверяем, если требуется сделать GET-запрос
	if (r_method.toLowerCase() == "get" && r_args.length > 0)
	r_path += "?" + r_args;
	
	//Инициализируем соединение
	Request.open(r_method, r_path, true);
	
	if (r_method.toLowerCase() == "post")
	{
		//Если это POST-запрос
		
		//Устанавливаем заголовок
		Request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
		//Посылаем запрос
		Request.send(r_args);
	}
	else
	{
		//Если это GET-запрос
		
		//Посылаем нуль-запрос
		Request.send(null);
	}
}

/*
Функция для получения файла
filename — имя файла (относительный или абсолютный от корня Web-сайта)
handler — функция-обработчик результата
*/
function GetXMLFile(filename, handler)
{	
	//Посылаем запрос
	SendRequest("GET",filename,"",handler);
}