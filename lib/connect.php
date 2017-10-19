<?

	define ('HOST', 'us-cdbr-iron-east-05.cleardb.net');
	define ('USER', 'b6c4c7362a4a33');
	define ('PASS', '621c84c9');
	define ('DB', 'heroku_a666ff323487205');	

@mysql_connect(HOST, USER, PASS)
	or die ("Ошибка подключения к базе данных");
@mysql_select_db(DB);

?>
