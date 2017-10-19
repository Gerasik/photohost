<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<div class="login-box">
		<form id="login-form" action="/" method="post">
			<h1>sing in</h1>
			<input id="login" type="text" name="login" placeholder="Username" required pattern="[A-Za-z]{5,25}"/><br />
			<input id="pass" type="password" name="password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"/><br />
			<input type="submit" name="log_in" value="Login">
		</form>
		<p><?php 
			if(isset($error)){
				foreach($error as $value){ 
   					echo $value, "<br>";
				}
			}
		?></p>
		<p>Don't have an account? <a href="/registration.php">Singup</a></p>
	</div>
</body>
</html>