<!-- 
  파일명 : user_detailview.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-03
  업데이트일자 : 2022-01-03
  
  기능: 
  id를 GET방식으로 넘겨받아, 해당 id 레코드 정보를 검색,
  화면에 상세 정보를 뿌려준다.
-->
<?php
// db연결 준비
require "../util/dbconfig.php";

// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';
if($chk_login){
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>회원정보 상세페이지</h1>
  <br>
  <?php

  $id = $_GET['id'];

  $sql = "SELECT * FROM users WHERE id = " . $id;
  $resultset = $conn->query($sql);

  if ($resultset->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>USERNAME</th><th>CellPhone</th><th>E-Mail</th><th>Regist Date</th><th>Last Login</th><th>Status</th><th>수정</th><th>삭제</th></tr>";

    $row = $resultset->fetch_assoc();
    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td>" . $row['cellphone'] . "</td><td>" . $row['email'] . "</td><td>" . $row['registdate'] . "</td><td>" . $row['lastdate'] . "</td><td>" . $row['status'] . "</td><td><a href='user_update.php?id=" . $row['id'] . "'>수정</a></td><td><a href='user_deleteprocess.php?id=" . $row['id'] . "'>삭제</a></td></tr>";
    echo "</table>";
  }
  ?>
  <br>
  <a href="user_userlist.php">목록보기</a>
</body>

<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>