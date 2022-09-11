<!-- 홈 화면 

매점 협동 조합 판매자 사이트 디자인 1, 3페이지 참고

-->

<?php

require_once "./view/user_auth.php";

$auth = getAuth();

$mysqli = new mysqli("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']); // connect DB
mysqli_set_charset($mysqli, 'utf8');

// Check connection
if ($mysqli -> connect_errno) {
  throw new Exception("Failed to connect to MySQL: " . $mysqli -> connect_error);
}

$notice = $mysqli -> query("SELECT * FROM `common` WHERE `id`='notice_content';") -> fetch_assoc()['value'];
$new_menu = $mysqli -> query("SELECT * FROM `common` WHERE `id`='new_menu_img';") -> fetch_assoc()['value'];

?>

<div id="home-container" class="c-theme-light w3-padding-64 no-shadow">
	<?php
	if ( $auth === "판매자" || $auth === "팀장" || $auth === "관리자") {
		require "./view/seller_home.php";
	}
	?>
	<div class="center margin-b-48">
		<span
			class="w3-round-large w3-xxlarge c-theme-dark w3-center w3-padding-large font-gachi"
			style="min-width: 600px; border-radius: 23px;"
		>
			별쿱의 방향성은 이렇습니다
		</span>
	</div>
	
	<div class="w3-bar">
		<div class="w3-bar center w3-xxlarge margin-b-12 font-gachi">
			하나, 건강한 경제 문화 구축
		</div>
		<div class="w3-bar center w3-xxlarge margin-b-12 font-gachi">
			하나, 학생들의 배고픔 해소
		</div>
		<div class="w3-bar center w3-xxlarge margin-b-12 font-gachi">
			하나, 자발적 문제 해결 도모
		</div>
	</div>
	
	<div class="w3-bar center">
		<img src="./assets/img/home/hax.jpg" style="margin: 0 200px; max-width: 500px;">
	</div>
	
	<div class="w3-center w3-xxlarge margin-b-48" style="font-family: 'InkLipquid';">
		별쿱 신메뉴
		<?php if ( $auth === '팀장' || $auth === '관리자' ) {?>
		<form id="new-menu-form" method='post' action='./controller/home/editNewMenu.php' enctype='multipart/form-data'>
			<label class='ht-theme hover-pointer w3-medium'>
				<input 
					   type='file' 
					   name='img' 
					   class='w3-hide' 
					   accept='image/*' 
					   onchange='document.querySelector(`#new-menu-form`).submit();' 
					   value='null'
					   >
				신메뉴 사진 업로드 <i class='las la-upload'></i>
			</label>
		</form>
		<?php }?>
	</div>
	
	<div class="center margin-b-48">
		<div id="new-menu" class="relative">
			<div style="margin: 12px; border: 5px solid rgba(0, 0, 0, 0); border-radius: 15px 0 15px 0; overflow: hidden;">
				<img src="./assets/img/<?php echo $new_menu; ?>" alt="준비중입니다"/>
			</div>
		</div>
	</div>
	
	<div>
		<div>
			<span class="w3-xxlarge c-theme-dark t-black font-gachi w3-padding margin-l-48" style="display: inline-block; height: 100%; border-radius: 15px 15px 0 0;">
				공지사항
				<?php if($auth == "팀장" || $auth == "관리자") { ?>
					<span id="edit-notice" class="w3-large ht-underline hover-pointer font-gachi">수정</span>
				<?php }?>
			</span>
		</div>
		<div 
			 id="notice" 
			 class="w3-xlarge c-theme-dark t-black w3-padding font-gachi" 
			 style="min-height: 300px; white-space: pre-line" contentEditable='false'
			 >
			<?php echo $notice; ?>
		</div>
	</div>
	<div class="c-theme-dark center">
		<div class="w3-center w3-xlarge t-black w3-padding-24 font-gachi" style="border-top: 5px dashed var(--theme-light); max-width: 700px;">
			조합원이 주인인 별쿱 협동조합을 통해<br>
			건강한 문화와 가치가 만들어지길 바랍니다.
		</div>
	</div>
	<div class="w3-center w3-padding-48" style="background-color: #231816;">
		<a href="https://bmrcoop.run.goorm.io/bmrCoop/index.php?id=home">
			<span class="t-theme-light w3-xxlarge font-gachi padding-rl-12" style="border-right: 5px solid var(--theme-light); border-left: 5px solid var(--theme-light);">별쿱</span><br>
		</a>
		<span class="t-theme-light font-gachi padding-rl-12">Made By Web Project</span>
	</div>
</div>

<?php if($auth == "팀장" || $auth == "관리자") { ?>
<script>
	
	init_home();
	function init_home() {
		get('#edit-notice').addEventListener('click', changeEditMode);
	}
	
	function changeEditMode() {
		var notice = get('#notice');
		var editing = notice.getAttribute('contentEditable') == 'true';
		
		notice.setAttribute('contentEditable', !editing);
		
		if(editing) {
			sendNoticeRequest();
			get('#edit-notice').innerText = '수정';
		} else {
			get('#edit-notice').innerText = '저장';
			notice.focus();
		}
	}
	
	function sendNoticeRequest(handleResponse) {
		const DONE = 4;
		const OK = 200;
		
		var xhr = new XMLHttpRequest();
		var url = './controller/home/editNotice.php';
		var content = {
			notice: get(`#notice`).innerHTML
		};
		
		xhr.open('POST', url);
		xhr.onreadystatechange = function() {
			if(xhr.status == OK && xhr.readyState == DONE) {
				console.log('responseText: ' + xhr.responseText);
				handleNoticeResponse(xhr.responseText);
			} else {
				console.error('responseText: ' + xhr.responseText);
			}
		}
		xhr.setRequestHeader('Content-Type', 'application/json');
		xhr.send(JSON.stringify(content));
	}
	
	function handleNoticeResponse(res) {
		res = JSON.parse(res);
		if(res.status == 'success') {
			alert('저장했습니다.');
		} else {
			alert('오류가 발생했습니다. 다시 시도해주세요.');
		}
	}
	
	function get (query) {return document.querySelector(query);}
	function getAll (query) {return document.querySelectorAll(query);}
</script>
<?php }?>