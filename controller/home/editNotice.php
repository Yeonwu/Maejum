<?php
require '../../view/config.php';

$response = array(
	"status" => "",
	"message" => ""
);

try {
	$mysqli = new mysqli("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']); // connect DB
	mysqli_set_charset($mysqli, 'utf8');

	// Check connection
	if ($mysqli -> connect_errno) {
	  throw new Exception("Failed to connect to MySQL: " . $mysqli -> connect_error);
	}

	$reqParam = json_decode(file_get_contents('php://input'), true);
	$notice = addslashes($reqParam['notice']);

	$result = $mysqli -> query("UPDATE `common` SET value = '{$notice}' WHERE id = 'notice_content';");
	
	if($result) {
		$response['status'] = 'success';
	} else {
		$response['status'] = 'success';
	}
	
} catch (Exception $e) {
	$response['status'] = 'fail';
	$response['message'] = $e -> getMessage();
}

header('Content-type: application/json');
echo json_encode( $response );

?>