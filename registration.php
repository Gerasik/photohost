<?php
ini_set ("session.use_trans_sid", true);

session_start();

include ('lib/connect.php');
include ('lib/function_global.php');

if (isset($_SESSION['id']) || (isset($_COOKIE['login']) && isset($_COOKIE['password']))){
	header('Location: http://'.$_SERVER['HTTP_HOST']);
}
else {	
	if (isset($_POST['register'])) {
		$correct = registrationCorrect(); 

		if ($correct) {
			$login = htmlspecialchars($_POST['login']);
			$password = $_POST['password'];
			$mail = htmlspecialchars($_POST['mail']);
			$salt = mt_rand(100, 999);
			$password = md5(md5($password).$salt);

			if (mysql_query("INSERT INTO users (login,password,salt,mail_reg) VALUES ('".$login."','".$password."','".$salt."','".$mail."')")){
				setcookie ("login", $login, time() + 50000, '/');
				setcookie ("password", md5($login.$password), time() + 50000, '/');
				$rez = mysql_query("SELECT * FROM users WHERE login='".$login."'");
				@$row = mysql_fetch_assoc($rez);
				$_SESSION['id'] = $row['id'];
				header('Location: http://'.$_SERVER['HTTP_HOST']);
			}
		}
		else{	
			$error = "this login or e-mail is already taken";
			include_once ("template/registration-form.php");
		}
	}
	else{
		include_once ("template/registration-form.php");
	}
}

