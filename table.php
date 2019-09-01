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
    //запрос успеваемости
    $query = "SELECT students.FIO,dates.DATE,attendance.MARK FROM attendance,students,dates WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_DATE=dates.ID_DATE AND attendance.ID_SUBJECT=$subjectid AND students.ID_GROUP=$groupid AND students.ID_COURSE=$courseid";
    //$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    
    echo json_encode(array(
        "students" => array(
            array(
                "id" => 1,
                "name" => "Petrov",
                "marks" => array("1" => 0, "2" => 1)
            ),
            array(
                "id" => 2,
                "name" => "Sidorov",
                "marks" => array("3" => 1, "4" => 1)
            )
        ),
        "dates" => array(
            1 => "date 1",
            2 => "date 2"
            ) 
    ));
    exit;

    /*
    if ($result) {
        $subjects = []; // Массив для хранения данных
        $rows = mysqli_num_rows($result); // количество полученных строк

        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);
            $subjects[$row[0]] = $row[1];
        };

        //Пример
        foreach ($subjects as $key => $value) {
            echo '<option value="' . $key . '">' . $value . '</option>';
        };

        echo "" . count($t[2]) . "";
        echo "<thead><tr><th>Имя</th>";
        foreach ($t[1] as $key => $value) {
            echo '<th><a id="d' . $key . '" href="javascript:changedate(';
            echo "'d" . $key . "')";
            echo '">' . $value . '</a></th>';
        }
        echo '<th><a href="javascript:adddate();" class="icon fa-plus"></a></th></tr></thead><tbody>';
        $keys = array_keys($t[0]);
        for ($i = 1; $i <= count($t[0]); $i++) {
            echo '<tr><td><a id="n' . $keys[$i] . '" href="javascript:changename(';
            echo "'n" . $keys[$i - 1] . "')";
            echo '">' . $t[0][$i] . '</a></td>';
            for ($j = 1; $j <= count($t[2][1]); $j++) {

                echo '<<td><a id="m' . $keys[$i - 1] . '_' . $j . '" href="javascript:change(';
                echo "'m" . $keys[$i - 1] . "_" . $j . "')";
                echo '" class="icon fa-times"></a></td>';
            }
            echo "</tr>";
        }
        echo '</tbody><tfoot><tr><td><a href="javascript:addstudent();" class="icon fa-plus"> Добавить студента</a></td></tr></tfoot>';
    } else {
        echo "Выберите группу";
    }*/
}

//Редактирование таблицы
if (!empty($_POST["type"]) && !empty($_POST["courseid"]) && !empty($_POST["subjectid"]) && !empty($_POST["groupid"])) {
    $courseid = $_POST["courseid"];
    $groupid = $_POST["groupid"];
    $subjectid = $_POST["subjectid"];

    //все предметы
    $subjects = mysqli_fetch_row(mysqli_query($link, "SELECT DISTINCT ID_SUBJECT FROM groups WHERE ID_GROUP=$groupid AND ID_COURSE=$courseid)") or die("Ошибка " . mysqli_error($link)));
    //все даты
    $alldates = mysqli_fetch_row(mysqli_query($link, "SELECT DISTINCT DATE_POS as datee FROM attendance,students WHERE attendance.ID_STUDENT=students.ID_STUDENT and ID_GROUP=$groupid AND ID_COURSE=$courseid)") or die("Ошибка " . mysqli_error($link)));


    if ($_POST["type"] == 'ADDSTUDENT' && !empty($_POST["fio"])) {
        $fio = $_POST["fio"];

        $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
        // выполняем операции с базой данных
        //добавляем студента
        mysqli_query($link, "INSERT INTO students(`FIO`, `ID_GROUP`, `ID_COURSE`) VALUES ($fio,$groupid,$courseid)") or die("Ошибка " . mysqli_error($link));
        //ищем его id
        $qid = mysqli_query($link, "SELECT ID_STUDENT FROM students WHERE FIO=$fio AND ID_COURSE=$courseid AND ID_GROUP=$groupid") or die("Ошибка " . mysqli_error($link));
        $arr_studentid = mysqli_fetch_row($qid);
        //добавляем все даты в успеваемость
        for ($i = 0; $i < mysqli_num_rows($subjects); $i++) {
            $dates = mysqli_fetch_row(mysqli_query($link, "SELECT DISTINCT ID_DATE FROM attendance,students WHERE attendance.ID_STUDENT=students.ID_STUDENT AND ID_GROUP=$groupid AND ID_COURSE=$courseid and ID_SUBJECT=$subjects[i])") or die("Ошибка " . mysqli_error($link)));
            for ($j = 0; $j < mysqli_num_rows($dates); $j++) {
                mysqli_query($link, "INSERT INTO attendance (`ID_SUBJECT`, `ID_STUDENT`, `ID_DATE`) VALUES ($subjects[i],$arr_studentid[0],$dates[$j])") or die("Ошибка " . mysqli_error($link));
            }
        }
        // закрываем подключение
        mysqli_close($link);

        echo "Type: ADDSTUDENT Table id is:" . $_POST["idtable"] . "";
    }
    if ($_POST["type"] == 'ADDDATE' && !empty($_POST["fio"])) {
        $date = $_POST["date"];
        $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
        // выполняем операции с базой данных
        //Добавляем новую дату
        $add_date = mysqli_query($link, "INSERT INTO dates(`ID_DATE`, `DATE`) VALUES (,$date)") or die("Ошибка " . mysqli_error($link));
        $id_date= mysqli_fetch_row(mysqli_query($link, "SELECT ID_DATE FROM dates WHERE DATES=$date") or die("Ошибка " . mysqli_error($link)));
        //ищем всех сдуентов с данными группой, курсом, предметом
        $students = mysqli_query($link, "SELECT students.ID_STUDENT FROM attendance,students WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_SUBJECT=$subjectid AND students.ID_GROUP=$groupid AND students.ID_COURSE=$courseid") or die("Ошибка " . mysqli_error($link));
        $arr_student = mysqli_fetch_row($students);
        //добавляем дату в успеваемость для всех студентов
        for ($i = 0; $i < mysqli_num_rows($students); $i++) {
            mysqli_query($link, "INSERT INTO attendance (`ID_SUBJECT`, `ID_STUDENT`, `ID_DATE`) VALUES ($subjectid,$arr_student[$i],'$id_date')") or die("Ошибка " . mysqli_error($link));
        }
        // закрываем подключение
        mysqli_close($link);

        echo "Type: ADDSTUDENT Table id is:" . $_POST["idtable"] . "";
    }
    if ($_POST["type"] == 'CHANGENAME' && !empty($_POST["fio"])) {
        $fio_old = $_GET["fio"];//старые фио
        $fio = $_POST["fio"];//новые фио
        $link = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка " . mysqli_error($link));
        // выполняем операции с базой данных
        mysqli_query($link, "UPDATE students SET FIO=$fio WHERE FIO=$fio_old AND ID_COURSE=$courseid AND ID_GROUP=$groupid") or die("Ошибка " . mysqli_error($link));
        // закрываем подключение
        mysqli_close($link);

        echo "Type: CHANGENAME Id is:" . $_POST["idtable"] . "";
    }
    if ($_POST["type"] == 'CHANGEDATE' && !empty($_POST["id"]) && !empty($_POST["data"])) {
        $id_date=$_GET["date"];//айди даты
        $date = $_POST["date"];
        $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
        // выполняем операции с базой данных
        mysqli_query($link, "UPDATE dates SET DATE='$date' WHERE ID_DATE=$id_date") or die("Ошибка " . mysqli_error($link));
        // закрываем подключение
        mysqli_close($link);

        echo "Type: CHANGEDATE Id is:" . $_POST["idtable"] . "";
    }
}
?>