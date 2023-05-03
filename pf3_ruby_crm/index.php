<!-- 
  파일명 : index.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-26
  업데이트일자 : 2022-01-26
  
  기능: 
  Ruby_CRM 프로젝트 폴더의 최상위 index 파일로써,
  로그인페이지이다. 하위 app 폴더를 연결하는 역할을 한다.

  각 폴더별 기능 요약정리하기!!!
-->

<?php
require_once './util/utility.php';
require_once './util/loginchk.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./css/login_style.css">
</head>

<body>
  <div class="main">
    <div class="wrapper">
      <div class="logo"><img src="./img/sales.png" width="120" height="120" style="display: block;
        margin: 50px auto"></div>
      <div class="content">
        <form action="./employees/login_process.php" method="POST">
          <label>Username</label>
          <div class="usernameEmail">
            <input type="text" placeholder="Username" name="username" required>
            <span class="email">@ruby.com</span>
          </div>
          <label>Password</label>
          <input type="password" placeholder="Enter Password" name="passwd" required>

          <button type="submit">Login</button>
          <label><input type="checkbox" checked="checked" name="remember">&nbsp;&nbsp;&nbsp;Remember me</label>
          <span><a href="./employees/regist.php" class="signup">Sign Up</a></span>
        </form>
      </div>
    </div>
  </div>

  <div class="footer">
    © 2022 PF3_Ruby_CRM All rights reserved.
  </div>
</body>

</html>