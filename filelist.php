<?php
//Отображение списка таблиц
if (!empty($_GET["id"])) {
	echo " Data id:".$_GET["id"]."" ;
}

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