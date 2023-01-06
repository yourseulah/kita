<!-- 
  파일명 : index.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-03
  업데이트일자 : 2022-01-03
  
  기능: 
  demisite1 프로젝트 폴더의 최상위 index 파일로써,
  하위 app 폴더를 연결하는 역할을 한다.

  session 관리 목적 추가
-->
<?php
require_once './util/utility.php';
//.. 내 위 
//. 내아래
require_once './util/loginchk.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Membership Management</title>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <!-- Logo, Memga menu's, Introduction Video link, and Login Button -->
  <header>
    <a class="headeritem" href=#><img src="./css/planet.png" width="50px"></a>
    <a class="headeritem" href="./membership/user_userlist.php" style="color: #CFB9F9">UserList</a>   
    <a class="headeritem" href="./board/bd_list.php" style="color: #CFB9F9">Board</a>   
        
    <div class="loginlink">
      <?php
      if (!$chk_login) {  // 로그인 상태가 아니라면
      ?>
        <button id='trglgnModal'>login</button>
        <!-- 여기부터 login modal -->
        <div id='lgnModal' class='modal'>
          <!-- 여기부터 로그인 form in modal -->
          <div class="modal-content">
            <span class="close">&times;</span>
            <form action="./membership/user_loginprocess.php" method="POST" class="loginbox">
              <label for="username"><b>Username</b></label><input type="text" name="username" placeholder="Enter Username" required />
              <label for="passwd"><b>Password </label><input type="password" name="passwd" placeholder="Enter Password" required />
              <button type=submit>Login</button><br>
              <label>
                <input type="checkbox" value="yes" name="chkbox">Remember me
              </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="./membership/user_regist.php">register</a>
            </form>

          </div>
          <!-- 여기까지 로그인 form in modal -->
        </div>
        <!-- 여기까지 login modal -->
      <?php 
      } else {
        echo $_SESSION['username']; ?>
        <button?><a href="./membership/user_logout.php">logout</a></button>
      <?php
      }// end of if(!$chk_login)
    ?>
    </div><!-- end of class="loginlink" -->
  </header>
  
  <main>
  </main>
  <footer>
  </footer>
  <script src='./js/login.js'></script>
</body>

</html>