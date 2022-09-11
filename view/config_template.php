<?php
	
// 개발 서버, 서비스 서버
// DEV       SER 
define ( 'SERVER_TYPE', 'SER' );

//sell_send.php에서 이메일 보내는거
define ( 'EMAIL_USER_NM', '' );
define ( 'EMAIL_PW', '');


if ( SERVER_TYPE === 'DEV' ) {
	// APPLICATION VERSION
	define ( 'VERSION', '');
	
	//SERVER URL
	define ('URL', '');
	
	// DB CONFIG
	define ( 'CONF_DB', array(
		'db_user' => "", // DB 로그인 아이디
		'db_password' => "", // DB 로그인 비밀번호
		'db_name' => "")  // DB 이름
	);

	// DIR CONFIG
	define ( 'CONF_DIR', array(
	'img' => "") // 이미지 저장 파일 경로
	);

	// ERROE PRINTING
	define ( 'CONF_ERR_PRINT', true ); // php 에러 출력 여부
	
	//GOOGLE CLIENT ID
	define ( 'GOOGLE_CLIENT_ID', '' );\
	
	//GOOGLE CLIENT SECRET
	define ( 'GOOGLE_CLIENT_SECRET', '' );
	
} else if ( SERVER_TYPE === 'SER' ) {
	
	// APPLICATION VERSION
	define ( 'VERSION', '');
	
	//SERVER URL
	define ('URL', '');
	
	// DB CONFIG
	define ( 'CONF_DB', array(
		'db_user' => "", // DB 로그인 아이디
		'db_password' => "", // DB 로그인 비밀번호
		'db_name' => "")  // DB 이름
	);

	// DIR CONFIG
	define ( 'CONF_DIR', array(
	'img' => "") // 이미지 저장 파일 경로
	);

	// ERROE PRINTING
	define ( 'CONF_ERR_PRINT', true ); // php 에러 출력 여부
	
	//GOOGLE CLIENT ID
	define ( 'GOOGLE_CLIENT_ID', '' );
	
	//GOOGLE CLIENT SECRET
	define ( 'GOOGLE_CLIENT_SECRET', '' );
	
} else {
	
	// ERROE PRINTING
	define ( 'CONF_ERR_PRINT', false ); // php 에러 출력 여부
	
}

if ( CONF_ERR_PRINT ){
	error_reporting(E_ALL);
	ini_set("display_errors", 'on');
}

?>
