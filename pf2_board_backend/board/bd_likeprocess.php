<!-- 
  파일명 : bd_likeprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-05
  업데이트일자 : 2022-01-05
  
  기능: 
  id를 GET 패러미터로 받아 삭제처리한다.
-->

<?php
require "../util/dbconfig.php";

$id = $_GET['id'];
$sql = "UPDATE board SET likecnt = likecnt + 1 WHERE id =".$id;
$conn -> query($sql);
  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

  // 프로세스 플로우를 사용자 목록 페이지로 돌려준다.
  header('Location: ./bd_list.php');
  
?>
