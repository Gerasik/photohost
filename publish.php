<?php
include ('lib/connect.php');
// Все загруженные файлы помещаются в эту папку
$uploaddir = 'img/gallery/';

// Вытаскиваем необходимые данные
$file = $_POST['value'];
$name = $_POST['name'];
$image = $_POST['image'];
$description = $_POST['description'];
$tags = $_POST['tags'];

// Получаем расширение файла
$getMime = explode('.', $name);
$mime = end($getMime);

// Выделим данные
$data = explode(',', $file);

// Декодируем данные, закодированные алгоритмом MIME base64
$encodedData = str_replace(' ','+',$data[1]);
$decodedData = base64_decode($encodedData);

// Вы можете использовать данное имя файла, или создать произвольное имя.
// Мы будем создавать произвольное имя!
$randomName = substr_replace(sha1(microtime(true)), '', 12).'.'.$mime;




echo $randomName;
// work 
mysql_query("INSERT INTO images ( name , description, full_name ) VALUES ('".$image."', '".$description."','".$randomName."')");
$imageId = mysql_insert_id();
//проверка тегов
if(!$tags){
	$tags = 'other';
};
$tagList = explode(' ', $tags);
foreach ($tagList as $value) {
	$value = trim($value);
	if($value){
		$rez = mysql_query("SELECT * FROM tags WHERE tag_name='".$value."'");
	
		if (mysql_num_rows($rez) == 1){
			$row = mysql_fetch_assoc($rez); 
			$tagId = $row['id_tag'];
		}
		else{
			mysql_query("INSERT INTO tags (tag_name) VALUES ('".$value."')");
			$tagId = mysql_insert_id();
		}
		mysql_query("INSERT INTO tag_image ( id_tag, id_image ) VALUES ('".$tagId."','".$imageId."')");
	}
}





// Создаем изображение на сервере
if(file_put_contents($uploaddir.$randomName, $decodedData)) {
   echo $randomName.":загружен успешно";
}
else {
   // Показать сообщение об ошибке, если что-то пойдет не так.
   echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
}
?>