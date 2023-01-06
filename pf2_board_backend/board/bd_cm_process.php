<!-- 
  파일명 : bd_commentprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-12
  업데이트일자 : 2022-01-12
  
  기능: 
  bd_detailview.php 화면에서 댓글로 입력된 값을 받아 
  comment 테이블에 데이터를 추가 한다. 
-->

<?php
//db연결 준비s
require "../util/dbconfig.php";

//로그인한 상태일 때만 수정 가능 
require_once "../util/loginchk.php";

if($chk_login) {
  // 데이터베이스 작업 전, 메모장 수정 화면으로 부터 값을 전달 받고
  $board_id = $_POST['board_id']; //게시판글의 아이디
  $c_username = $_SESSION['username'];
  $contents = $_POST['description'];

  $stmt = $conn->prepare(("INSERT INTO comment(board_id, c_username, contents) VALUES(?, ?, ?)"));
  $stmt -> bind_param("sss", $board_id, $c_username, $contents);
  $stmt->execute();
  
  // board테이블 comments(댓글 숫자) 올리기
  $sql = "UPDATE board SET cmtcnt = cmtcnt + 1 WHERE id = ".$board_id ;
  $conn -> query($sql);

  header('Location: ./bd_detailview.php?id='.$board_id);

}  else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>Confirm and Return to index.</a>";
}

?>