    <?php 
    // Страница регистрации нового пользователя
    include 'dbconn.php';
    $link=OpenCon();

    if(isset($_POST['submit']))
    {
        $err = [];

        // проверям логин
        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
        {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }

        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
        {
            $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
        }

        // проверяем, не сущестует ли пользователя с таким именем
        $query = mysqli_query($link, "SELECT ID_USER FROM users WHERE USERNAME='".mysqli_real_escape_string($link, $_POST['login'])."'");
        //mysqli_close($link);
        if(mysqli_num_rows($query) > 0)
        {
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }

        // Если нет ошибок, то добавляем в БД нового пользователя
        if(count($err) == 0)
        {

            $login = $_POST['login'];

            // Убераем лишние пробелы и делаем двойное хеширование
            $password = md5(md5(trim($_POST['password'])));
            // md5 - 32 символа
                    
            mysqli_query($link,"INSERT INTO `users` (`ID_USER`, `USERNAME`, `PASSWORD`, `RANK`) VALUES (NULL, '$login', '$password', '666')")
            or die("Ошибка " . mysqli_error($link));
            
            //header("Location: login.php"); exit();
        }
        else
        {
            print "<b>При регистрации произошли следующие ошибки:</b><br>";
            foreach($err AS $error)
            {
                print $error."<br>";
            }
        } 
        mysqli_close($link);   
    }
    ?>

    <form method="POST">
        Логин <input name="login" type="text" required><br>
        Пароль <input name="password" type="password" required><br>
        <input name="submit" type="submit" value="Зарегистрироваться">
    </form>