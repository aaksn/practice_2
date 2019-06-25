<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

class Authoris_sess {
    private $_lg = "admin";
    private $_pass = "admin";

    public function maybe() {
        if (isset($_SESSION["authoris"])) {
            return $_SESSION["authoris"];
        }
        else return false;
        }

    public function auth($lg, $pass) {
        if ($lg == $this->_lg && $pass == $this->_pass) {
            $_SESSION["authoris"] = true;
            $_SESSION["login"] = $lg;
            return true;
        }
        else {
            $_SESSION["authoris"] = false;
            return false;
        }
    }


    public function get_login() {
        if ($this->maybe()) {
            return $_SESSION["login"];
        }
    }


    public function exit() {
        $_SESSION = array();
        session_destroy();
    }
}

$auth = new Authoris_sess();

if (isset($_POST["login"]) && isset($_POST["password"])) {
    if (!$auth->auth($_POST["login"], $_POST["password"])) {
        echo "<p style=\"color:red;\">Неправильный пароль или логин!</p>";
    }
}

if (isset($_GET["exit"])) {
    if ($_GET["exit"] == 1) {
        $auth->exit();
        header("Location: ?exit=0");
    }
}
?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Войти</title>
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
							<h2>Войти</h2>							
							<form method="POST" action="">
								<div class="fields" align="left">
									<div class="field">
										<label for="name">Логин</label>
										<input type="text" name="login" id="login" value="">
									</div>
									<div class="field">
										<label for="email">Пароль</label>
										<input type="password" name="password" id="password" value="">
									</div>									
									<div class="field">
										<input type="checkbox" id="copy" name="copy">
										<label for="copy">Запомнить меня</label>
									</div>
								</div>
								
								<div class="field third">
									<a href="./base.html" class="icon style2 fa-arrow-left"><span class="label" >Назад</span></a>
									<input class="primary button fit" type="submit" name="submit" id="submit" value="Войти">
									<a href="./base.html" class="icon style2 fa-times"><span class="label" >Очистить поле</span></a>
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