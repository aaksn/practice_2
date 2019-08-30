<?php
// Страница авторизации
$host = 'localhost';
$database = 'db'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

// Соединямся с БД
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link, "SELECT ID_USER, PASSWORD FROM users WHERE USERNAME='".mysqli_real_escape_string($link, $_POST['login'])."'");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['PASSWORD'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        // Записываем в БД новый хеш авторизации
        $iduser = $data['ID_USER'];
        mysqli_query($link, "UPDATE `users` SET `HASH` = '$hash' WHERE `users`.`ID_USER` = $iduser");
        print $iduser;
        // Ставим куки
        $time = time()+60*60*24*30; // 30 дней
        if (isset($_POST['not_attach_ip'])) {
            // Если не нужно сохранять сессию
            $time = 0;
        }
        
        setcookie("id", $data['ID_USER'], $time);
        setcookie("hash", $hash, $time,null,null,null,true); // httponly !!!

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: base.html"); exit();
    }
    else
    {
        print '<script>alert( "Вы ввели неправильный логин/пароль"); window.location.replace("login.html");</script>';
        //header("Location: login.html"); exit();
    }
}

// 
if(!empty($_GET['logout']))
{
    unset($_COOKIE['id']);
    unset($_COOKIE['hash']);
    setcookie("id", "", 1);
    setcookie("hash", "", 1);
    header("Location: base.html"); exit();
}

//изменение пароля
if(isset($_POST['repass']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    //------------------------------------------------------|
    //ТУТ ХЗ КАК ПОЛУЧИТЬ ЛОГИН, КОТОРЫЙ УЖЕ ВВЕЛИ РАНЬШЕ   |
    //------------------------------------------------------|
    $lp = $_POST['login'];
    $query = mysqli_query($link,"SELECT ID_USER, PASSWORD FROM users WHERE USERNAME=$lp");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['PASSWORD'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));
        $newpasswod = md5(md5(trim($_POST["newpassword"])));

        // Записываем в БД новый хеш авторизации
        $id = $data['ID_USER'];
        mysqli_query($link, "UPDATE users SET HASH=$hash AND PASSWORD=$newpasswod WHERE ID_USER=$id");

        // Ставим куки
        setcookie("id", $data['ID_USER'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true); // httponly !!!

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: check.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}

mysqli_close($link);

?>