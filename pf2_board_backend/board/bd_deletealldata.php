<!-- 
  파일명 : bd_deletealldata.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-10
  업데이트일자 : 2022-01-10
  
  기능: 
  모든 데이터/레코드 지우기
  The TRUNCATE TABLE statement is used to delete the data inside a table, but not the table itself.
-->

<?php
require "../util/dbconfig.php";

$sql = "TRUNCATE TABLE board";

if($conn -> query($sql)) {
  echo outmsg(DELETE_SUCCESS);
} else {
  echo outmsg(DELETE_FAIL);
}

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

  // 프로세스 플로우를 사용자 목록 페이지로 돌려준다.
  header('Location: ./bd_list.php');
  
?>