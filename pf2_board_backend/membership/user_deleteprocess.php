<!-- 
  파일명 : user_deleteprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  id를 GET 패러미터로 받아 삭제처리한다.
-->
<?php
// db연결 준비
require "../util/dbconfig.php";

// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';
if($chk_login){

// 전달된 id 획득
$id = $_GET['id']; 

// 삭제처리를 위한 질의 구성
$sql = "DELETE FROM users WHERE id=" . $id;
// 실행
if ($conn->query($sql) == TRUE) {
  echo outmsg(DELETE_SUCCESS);
} else {
  echo outmsg(DELETE_FAIL);
}

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 프로세스 플로우를 사용자 목록 페이지로 돌려준다.
header('Location: user_userlist.php');

}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
