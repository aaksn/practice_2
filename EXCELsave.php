<?php
include 'dbconn.php';
$link = OpenCon();


if (!empty($_GET["courseid"]) && !empty($_GET["subjectid"]) && !empty($_GET["groupid"])) {
    if ($_GET["groupid"] == 'undefined' | $_GET["subjectid"] == 'undefined') {
        header("Location: base.html");
        exit();
    }
    $courseid = $_GET["courseid"];
    $groupid = $_GET["groupid"];
    $subjectid = $_GET["subjectid"];
    $students = [];
    $dates = [];
    $res = mysqli_query($link, "SELECT ID_STUDENT,FIO FROM students WHERE students.ID_COURSE=$courseid AND students.ID_GROUP=$groupid");
    while ($row = mysqli_fetch_row($res)) {
        $mark = [];
        $marks = mysqli_query($link, "SELECT attendance.ID_ATT, attendance.MARK FROM attendance,students WHERE attendance.ID_STUDENT=$row[0] AND students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_SUBJECT=$subjectid AND students.ID_GROUP=$groupid AND students.ID_COURSE=$courseid");
        while ($row2 = mysqli_fetch_row($marks)) {
            $mark[$row2[0]] = $row2[1];
        }
        $students[] = array("name" => $row[1], "marks" => $mark);
    }
    $resdate = mysqli_query($link, "SELECT DISTINCT dates.DATE FROM students,attendance,dates WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_DATE=dates.ID_DATE AND students.ID_COURSE=$courseid AND students.ID_GROUP=$groupid AND attendance.ID_SUBJECT=$subjectid");
    while ($row = mysqli_fetch_row($resdate)) {
        $dates[] = $row[0];
    }

    require_once 'phpexcel/PHPExcel.php';
    $object = new PHPExcel();
    $object->setActiveSheetIndex(0);
    $table_columns = $dates;
    $column = 1;
    $object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
    $object->getDefaultStyle()->applyFromArray($style);
    $object->getActiveSheet()->mergeCells('A1:K1');
    $object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $courseid . ' курс ' . $groupid . ' группа');
    foreach ($table_columns as $field) {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
        $column++;
    }
    $excel_row = 3;
    //for ($i=0;$i<mysqli_num_rows($res);$i+=1)
    $excel_column = 0;
    foreach ($students as $student) {
        $object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, $student["name"]);
        $num = 0;
        foreach ($student["marks"] as $mark) {
            $excel_column += 1;
            $num += 1;
            if ($mark == '1') {
                $object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, "+");
            } else {
                $object->getActiveSheet()->setCellValueByColumnAndRow($excel_column, $excel_row, "-");
            }
        }

        $excel_column -= $num;
        $excel_row += 1;
    }
    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename=' . $courseid . ' курс ' . $groupid . ' группа' . '.xls');
    $object_writer->save('php://output');
}

?>