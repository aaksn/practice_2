<?php
// Скрипт проверки кук
include 'dbconn.php';
$link=OpenCon();

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    // Соединямся с БД


    $query = mysqli_query($link, "SELECT ID_USER, RANK, HASH, USERNAME FROM users,permissions WHERE users.ID_PERMISSION=permissions.ID_PERMISSION AND ID_USER = " . intval($_COOKIE['id'])) or die("Ошибка " . mysqli_error($link));
    $userdata = mysqli_fetch_assoc($query);
    $permissions = str_split($userdata['RANK']);
    $root = 0;
    if ($userdata['RANK'] == '777') {
        $root = 1;
    }

    if (($userdata['HASH'] !== $_COOKIE['hash']) or ($userdata['ID_USER'] !== $_COOKIE['id'])) {
        setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
        //print "Хм, что-то не получилось";
    } else {
        //print $userdata['USERNAME'];        
        
        echo json_encode(array("username" => $userdata['USERNAME'], "edit_group" => intval($permissions[0]), "edit_table" => intval($permissions[1]), "save" => intval($permissions[2])));
    }
    
    mysqli_close($link);
}
?>