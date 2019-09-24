<?php
// Скрипт проверки кук
$host = 'localhost';
$database = 'db'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    // Соединямся с БД
    $link = mysqli_connect($host, $user, $password, $database);

    $query = mysqli_query($link, "SELECT ID_USER,RANK, HASH, USERNAME FROM users WHERE ID_USER = " . intval($_COOKIE['id']));
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
        $perm = 1;
        echo json_encode(array("username" => $userdata['USERNAME'], "root" => $root, "edit_group" => intval($permissions[0]), "edit_table" => intval($permissions[1]), "save" => intval($permissions[2]), "view" => intval($permissions[3])));
    }
    mysqli_close($link);
}
?>