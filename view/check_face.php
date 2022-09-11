<?php

require_once ("./view/user_auth.php");

$auth = getAuth();
if ( $auth === '소비자' || $auth === '조합원' ) {
	echo "
	<script>
		alert('권한이 없습니다');
		window.location.href = './index.php?id=home';
	</script>
	";
}

?>
<div id="check_face-container">
	<?php
		echo	"
			<img src=./assets/img/".$_POST['image']." height=400px width=300px>
				<div id='Grade_Name'>
				<p id='Grade_Name_txt'>".$_POST['grade']." / ".$_POST['name']." / ".$_POST['auth'].
			   "</p></div>
			   	<div id='YN'>
					<form action='./index.php?id=sell' method='post'>
						<input autofocus class='w3-button w3-border' id='CFP' type='submit' value='확인' style='width:100%;'>
						<input name='name' type='hidden' value='".$_POST['name']."'>
						<input name='grade' type='hidden' value='".$_POST['grade']."'>
						<input name='auth' type='hidden' value='".$_POST['auth']."'>
						<input name='email' type='hidden' value=".$_POST['email'].">
					</form>";
	?>
	<button class="w3-button w3-border" onclick="location.href='./index.php?id=choose_name'">
	취소
	</button>
</div>