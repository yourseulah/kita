<!-- 
  파일명 : comment_likeprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-13
  업데이트일자 : 2022-01-13
  
  기능: 
  id를 GET 패러미터로 받아 삭제처리한다.
-->

<?php
require "../util/dbconfig.php";

$board_id = $_GET['board_id'];
$comment_id = $_GET['comment_id'];
$sql = "UPDATE comment SET likecnt = likecnt + 1 WHERE id =".$comment_id ;
$conn -> query($sql);
  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

  // 프로세스 플로우를 사용자 목록 페이지로 돌려준다.
  header('Location: ./bd_detailview.php?id='.$board_id);

  //detailview.php에서 board id로 받는 걸 GET id넘기는걸 잘 생각해서 
  //php?board_id=가 아니라 php?id= 
  


?> 