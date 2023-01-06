<!-- 
  파일명 : user_loginform.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-03
  업데이트일자 : 2022-01-03
  
  기능: 
  로그인을 위한 화면 구성
  세션 활용, 로그인 여부 체크

  1. 세션session?
  - 일정 시간 동안 같은 사용자(브라우저)로부터 들어오는 일련의 요구를 하나의 상태로 보고, 
    그 상태를 유지시키는 기술
  - 일정 시간은 방문자가 웹 브라우저를 통해 웹 서버에 접속한 시점으로 부터 웹 브라우저를
    종료하여 연결을 끝내는 시점
  2. 세션의 특징
  - 웹 서버에 웹 컨테이너의 상태를 유지하기 위한 정보를 저장
  - 브라우저를 닫거나, 서버에서 세션을 삭제했을때만 삭제가 되므로, 쿠키보다 비교적 보안 우수
  - 저장 데이터에 제한 없음
  - 각 클라이언트 고유 session ID를 부여
  - session ID로 클라이언트를 구분하여 각 클라이언트요구에 맞는 서비스 제공

  여기서는 필요없음 인덱스에 로그인 폼 만들어놓음
  
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>toy project 1st</title>
</head>

<body>
  <h1>로그인 화면</h1>
  <form action="./user_registprocess.php" method="POST">
    <label>사용자 아이디 : </label><input type="text" name="username" placeholder="사용자 아이디를 입력해주세요." required /><br>
    <label>비밀번호 : </label><input type="password" name="passwd" placeholder="비밀번호를 입력해주세요." required /><br>
    <br>
    <input type=submit value="로그인">
  </form>
</body>

</html>