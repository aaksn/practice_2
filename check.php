<?
// Скрипт проверки
$host = 'localhost';
$database = 'db'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

// Соединямся с БД
$link = mysqli_connect($host, $user, $password, $database);

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT * FROM users WHERE ID_USER = ".intval($_COOKIE['id']));
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['HASH'] !== $_COOKIE['hash']) or ($userdata['ID_USER'] !== $_COOKIE['id']))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "Хм, что-то не получилось";
    }
    else
    {
        print "Привет, ".$userdata['user_login'].". Всё работает!";
    }
}
else
{
    print "Включите куки";
}
?>