<?php
	$mysqli = mysqli_connect("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']);
			  mysqli_set_charset($mysqli, 'utf8');

$sql = "DELETE FROM suggest WHERE id = " . $_POST['content_id'] . "";
		
	mysqli_query($mysqli, $sql);
		echo "<script>
				alert('글이 삭제되었습니다.');
				window.location.href = './index.php?id=report';
			 </script>";
?>