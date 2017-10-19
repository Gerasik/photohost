<?

	define ('HOST', 'localhost');
	define ('USER', 'root');
	define ('PASS', '');
	define ('DB', 'photohost');	

@mysql_connect(HOST, USER, PASS)
	or die ("Ошибка подключения к базе данных");
@mysql_select_db(DB);

?>