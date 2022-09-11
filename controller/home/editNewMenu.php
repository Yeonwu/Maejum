<?php
require '../../view/config.php';
if($_FILES['img']['error'] === UPLOAD_ERR_OK) {
		$file = $_FILES['img'];

		$upload_directory = CONF_DIR['img'];
		$ext_str = "hwp,xls,doc,xlsx,docx,pdf,jpg,jpeg,gif,png,txt,ppt,pptx";

		$allowed_extensions = explode(',', $ext_str);
		$max_file_size = 5242880;
		$ext = substr($file['name'], strrpos($file['name'], '.') + 1);

		// 확장자 체크
		if(!in_array( strtolower($ext), $allowed_extensions)) {
			echo "업로드할 수 없는 확장자 입니다.";
			// echo "<script>location.href='./index.php?id=home'</script>";
			exit();
		}

		// 파일 크기 체크
		if($file['size'] >= $max_file_size) {
			echo "5MB 까지만 업로드 가능합니다.";
			// echo "<script>location.href='./index.php?id=home'</script>";
			exit();
		}
		$path = date("YmdHis") . md5(microtime()) . '.' . $ext;

		move_uploaded_file($file['tmp_name'], $upload_directory.$path);

	} else {
		echo 'fail</br>';
		var_dump($_FILES['img']);
	}


	$mysqli = new mysqli("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']); // connect DB
	mysqli_set_charset($mysqli, 'utf8');

	// Check connection
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	}

	unlink(CONF_DIR['img'] . $mysqli -> query("SELECT * FROM `common` WHERE id='new_menu_img'") -> fetch_assoc()['value'] );

	$mysqli -> query("UPDATE `common` SET value = '{$path}', created = NOW() WHERE id='new_menu_img'");
	$mysqli -> close();

	// echo "<script>location.href='./index.php?id=home'</script>";
	exit();
?>