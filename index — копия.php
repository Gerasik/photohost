<?php
	include ('lib/connect.php');
	include ('lib/function_global.php');

	if (isset($_GET['search'])){

		if (!$_GET['keyword']){
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
			include ('template/index.php');
		} 
		else {
			$result = mysql_query("SELECT i.* FROM tag_image t, tags s, images i WHERE s.tag_name LIKE '".$_GET['keyword']."%' AND t.id_tag = s.id_tag and t.id_image = i.id_image LIMIT 15");
			$title = 'search - '.$_GET['keyword'].' / ';
			include ('template/index.php');
		}

	} 
	elseif ($_GET['action'] == "out") {
		out();
	} 
	elseif (login()){
		$UID = $_SESSION['id'];
		$result = mysql_query("SELECT * FROM images WHERE full_name != '' ORDER BY id_image DESC LIMIT 15");
		include ('template/index.php');
	} 
	else {

		if(isset($_POST['log_in'])){
			$error = enter();

			if (count($error) == 0){
				$UID = $_SESSION['id'];
			}
			
		}
		include ('template/login.php');

	}
	