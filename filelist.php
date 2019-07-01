<?php
$host = 'localhost';
$database = 'courses'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль
//Отображение списка таблиц
if (!empty($_GET["id"])) {
	//$id = $_GET["id"] - 1;
	//echo " Data id:".$_GET["id"]."" ;
	$id = $_GET["id"];
	// подключаемся к серверу
	$link = mysqli_connect($host, $user, $password, $database) 
	    or die("Ошибка " . mysqli_error($link));
    // выполняем операции с базой данных
    $coursetables = "c" + $_GET["id"];
    $query ="SELECT * FROM".$coursetables;
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	if($result)
	{
		$course = []; // Массив для хранения данных
	    $rows = mysqli_num_rows($result); // количество полученных строк
	    
	    for ($i = 0 ; $i < $rows ; ++$i)
	    {
	        $row = mysqli_fetch_row($result);
	        $course[$row[0]] = $row[1];
	    }
	    
	    //Выводим результат
		foreach ($course as $key => $value) {
			echo '<li id='.$key.'f"><input type="radio" id="'.$key.'" name="groupselector" /><label for="'.$key.'">'.$value.'</label><a href="javascript:editpos('.$key.');" class="button primary small icon fa-pencil-square-o">Изменить</a> <a href="javascript:deletepos('.$key.');" class="button primary small icon fa-trash">Удалить</a></li>';
	     
	    // очищаем результат
	    mysqli_free_result($result);
	};  
	// закрываем подключение
	mysqli_close($link);
	

	//Пример
	/*$courses = [
		[1 => "1 группа", 2 => "2 группа", 3 => "5 группа"],
		[1 => "2 группа", 2 => "1 группа", 3 => "4 группа"],
		[1 => "1 группа", 2 => "2 группа"],
		[1 => "1 группа", 2 => "2 группа", 3 => "3 группа"],
		[1 => "1 группа", 2 => "2 группа", 3 => "4 группа"],
		[1 => "1 группа", 2 => "2 группа", 3 => "3 группа"]
	];
	foreach ($courses[$id] as $key => $value) {
		echo '<li id='.$key.'f"><input type="radio" id="'.$key.'" name="groupselector" /><label for="'.$key.'">'.$value.'</label><a href="javascript:editpos('.$key.');" class="button primary small icon fa-pencil-square-o">Изменить</a> <a href="javascript:deletepos('.$key.');" class="button primary small icon fa-trash">Удалить</a></li>';
	};*/
};

//Редактирование списка таблиц
if (!empty($_POST["idtable"])&&!empty($_POST["type"])) {	
	if ($_POST["type"] == 'ADD') {
		echo "Type: ADD" ;
	}
	if ($_POST["type"] == 'DEL') {
		echo "Type: DEL" ;
	}
	if ($_POST["type"] == 'EDIT'&&!empty($_POST["data"])) {
		echo "Type: EDIT, Data: ".$_POST["data"]."" ;
	}
}
?>