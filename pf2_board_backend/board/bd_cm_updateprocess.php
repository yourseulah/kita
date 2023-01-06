<!-- 
  파일명 : bd_cm_updateprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-12
  업데이트일자 : 2022-01-12
  
  기능: 
  bd_update.php 사용자정보 수정 화면에서 입력된 값을 받아 
  board 테이블에 사용자 수정된 데이터를 업데이트 한다. 
-->

<?php
//db연결 준비s
require "../util/dbconfig.php";

//로그인한 상태일 때만 수정 가능 
require_once "../util/loginchk.php";

if($chk_login) {
  $board_id = $_POST['board_id']; //게시판글의 아이디
  $comment_id = $_POST['comment_id'];
  $contents = $_POST['description'];

  $stmt = $conn->prepare("UPDATE comment SET contents= ? WHERE id=?");
  $stmt -> bind_param("ss", $contents, $comment_id);
  $stmt->execute();
  
  header('Location: ./bd_detailview.php?id='.$board_id);

}  else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>Confirm and Return to index.</a>";
}

?>