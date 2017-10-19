<?php  

function registrationCorrect() {
	$login = $_POST['login'];
	$email = $_POST['mail'];
	$rez = mysql_query("SELECT * FROM users WHERE login='".$login."'");
	$rez2 = mysql_query("SELECT * FROM users WHERE mail_reg='".$email."'");

	if ($_POST['login'] == "") return false;
	if ($_POST['password'] == "") return false;
	if ($_POST['password2'] == "") return false;
	if ($_POST['mail'] == "") return false;
	if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $_POST['mail'])) return false;
	if (!preg_match('/^([a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is', $_POST['login'])) return false;
	if (strlen($_POST['password']) < 5) return false;
 	if ($_POST['password'] != $_POST['password2']) return false;
	if (@mysql_num_rows($rez) != 0) return false;
	if (@mysql_num_rows($rez2) != 0) return false;
	return true;
}

function out () {
	session_start(); 

	$id = $_SESSION['id'];	 
			 	
	unset($_SESSION['id']);
	setCookie("login", " ");	
	setCookie("password", " ");  	
	unset($_COOKIE["login"]);
	unset($_COOKIE["password"]);
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
}

function enter () { 

	$error = array();	

	if ($_POST['login'] != "" && $_POST['password'] != "") {

		$login = $_POST['login']; 
		$password = $_POST['password'];	
		$rez = mysql_query("SELECT * FROM users WHERE login='".$login."'");	

		if (mysql_num_rows($rez) == 1) { 		
			$row = mysql_fetch_assoc($rez); 

			if (md5(md5($password).$row['salt']) == $row['password']) {
				setcookie ("login", $login, time() + 50000, '/');
				setcookie ("password", md5($login.$password), time() + 50000, '/');					
				$_SESSION['id'] = $row['id'];	
				header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
				return $error;
			} 			
			else {			
				$error[] = "incorrect password"; 										
				return $error; 			
			} 	

		} 		
		else {	
			$error[] = "incorrect login or password"; 			
			return $error; 		
		} 	

	} 	
 	else { 		
		$error[] = "fields must not be empty!"; 				
		return $error; 	
	} 

}

function login () {

	ini_set ("session.use_trans_sid", true); 

	session_start();  	

	if (isset($_SESSION['id'])) {

		if(isset($_COOKIE['login']) && isset($_COOKIE['password'])) {

			SetCookie("login", "", time() - 1, '/'); 			SetCookie("password","", time() - 1, '/'); 			
			Setcookie ("login", $_COOKIE['login'], time() + 50000, '/'); 			
			Setcookie ("password", $_COOKIE['password'], time() + 50000, '/'); 						
			$id = $_SESSION['id'];			
			return true;

		} 		
		else {

 			$rez = mysql_query("SELECT * FROM users WHERE id='{$_SESSION['id']}'");

			if (mysql_num_rows($rez) == 1) {			 		
				$row = mysql_fetch_assoc($rez);			
				Setcookie ("login", $row['login'], time()+50000, '/'); 				
				Setcookie ("password", md5($row['login'].$row['password']), time() + 50000, '/'); 
				$id = $_SESSION['id'];
				return true; 			
			} 
			else {
				return false; 		
			}

		} 

	} 	
	else {

		if(isset($_COOKIE['login']) && isset($_COOKIE['password'])) {

			$rez = mysql_query("SELECT * FROM users WHERE login='{$_COOKIE['login']}'"); 			
			@$row = mysql_fetch_assoc($rez); 			

			if(@mysql_num_rows($rez) == 1 && md5($row['login'].$row['password']) == $_COOKIE['password']) {			
				$_SESSION['id'] = $row['id'];		
				$id = $_SESSION['id']; 			
				return true; 			
 			}
			else { 			
 				SetCookie("login", "", time() - 360000, '/'); 				
 				SetCookie("password", "", time() - 360000, '/');	 			
 				return false; 			
			} 		
		} 		
		else { 		
 			return false; 		
		} 	

	} 
	
}