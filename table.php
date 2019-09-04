<?php
$host = 'localhost';
$database = 'db'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

//Отображение таблицы
if (!empty($_GET["courseid"]) && !empty($_GET["subjectid"]) && !empty($_GET["groupid"])) {
    $courseid = $_GET["courseid"];
    $groupid = $_GET["groupid"];
    $subjectid = $_GET["subjectid"];

    $link = mysqli_connect($host, $user, $password, $database)
    or die("Ошибка " . mysqli_error($link));
    $res = mysqli_query($link, "SELECT students.ID_STUDENT,students.FIO,attendance.ID_ATT, attendance.ID_DATE, dates.DATE, attendance.MARK FROM students,attendance,dates WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_DATE=dates.ID_DATE AND students.ID_COURSE=$courseid AND students.ID_GROUP=$groupid AND attendance.ID_SUBJECT=$subjectid") or die("Ошибка " . mysqli_error($link));
    $students = [];
    $dates = [];
    $indexes = [];
    $s = [];
    while ($row = mysqli_fetch_row($res)){
        $students[$row[0]] = $row[1];
        $dates[$row[3]] = $row[4];
        $indexes[$row[0]][$row[2]] = $row[5];
    }
    mysqli_close($link);
    foreach ($students as $key => $value) {
        $s[] = array("id" => $key, "name" => $value, "marks" => $indexes[$key]);
    }
    
    //header('Content-Type: application/json');
    echo json_encode(array(
        "students" => $s,
        "dates" => $dates
    ));
    exit;    
}

//Редактирование таблицы
if (!empty($_POST["type"]) && !empty($_POST["courseid"]) && !empty($_POST["subjectid"]) && !empty($_POST["groupid"])) {
    $courseid = $_POST["courseid"];
    $groupid = $_POST["groupid"];
    $subjectid = $_POST["subjectid"];
    $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
    
    /*
    //все предметы
    $subjects = mysqli_fetch_row(mysqli_query($link, "SELECT DISTINCT ID_SUBJECT FROM groups WHERE ID_GROUP=$groupid AND ID_COURSE=$courseid)") or die("Ошибка " . mysqli_error($link)));
    //все даты
    $alldates = mysqli_fetch_row(mysqli_query($link, "SELECT DISTINCT DATE_POS as datee FROM attendance,students WHERE attendance.ID_STUDENT=students.ID_STUDENT and ID_GROUP=$groupid AND ID_COURSE=$courseid)") or die("Ошибка " . mysqli_error($link)));
    */

    if ($_POST["type"] == 'ADDSTUDENT' && !empty($_POST["fio"])) {
        $fio = $_POST["fio"];        
        // выполняем операции с базой данных
        //добавляем студента
        mysqli_query($link, "INSERT INTO `students` (`ID_STUDENT`, `FIO`, `ID_GROUP`, `ID_COURSE`) VALUES (NULL, '$fio', '$groupid', '$courseid')") or die("Ошибка " . mysqli_error($link));
        $qid = mysqli_query($link, "SELECT MAX(ID_STUDENT) FROM students WHERE ID_COURSE=$courseid AND ID_GROUP=$groupid") or die("Ошибка " . mysqli_error($link));
        $arr_studentid = mysqli_fetch_row($qid);        
        //добавляем все даты в успеваемость        
        $dates = mysqli_query($link, "SELECT DISTINCT ID_DATE FROM attendance,students WHERE attendance.ID_STUDENT=students.ID_STUDENT AND ID_GROUP=$groupid AND ID_COURSE=$courseid and ID_SUBJECT=$subjectid") or die("Ошибка " . mysqli_error($link));
        $index = mysqli_fetch_row(mysqli_query($link, "SELECT MAX(ID_ATT) FROM attendance"))[0];
        $indexes = [];  
        while ($row = mysqli_fetch_row($dates)){
            $index++;
            $indexes[] = $index;            
            mysqli_query($link, "INSERT INTO `attendance` (`ID_ATT`, `ID_SUBJECT`, `ID_STUDENT`, `ID_DATE`, `MARK`) VALUES (NULL, '$subjectid', '$arr_studentid[0]', '$row[0]', '0')") or die("Ошибка " . mysqli_error($link));                        
        }
        echo json_encode(array(
            "id" => $arr_studentid[0],
            "dates" => $indexes
        ));
    }
    if ($_POST["type"] == 'ADDDATE' && !empty($_POST["date"])) {
        $date = $_POST["date"];        
        // выполняем операции с базой данных
        //Добавляем новую дату
        $add_date = mysqli_query($link, "INSERT INTO dates(`ID_DATE`, `DATE`) VALUES (NULL, '$date')") or die("Ошибка " . mysqli_error($link));
        $query = mysqli_query($link, "SELECT MAX(ID_DATE) FROM dates") or die("Ошибка " . mysqli_error($link));
        $id_date= mysqli_fetch_row($query)[0];
        //ищем всех студентов с данными группой, курсом, предметом
        $students = mysqli_query($link, "SELECT DISTINCT students.ID_STUDENT FROM attendance,students WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_SUBJECT=$subjectid AND students.ID_GROUP=$groupid AND students.ID_COURSE=$courseid") or die("Ошибка " . mysqli_error($link));
        //добавляем дату в успеваемость для всех студентов
        $index = mysqli_fetch_row(mysqli_query($link, "SELECT MAX(ID_ATT) FROM attendance"))[0];
        $indexes = []; 
        while ($row = mysqli_fetch_row($students)){
            $index++;
            $indexes[] = $index; 
            mysqli_query($link, "INSERT INTO `attendance` (`ID_ATT`, `ID_SUBJECT`, `ID_STUDENT`, `ID_DATE`, `MARK`) VALUES (NULL, '$subjectid', '$row[0]', '$id_date', '0')") or die("Ошибка " . mysqli_error($link));                        
        }        
        echo json_encode(array(
            "id" => $id_date,
            "ids" => $indexes
        ));
    }
    if ($_POST["type"] == 'CHANGENAME' && !empty($_POST["data"]) && !empty($_POST["id"])) {       
        $fio = $_POST["data"];//новые фио
        $id = $_POST["id"];        
        // выполняем операции с базой данных
        mysqli_query($link, "UPDATE students SET FIO='$fio' WHERE ID_STUDENT=$id AND ID_COURSE=$courseid AND ID_GROUP=$groupid") or die("Ошибка " . mysqli_error($link));
        
        echo "Type: CHANGENAME";
    }
    if ($_POST["type"] == 'CHANGEDATE' && !empty($_POST["id"]) && !empty($_POST["data"])) {
        $id_date = $_POST["id"];//айди даты
        $data = $_POST["data"];        
        // выполняем операции с базой данных
        mysqli_query($link, "UPDATE dates SET DATE='$data' WHERE ID_DATE=$id_date") or die("Ошибка " . mysqli_error($link));
       
        echo "Type: CHANGEDATE";
    }
    if ($_POST["type"] == 'CHANGEMARK' && !empty($_POST["id"])) {
        $id = $_POST["id"];//айди даты
        $data = $_POST["data"];        
        // выполняем операции с базой данных
        mysqli_query($link, "UPDATE attendance SET MARK = '$data' WHERE ID_ATT = $id") or die("Ошибка " . mysqli_error($link));
        
        echo "Type: CHANGEMARK";
    }
    // закрываем подключение
    mysqli_close($link);
}
?>