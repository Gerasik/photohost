<?php

	$title = $title."photohost-gerasik";
	include ('lib/connect.php');

	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>

	<header>
		<div class="logo">
			<a href="/">
				<img src="img/logo.png" alt="Logo">
				<p>Welcome to Image Previewer!</p>
			</a>
		</div>
		<div class="user">
			<p><?php echo 'Hi, '.$_COOKIE['login'] ?></p><a href="/?action=out"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
		</div>
	</header>

	<section class="search">
		<form id="search-form" action="index.php" method="GET">
			<input id="keyword" type="text" name="keyword" placeholder="Search by keyword" autocomplete="off"/>
			<input type="submit" name="search" value="Search">
		</form>
	</section>

	<section class="tags">
		<span>e.g.</span>
		<?php 

			$randomTags = mysql_query("SELECT tag_name FROM tags WHERE 1 ORDER BY RAND() LIMIT 8 ");
			$myTags = mysql_fetch_array($randomTags);
			do{
				echo "<a href='index.php?keyword=".$myTags['tag_name']."&search=Search'>".$myTags['tag_name']."</a>";
			}
			while($myTags = mysql_fetch_array($randomTags));
		 ?>
	</section>

	<section class="image-collection">
		<div class="add-image">
			<i class="fa fa-plus-circle" aria-hidden="true"></i>
			<p>Add New Image</p>
		</div>
<?php 

		if(!$result) {echo "data base error";};
			$myrow = mysql_fetch_array($result);
			do{
				echo "<div class='image-box'><img src='img/gallery/".$myrow['full_name']."' alt='".$myrow['name']."'></div>";
			}
			while ($myrow = mysql_fetch_array($result)); 

?>		
	</section>

	<div class="loading-bar">
		<div class="load">
			<div class="loading loading-1"></div>
			<div class="loading loading-2"></div>
			<div class="loading loading-3"></div>
			<div class="loading loading-4"></div>
			<div class="loading loading-5"></div>
			<div class="loading loading-6"></div>
			<div class="loading loading-7"></div>
			<div class="loading loading-8"></div>
			<div class="loading loading-9"></div>
			<div class="loading loading-10"></div>
			<div class="loading loading-11"></div>
			<div class="loading loading-12"></div>
		</div>
	</div>

	<section class="uploader hide-form">
		<form id="upload-form">
			<div class="upload-left">
				<h1>add image</h1>
				<div id="drop-files">
					<div class="picture">
						<i class="fa fa-picture-o" aria-hidden="true"></i>
					</div>
					<h2>Drag in your media</h2>
					<p>Find media on your hard drive, then drag them in to automatically upload.</p>
				</div>
				<div class="drop-filesbtn">
					<p>Manually select media</p>
					<span id="filebtn">+</span>
					<input type="file" id="uploadbtn" accept="image/*,image/jpeg">
				</div>
			</div>
			<div class="upload-right">
				<h1>add info</h1>
				<div class="media-name">
					<p>Name your media</p>
					<input type="text" id="media-name" name="media-name" required>
				</div>
				<div class="media-tags">
					<p>Add tags</p>
					<div class="tags-area">
						<div class="tag tag-hide">
							<p class="tag-name"></p>
							<a class="delete-tag"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>
						</div>
					</div>
					<div class="input-tag">
						<input type="text" placeholder="Write a tag">
						<a href="#" class="add-tag">Add tag</a>
					</div>
				</div>
				<div class="media-description">
					<p>Add description</p>
					<textarea name="media-description" id="media-description" rows="4"></textarea>
				</div>
				<div class="media-submit">
					<input type="submit" name="publish" value="Publish">
				</div>
			</div>
		</form>
		<div id="loading">
			<div id="loading-bar">
				<div class="loading-color"></div>
			</div>
			<div id="loading-content"></div>
			<div id="uploaded-files"></div>
		</div>
		<i id="form-close" class="fa fa-times-circle" aria-hidden="true"></i>
	</section>

	<script>

		var pageSearch = '<?php echo $_GET['keyword'] ?>';

	</script>

	<script src="js/jquery.1.8.min.js"></script>
	<script src="js/typeahead.js"></script>
	<script src="js/common.js"></script>

</body>
</html>