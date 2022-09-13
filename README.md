# 매점 협동 조합 회계 웹 어플리케이션

## 폴더 구조 설명

### index.php

사용자가 사이트 접속시 해당 파일을 통해 다른 페이지로 접속합니다. url 파라미터 `id`와 같은 이름의 php 파일을 렌더링합니다.

### assets

css, js 파일이 들어있습니다. 

css파일은 직접 작성한 custom.css와 사이트 디자인에 맞게 수정한 w3.css 파일을 모든 페이지에서 공유하여 사용합니다.

js 파일은 동명의 페이지에서 사용합니다.
ex) info.js의 경우 `https://{Byulcoop URL}?id=info`에서 사용합니다.

### view

php 파일들이 들어있습니다. 두가지 부류의 파일이 있습니다.

첫번째는 페이지 렌더링과 Form 요청을 하나의 파일에서 처리하는 파일로, 초창기에 관심사의 분리 개념을 모르는 상태로 작성되었습니다. ex) `member.php`

두번째는 페이지 랜더링과 Form 요청 처리를 분리한 파일입니다. 주로 페이지 랜더링 파일은 `페이지의 이름.php`를, Form 요청 처리 파일은 `페이지 이름_mysql.php`를 파일명으로 갖습니다.

ex) `refund.php`, `refund_mysql.php`

### controller

Form 요청 처리 파일을 해당 폴더에 모아 사용하려 했으나, 수정할 파일이 너무 많아 실패하였습니다.
현재 홈화면 관련한 파일 몇개만 들어있습니다.

**config_template.php**

프로그램 내에서 사용하는 설정값 템플릿입니다.

해당 파일에 적혀있는 주석에 맞게 설정값을 적어주신 후, 파일명을 config.php로 변경하면 정상 작동합니다.

## 사용 스택

- PHP
- MySQL
- JavaScript
- HTML, CSS
- W3.css

---
Made By Web Project Team, 2020

지도교사 조은길

프로젝트원 권순겸, 오연우, 윤성락
