<?
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
$link = mysqli_connect($host, $user, $password, $database);

if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT ID_USER, PASSWORD FROM users WHERE USERNAME=$_POST['login']");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['PASSWORD'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        // Записываем в БД новый хеш авторизации
        mysqli_query($link, "UPDATE users SET HASH=$hash WHERE ID_USER=$data['ID_USER']");

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

//изменение пароля
if(isset($_POST['repass']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    //------------------------------------------------------|
    //ТУТ ХЗ КАК ПОЛУЧИТЬ ЛОГИН, КОТОРЫЙ УЖЕ ВВЕЛИ РАНЬШЕ   |
    //------------------------------------------------------|
    $query = mysqli_query($link,"SELECT ID_USER, PASSWORD FROM users WHERE USERNAME=$_POST['login']");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['PASSWORD'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));
        $newpasswod=md5(md5(trim($_POST["newpassword"])));

        // Записываем в БД новый хеш авторизации
        mysqli_query($link, "UPDATE users SET HASH=$hash AND PASSWORD=$newpasswod WHERE ID_USER=$data['ID_USER']");

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

?>
<form method="POST">
    Логин <input name="login" type="text" required><br>
    Пароль <input name="password" type="password" required><br>
    Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br>
    <input name="submit" type="submit" value="Войти">
</form>