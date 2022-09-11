<?php
	require "./config.php";
	$mysqli = mysqli_connect("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']);
			  mysqli_set_charset($mysqli, 'utf8');
	$sql = "UPDATE suggest
			SET 
			answer = '{$_POST['answer_content']}', 
			answer_writer = '{$_POST['user_name']}' 
			WHERE id = {$_POST['article_id']}";
	mysqli_query($mysqli, $sql);
	echo "<script>
				alert('성공');
				window.location.href = '../index.php?id=suggest_read&article_type=suggest&article_id={$_POST['article_id']}';
			 </script>";
?>