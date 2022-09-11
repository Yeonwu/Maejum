<div id=report-content>
<?php
require_once "./view/user_auth.php";

$auth = getAuth();
if($auth === "관리자") {
	echo "<h6 class='display_flex'>
		<button class='w3-border'>
			<a href='./index.php?id=report'>돌아가기</a>
		</button> 
		<form action='./index.php?id=report_delete' method='post'>
			<input type='button' class='w3-border' value='삭제' onclick='check_submit()'>
			<input name='content_id' type='hidden' value='" . $_GET['content_id'] . "'>
		</form>
	</h6>";
} else {
	echo "<h6 class='display_flex'>
		<button class='w3-border'>
			<a href='./index.php?id=report'>돌아가기</a>
		</button> 
		<form action='./index.php?id=report_delete' method='post'>
			<input name='content_id' type='hidden' value='" . $_GET['content_id'] . "'>
		</form>
	</h6>";
}
	$mysqli = mysqli_connect("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']);
			  mysqli_set_charset($mysqli, 'utf8');

	$sql = "SELECT 
			u.name, 
			r.title, 
			r.content,
			r.created, 
			r.type 
		FROM suggest AS r
		JOIN user AS u
		WHERE u.id = r.writer_id
		AND r.id = {$_GET['content_id']}";

	$result = mysqli_query($mysqli, $sql);

	$row = mysqli_fetch_assoc($result); 
	echo "<h5 class='report_content_title'>
	[".$row['type']."]".$row['title']."
</h5>
<div id='report_content_title' class='w3-panel w3-border-bottom'>
<span class='w3-padding'>".$row['name']."</span><span  class='w3-panel w3-border-left'>".$row['created']."</span>
</div>

<pre id='report_content_content'>
".$row['content']."
</pre>"; 
	
?>
</div>
<script>

	function check_submit() {
		if(confirm("정말 삭제하시겠습니까?")) {
			document.querySelector('form').submit();
		}
	}

</script>
