<?php
require_once "./view/user_auth.php";

$auth = getAuth();
?>

<form action="./index.php?id=report_mysql" method="post">
	<h6>
		<input class="w3-border" type="button" value="글 등록" onclick="return submit();" />
		<button class="w3-border">
			<a href="./index.php?id=report">취소</a>
		</button>
	</h6>
	<div>
		<input
			name="title"
			id="report_write_title"
			type="text"
			autocomplete="off"
			placeholder="제목"
		/>
		<select name="type">
			<option value="제안사항">제안사항</option>
			<option value="버그제보">버그제보</option>
			<?php if($auth === "관리자") echo '<option value="공지">공지(개발자용)</option>'; ?>
		</select>
	</div>
	<textarea
		id="report_write_content"
		name="content"
		autocomplete="off"
		placeholder="내용"
	></textarea>
</form>

<script>
	
	function submit() {
		document.querySelector('form').submit();
		alert('글이 등록되었습니다.');
		return false;
	}
	
	document.querySelector('input[type="text"]').addEventListener('keydown', function(event) {
	  if (event.keyCode === 13) {
		event.preventDefault();
	  };
	}, true);
	
</script>