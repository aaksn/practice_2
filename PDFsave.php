<?php
include 'dbconn.php';
$link=OpenCon();

if (!empty($_GET["courseid"]) && !empty($_GET["subjectid"]) && !empty($_GET["groupid"])) {
    if ($_GET["groupid"] == 'undefined' | $_GET["subjectid"] == 'undefined') {
        header("Location: base.html"); exit();
    }
    header('Content-Type: application/pdf');
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
    $resdate = mysqli_query($link, "SELECT DISTINCT dates.ID_DATE,dates.DATE FROM students,attendance,dates WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_DATE=dates.ID_DATE AND students.ID_COURSE=$courseid AND students.ID_GROUP=$groupid AND attendance.ID_SUBJECT=$subjectid");
    while ($row = mysqli_fetch_row($resdate)) {
        $dates[] = $row[1];
    }
    /*$res = mysqli_query($link, "SELECT students.ID_STUDENT,students.FIO,attendance.ID_ATT, attendance.ID_DATE, dates.DATE, attendance.MARK FROM students,attendance,dates WHERE students.ID_STUDENT=attendance.ID_STUDENT AND attendance.ID_DATE=dates.ID_DATE AND students.ID_COURSE=$courseid AND students.ID_GROUP=$groupid AND attendance.ID_SUBJECT=$subjectid") or die("Ошибка " . mysqli_error($link));
    $students = [];
    $dates = [];
    $indexes = [];
    $s = [];
    while ($row = mysqli_fetch_row($res)){
        $students[$row[0]] = $row[1];
        $dates[] = $row[4];
        $indexes[$row[0]][$row[2]] = $row[5];
    }
    mysqli_close($link);
    foreach ($students as $key => $value) {
        $s[] = array("name" => $value, "marks" => $indexes[$key]);
    }*/

//define('FPDF_FONTPATH','fpdf/font');
    require('fpdf/tfpdf.php');
    $pdf = new tFPDF();
    $pdf->AddFont('DejaVu', '', './DejaVuSans.ttf', true);
    $pdf->AddPage('L');
    $pdf->SetFont('DejaVu', '', 10);
    $pdf->Cell(0, 10, $courseid . ' курс ' . $groupid . ' группа', 0, 0, 'C');
    $pdf->Ln();
    $width = 55;
    $pdf->Cell($width, 10);
    foreach ($dates as $date) {

        $pdf->Cell(16, 10, $date, 1, 0, 'C');
    }
    foreach ($students as $student) {
        $pdf->Ln();
        $pdf->Cell($width, 10, $student["name"], 1, 0, 'C');
        foreach ($student["marks"] as $mark)
            if ($mark == '1') {
                $pdf->Cell(16, 10, '+', 1, 0, 'C');
            } else {
                $pdf->Cell(16, 10, '-', 1, 0, 'C');
            }
    }
    $pdf->Output($courseid . ' курс ' . $groupid . ' группа.pdf', 'D');
}
?>