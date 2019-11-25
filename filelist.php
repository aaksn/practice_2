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
        //Добавление пользователя и даты
        
        mysqli_query($link, "INSERT INTO `students` (`ID_STUDENT`, `FIO`, `ID_GROUP`, `ID_COURSE`) VALUES (NULL, 'ФИО', '$u', '$courseid')") or die("Ошибка " . mysqli_error($link));
        $id_student = mysqli_fetch_row(mysqli_query($link, "SELECT MAX(ID_STUDENT) FROM students"))[0];
        $add_date = mysqli_query($link, "INSERT INTO dates(`ID_DATE`, `DATE`) VALUES (NULL, '01.01')") or die("Ошибка " . mysqli_error($link));
        $query = mysqli_query($link, "SELECT MAX(ID_DATE) FROM dates") or die("Ошибка " . mysqli_error($link));
        $id_date= mysqli_fetch_row($query)[0];
        mysqli_query($link, "INSERT INTO `attendance` (`ID_ATT`, `ID_SUBJECT`, `ID_STUDENT`, `ID_DATE`, `MARK`) VALUES (NULL, '$subjectid', '$id_student', '5', '0')") or die("Ошибка " . mysqli_error($link));
        
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