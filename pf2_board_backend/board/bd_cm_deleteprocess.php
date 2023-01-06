<!-- 
  파일명 : bd_cm_deleteprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-13
  업데이트일자 : 2022-01-13
  
  기능: 
  id를 GET 패러미터로 받아 삭제처리한다.
-->

<?php
//db 연결 준비
require "../util/dbconfig.php";
//로그인한 상태일때만 지울수 있다
require_once '../util/loginchk.php';

if($chk_login) {

//bd_detailview.php에서 코멘트글의 id를 get으로 넘긴  
$comment_id = $_GET['comment_id'];
$board_id = $_GET['board_id'];

//삭제처리를 위한 질의 구성
$sql = "DELETE FROM comment WHERE id=".$comment_id;
//실행
if($conn -> query($sql)) {
  echo outmsg(DELETE_SUCCESS);
} else {
  echo outmsg(DELETE_FAIL);
}

// board테이블 comments(댓글 숫자) 삭제처리
$sql = "UPDATE board SET cmtcnt = cmtcnt - 1 WHERE id = ".$board_id ;
$conn -> query($sql);

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 프로세스 플로우를 사용자 목록 페이지로 돌려준다.
header('Location: ./bd_detailview.php?id='.$board_id);

} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>