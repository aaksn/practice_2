<?php
//Отображение таблицы
if (!empty($_GET["idtable"])) {
	if (!empty($_GET["id"])) {
		echo " Data id:".$_GET["id"]."" ;
	} else {
		echo "Выберите группу";
	}
}

//Редактирование таблицы
if (!empty($_POST["type"]) && !empty($_POST["idtable"])) {	
	if ($_POST["type"] == 'ADDSTUDENT') {
		echo "Type: ADDSTUDENT Table id is:".$_POST["idtable"]."" ;
	}
	if ($_POST["type"] == 'CHANGENAME' && !empty($_POST["id"]) && !empty($_POST["data"])) {
		echo "Type: CHANGENAME Id is:".$_POST["idtable"]."" ;
	}
	if ($_POST["type"] == 'CHANGEDATE' && !empty($_POST["id"]) && !empty($_POST["data"])) {
		echo "Type: CHANGEDATE Id is:".$_POST["idtable"]."" ;
	}
}
?>