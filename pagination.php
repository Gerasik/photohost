<?php 

include ('lib/connect.php');

$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
$postnumbers = is_numeric($_POST['nop']) ? $_POST['nop'] : die();
$search = $_POST['search'];

if (isset($_POST['search'])){
	$result = mysql_query("SELECT i.* FROM tag_image t, tags s, images i WHERE s.tag_name LIKE '".$search."%' AND t.id_tag = s.id_tag and t.id_image = i.id_image LIMIT ".$postnumbers." OFFSET ".$offset);
}
else{
	$result = mysql_query("SELECT * FROM images WHERE full_name != '' ORDER BY id_image DESC LIMIT ".$postnumbers." OFFSET ".$offset);
}

$myrow = mysql_fetch_array($result);

if(mysql_num_rows($result)){
	do{
		echo "<div class='image-box'><img src='img/gallery/".$myrow['full_name']."' alt='".$myrow['name']."'></div>";
	}
	while ($myrow = mysql_fetch_array($result));
	}
	else
	{
		echo 'No more images';
	}

 ?>