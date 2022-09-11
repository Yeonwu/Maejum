<h6>
	<button class='w3-border'>
		<a href='./index.php?id=report_write'>글쓰기</a>
	</button>
</h6>
<?php
	$mysqli = mysqli_connect("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']);
			  mysqli_set_charset($mysqli, 'utf8');

$sql = "SELECT 
			id, 
			title, 
			created, 
			type 
		FROM suggest
		ORDER BY created DESC";
$result = mysqli_query($mysqli, $sql);
?>

<?php
		while($row = mysqli_fetch_assoc($result)){
		echo
		"<p id='report_title' class='w3-border-top'>
			<a href='./index.php?id=report_content&content_id=" . $row['id'] . "'>[" . $row['type'] . "]" . $row['title'] . "</a>
		</p>";
		}
?>