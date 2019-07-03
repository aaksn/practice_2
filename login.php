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
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        // Записываем в БД новый хеш авторизации
        mysqli_query($link, "UPDATE users SET user_hash=$hash WHERE user_id=$data['user_id']");

        // Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30);
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