<?php
$host = 'localhost';
$database = 'db'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

//Отображение таблицы
if (!empty($_POST["courseid"]) && !empty($_POST["subjectid"]) && !empty($_POST["groupid"])) {
    $courseid = $_POST["courseid"];
    $groupid = $_POST["groupid"];
    $subjectid = $_POST["subjectid"];

    $link = mysqli_connect($host, $user, $password, $database)
    or die("Ошибка " . mysqli_error($link));
    //запрос успеваемости
    $query = "SELECT students.FIO,attendance.DATE_POS,attendance.MARK FROM attendance,students WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_SUBJECT=$subjectid AND students.ID_GROUP=$groupid AND students.ID_COURSE=$courseid";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
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
    }
}

//Редактирование таблицы
if (!empty($_POST["type"]) && !empty($_POST["courseid"]) && !empty($_POST["subjectid"]) && !empty($_POST["groupid"])) {
    $courseid = $_POST["courseid"];
    $groupid = $_POST["groupid"];
    $subjectid = $_POST["subjectid"];

    if ($_POST["type"] == 'ADDSTUDENT' && !empty($_POST["fio"])) {
        $fio = $_POST["fio"];

        $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
        // выполняем операции с базой данных
        //добавляем студента
        mysqli_query($link, "INSERT INTO students(`FIO`, `ID_GROUP`, `ID_COURSE`) VALUES ($fio,$groupid,$courseid)") or die("Ошибка " . mysqli_error($link));
        //ищем его id
        $qid = mysqli_query($link, "SELECT ID_STUDENT FROM students WHERE FIO=$fio AND ID_COURSE=$courseid AND ID_GROUP=$groupid") or die("Ошибка " . mysqli_error($link));
        $arr_studentid = mysqli_fetch_row($qid);
        //ищем все даты его группы
        $dates = mysqli_query($link, "SELECT DISTINCT DATE_POS as datee FROM attendance,students WHERE attendance.ID_STUDENT=students.ID_STUDENT and ID_GROUP=$groupid AND ID_COURSE=$courseid)") or die("Ошибка " . mysqli_error($link));
        $arr_dates = mysqli_fetch_row($dates);
        //добавляем все даты в успеваемость
        for ($i = 0; $i < mysqli_num_rows($dates); $i++) {
            mysqli_query($link, "INSERT INTO attendance (`ID_SUBJECT`, `ID_STUDENT`, `DATE_POS`) VALUES ($subjectid,$arr_studentid[0],$arr_dates[$i])") or die("Ошибка " . mysqli_error($link));
        }
        // закрываем подключение
        mysqli_close($link);

        echo "Type: ADDSTUDENT Table id is:" . $_POST["idtable"] . "";
    }
    if ($_POST["type"] == 'ADDDATE' && !empty($_POST["fio"])) {
        $date = $_POST["date"];
        $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
        // выполняем операции с базой данных
        //ищем всех сдуентов с данными группой, курсом, предметом
        $students = mysqli_query($link, "SELECT students.ID_STUDENT FROM attendance,students WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_SUBJECT=$subjectid AND students.ID_GROUP=$groupid AND students.ID_COURSE=$courseid") or die("Ошибка " . mysqli_error($link));
        $arr_student = mysqli_fetch_row($dates);
        //добавляем дату в успеваемость для всех студентов
        for ($i = 0; $i < mysqli_num_rows($students); $i++) {
            mysqli_query($link, "INSERT INTO attendance (`ID_SUBJECT`, `ID_STUDENT`, `DATE_POS`) VALUES ($subjectid,$arr_student[$i],'$date')") or die("Ошибка " . mysqli_error($link));
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
        $date_old=$_GET["date"];//старая дата
        $date = $_POST["date"];
        $link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
        // выполняем операции с базой данных
        //ищем всех сдуентов с данными группой, курсом, предметом
        $students = mysqli_query($link, "SELECT students.ID_STUDENT FROM attendance,students WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_SUBJECT=$subjectid AND students.ID_GROUP=$groupid AND students.ID_COURSE=$courseid") or die("Ошибка " . mysqli_error($link));
        $arr_student = mysqli_fetch_row($dates);
        //изменяем дату в успеваемости для всех студентов
        for ($i = 0; $i < mysqli_num_rows($students); $i++) {
            mysqli_query($link, "UPDATE attendance SET DATE_POS=$date WHERE DATE_POS=$date_old AND ID_STUDENT=$arr_student[$i] AND ID_COURSE=$courseid AND ID_GROUP=$groupid AND ID_SUBJECT=$subjectid") or die("Ошибка " . mysqli_error($link));
        }
        // закрываем подключение
        mysqli_close($link);

        echo "Type: CHANGEDATE Id is:" . $_POST["idtable"] . "";
    }
}
?>