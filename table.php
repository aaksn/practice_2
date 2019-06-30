<?php
//Отображение таблицы
if (!empty($_GET["idtable"])) {
	// idtable - course
	if (!empty($_GET["id"])) {
		//echo " Data id:".$_GET["id"]."" ;
		
		$names = [1 =>"Аксенов А.А.", 2 => "Погорелов Р. И.", 3 => "Сычев А.В."];
		$dates = [1 => "1.01", 2 => "2.02", 3 => "3.03", 4 => "4.04", 5 => "5.05"];
		$marks = [1 => [TRUE, TRUE, FALSE, TRUE, FALSE], 2 => [TRUE, TRUE, FALSE, TRUE, FALSE], 3 => [FALSE, TRUE, FALSE, FALSE, FALSE]];

		$t1 = [$names, $dates, $marks];
		$t2 = [$names, $dates, $marks];
		$t3 = [$names, $dates, $marks];
		
		$c1 = [$t1, $t2, $t3];
		$c2 = [$t1, $t2, $t3];
		$c3 = [$t1, $t3];
		$c4 = [$t1, $t2, $t3];
		$c5 = [$t1, $t2, $t3];
		$c6 = [$t1, $t2, $t3];

		$c = [$c1, $c2, $c3, $c4, $c5, $c6];

		$t = $c[$_GET["idtable"] - 1][$_GET["id"] - 1];
		echo "".count($t[2])."";
		echo "<thead><tr><th>Имя</th>";
		foreach ($t[1] as $key => $value) {
			echo '<th><a id="d'.$key.'" href="javascript:changedate(';
			echo "'d".$key."')";
			echo '">'.$value.'</a></th>';
		}
		echo '<th><a href="javascript:adddate();" class="icon fa-plus"></a></th></tr></thead><tbody>';
		$keys = array_keys($t[0]);
		for ($i = 1; $i <= count($t[0]); $i++) { 
			echo '<tr><td><a id="n'.$keys[$i].'" href="javascript:changename(';
			echo "'n".$keys[$i - 1]."')";
			echo '">'.$t[0][$i].'</a></td>';
			for ($j = 1; $j <= count($t[2][1]); $j++) {
			    
				echo '<<td><a id="m'.$keys[$i - 1].'_'.$j.'" href="javascript:change(';
				echo "'m".$keys[$i - 1]."_".$j."')";
				echo '" class="icon fa-times"></a></td>';				
			}
			echo "</tr>";
		}
		echo '</tbody><tfoot><tr><td><a href="javascript:addstudent();" class="icon fa-plus"> Добавить студента</a></td></tr></tfoot>';
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