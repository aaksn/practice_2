<?php 
// Страница регистрации нового пользователя
include 'dbconn.php';
$link=OpenCon();

if(isset($_POST['submit']) & ($_POST['checkcode']=='VSU19'))
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
        print '<script>window.location.replace("login.html");</script>';
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

    

<html>
	<head>
		<title>Регистрация</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>		
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper" class="divided">

				<section class="banner onload-image-fade-in onload-content-fade-right style2 fullscreen orient-center content-align-center image-position-center -">
						<div class="content">
							<h2>Регистрация</h2>
							<div id="checkhelp">
									Для смены пароля вам необходимо получить проверочный код у администратора и ввести его ниже
							</div>							
							<form method="POST">
								<div class="fields" align="left">
									<div class="field">
										<label for="login">Логин</label>
										<input type="text" required name="login" id="login">
									</div>									
									<div class="field">
										<label for="login">Проверочный код</label>
										<input type="text" required name="checkfield" id="checkcode">
									</div>
                                    <div class="field">
										<label for="password">Пароль</label>
										<input type="password" required name="password" id="password" value="">
                                    </div>                                    
								</div>								
								<div class="field third">									
									<input class="primary button fit" type="submit" name="submit" id="submit" value="Отправить">									
								</div>
                            </form>	
                        </div>

						<div class="image">
							<img src="./images/banner.jpg" alt="">
						</div>
				</section>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>
			<script src="assets/js/base.js"></script>
			
	</body>
</html>