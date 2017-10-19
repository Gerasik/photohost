<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Register-Photohost</title>
		<link rel="stylesheet" href="css/register.css">
	</head>
	<body>

		<form id="register" action="registration.php" method="post">
			<h1>sing up</h1>
			<input id="login" type="text" name="login" placeholder="Username" required pattern="[A-Za-z]{5,25}" /><br />
			<p id="login-pattern" class="pattern"></p>
			<input id="mail" type="email" name="mail" placeholder="E-mail" required /><br />
			<input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" id="pass" type="password" name="password" placeholder="Password" pattern="[A-Za-z]{1,25}[0-9]" 	required/><br />
			<p id="pass-pattern" class="pattern"></p>
			<input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" id="re_pass" type="password" name="password2" placeholder="Retype password" required/><br />
			<input type="submit" name="register" value="Sing me up">
			<p class="error"><?php if ($error) echo $error ?></p>
		</form>

		<script type="text/javascript">
			window.onload = function () {
				
			    document.getElementById("pass").onchange = validatePassword;
			    document.getElementById("re_pass").onchange = validatePassword;
				document.getElementById("login").onchange = function(){
						if(!document.getElementById("login").validity['valid']){
							document.getElementById("login-pattern").innerText = 'Only a-z or A-Z characters';
						} else{
							document.getElementById("login-pattern").innerText = '';
						}
				};
				document.getElementById("pass").onchange = function(){
						if(!document.getElementById("pass").validity['valid']){
							document.getElementById("pass-pattern").innerText = 'use 6 characters long, at least one lowercase letter, one uppercase letter, one 	digit, no 		special  symbols eg. ~!@#$%^&*()_+; ';
						} else{
							document.getElementById("pass-pattern").innerText = '';
						}
				};

				function validatePassword(){

					var pass2=document.getElementById("pass").value;
					var pass1=document.getElementById("re_pass").value;

					if(pass1!=pass2)
						document.getElementById("re_pass").setCustomValidity("Passwords Don't Match");
					else
						document.getElementById("re_pass").setCustomValidity('');
				}
			}
		</script>

	</body>
</html>