<?php
	$mysqli = mysqli_connect("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']);
			  mysqli_set_charset($mysqli, 'utf8');
	$sql = "INSERT 
			INTO `suggest` (
				title, 
				content, 
				writer_id, 
				type
			) 
			VALUES(
			'{$_POST['title']}', 
			'{$_POST['content']}',
			'{$_COOKIE['login_db_id']}',
			'{$_POST['type']}')";

	mysqli_query($mysqli, $sql);

	if(!isset($_POST['title'])) {
		echo "Not Set";
	}
	
	mysqli_close($mysqli);

	header('Location: ./index.php?id=report');
	
	exit;
?>