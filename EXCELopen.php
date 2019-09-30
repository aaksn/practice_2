<?php
include 'dbconn.php';

if (!empty($_GET["courseid"]) && !empty($_GET["subjectid"]) && !empty($_GET["groupid"])) {
    if ($_GET["groupid"] == 'undefined' | $_GET["subjectid"] == 'undefined') {
        header("Location: base.html");
        exit();
    }

    $courseid = $_GET["courseid"];
    $groupid = $_GET["groupid"];
    $subjectid = $_GET["subjectid"];
//$courseid = 1;
//$groupid = 4;
//$subjectid = 2;

    require_once 'phpexcel/PHPExcel.php';
    $inputFileName = $_GET["inputFile"];;
//$inputFileName='1.xlsx';
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
    }

    $link=OpenCon();
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    for ($row = 1; $row <= $highestRow; $row++) {
        for ($col = 0; $col < $highestColumnIndex; $col++) {
            $cell = $sheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
            if ($row == 1 and $col != 0) {
                mysqli_query($link, "INSERT INTO dates(`ID_DATE`, `DATE`) VALUES (NULL, '$val')") or die("Ошибка " . mysqli_error($link));
            }
            if ($col == 0 and $row != 1) {
                mysqli_query($link, "INSERT INTO `students` (`ID_STUDENT`, `FIO`, `ID_GROUP`, `ID_COURSE`) VALUES (NULL, '$val', '$groupid', '$courseid')") or die("Ошибка " . mysqli_error($link));
            }
            if ($col != 0 and $row != 1) {
                $cellFIO = $sheet->getCellByColumnAndRow(0, $row);
                $FIO = $cellFIO->getValue();
                $cellDate = $sheet->getCellByColumnAndRow($col, 1);
                $Date = $cellDate->getValue();
                if ($val == '+') {
                    $val = 1;
                } else {
                    $val = 0;
                }
                $date = mysqli_query($link, "SELECT ID_DATE FROM dates WHERE DATE=$Date") or die("Ошибка11 " . mysqli_error($link));
                $dates = mysqli_fetch_array($date);
                echo $dates[0] . " ";
                $student = mysqli_query($link, "SELECT ID_STUDENT FROM students WHERE FIO='$FIO' AND ID_GROUP=$groupid AND ID_COURSE=$courseid ") or die("Ошибка22 " . mysqli_error($link));
                $students = mysqli_fetch_array($student);
                echo $students[0] . " " . $val . " ";
                mysqli_query($link, "INSERT INTO `attendance` (`ID_ATT`, `ID_SUBJECT`, `ID_STUDENT`, `ID_DATE`, `MARK`) VALUES (NULL, '$subjectid', '$students[0]', '$dates[0]', '$val')") or die("Ошибка33 " . mysqli_error($link));
            }

        }

    }
}

?>
