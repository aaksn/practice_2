<?php
include 'dbconn.php';
$link=OpenCon();

//Отображение списка предметов
if (!empty($_GET["course"])) {
    $id = $_GET["course"];
    //echo " Data id:".$_GET["id"]."" ;
    $query = "SELECT * FROM subjects WHERE ID_COURSE=$id";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if ($result) {
        $subjects = []; // Массив для хранения данных
        $rows = mysqli_num_rows($result); // количество полученных строк

        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);
            $subjects[$row[0]] = $row[1];
        };
        /*
        //Пример
        foreach ($subjects as $key => $value) {
            echo '<option value="' . $key . '">' . $value . '</option>';
        };
        */
        echo json_encode(array("subjects" => $subjects));
    };
// закрываем подключение
    mysqli_close($link);
};


//Отображение списка таблиц
if (!empty($_GET["courseid"]) && !empty($_GET["subjectid"])) {
    $courseid = $_GET["courseid"];
    $subjectid = $_GET["subjectid"];

    // выполняем операции с базой данных
    $query = "SELECT * FROM groups WHERE ID_COURSE=$courseid AND ID_SUBJECT=$subjectid";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if ($result) {
        $course = []; // Массив для хранения данных
        $rows = mysqli_num_rows($result); // количество полученных строк

        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);
            $course[$row[0]] = $row[1];
        };
        
        //Выводим результат        
        echo json_encode(array("elements" => $course));
        // закрываем подключение
        mysqli_close($link);
    };
};

//Редактирование списка таблиц
if (!empty($_POST["type"]) && !empty($_POST["courseid"]) && !empty($_POST["subjectid"])) {
	$courseid = $_POST["courseid"];
    $subjectid = $_POST["subjectid"];
    if ($_POST["type"] == "ADD") {
        // выполняем операции с базой данных
        $n = mysqli_query($link, "SELECT max(ID_GROUP) as maxid FROM groups WHERE ID_COURSE=$courseid AND ID_SUBJECT=$subjectid") or die("Ошибка " . mysqli_error($link));
        $u = mysqli_fetch_row($n)[0] + 1;
        mysqli_query($link, "INSERT INTO groups(`ID_GROUP`, `GROUP_NAME`, `ID_COURSE`, `ID_SUBJECT`)  VALUES ($u ,'$u группа',$courseid,$subjectid)") or die("Ошибка " . mysqli_error($link));
        // закрываем подключение
        mysqli_close($link);

        echo "$u";
    }
    if ($_POST["type"] == 'DEL' && !empty($_POST["groupid"])) {
        $groupid = $_POST["groupid"];
        $subjectid = $_POST["subjectid"];
        // выполняем операции с базой данных
        mysqli_query($link, "DELETE FROM groups WHERE ID_GROUP=$groupid AND ID_COURSE=$courseid AND ID_SUBJECT=$subjectid") or die("Ошибка " . mysqli_error($link));
        // закрываем подключение
        mysqli_close($link);

        echo "Deleted";
    }
    if ($_POST["type"] == 'EDIT' && !empty($_POST["data"]) && !empty($_POST["groupid"])) {
        $groupid = $_POST["groupid"];
        $data = $_POST["data"];
        // выполняем операции с базой данных
        mysqli_query($link, "UPDATE groups SET GROUP_NAME='$data' WHERE ID_GROUP=$groupid AND ID_COURSE=$courseid") or die("Ошибка " . mysqli_error($link));
        // закрываем подключение
        mysqli_close($link);

        echo "Edited";
    }
}


?>