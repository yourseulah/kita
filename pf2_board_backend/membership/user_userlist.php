<!-- 
  파일명 : user_list.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-03
  업데이트일자 : 2022-01-03
  
  기능: 
  로그인 성공했을 때, success 메시지 간단히 출력하고...
  여기에서는 사용자 목록 리스팅 기능을 수행하도록 구성함.
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
  <h6>로그인 성공!!</h6>
  <h1>사용자 목록</h1>
  <br><br>
  <?php
  $sql = "SELECT * FROM users";
  $resultset = $conn->query($sql);

  if ($resultset->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>USERNAME</th><th>작업내용</th></tr>";
    // out data of each row
    while ($row = $resultset->fetch_assoc()) {
      echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td><a href='user_detailview.php?id=" . $row['id'] . "'>상세정보확인</a></td></tr>";
    }
    echo "</table>";
  }
  ?>
  <a href="../index.php">인덱스페이지로</a>
</body>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>