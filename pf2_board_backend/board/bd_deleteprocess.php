<!-- 
  파일명 : bd_deleteprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-05
  업데이트일자 : 2022-01-05
  
  기능: 
  id를 GET 패러미터로 받아 삭제처리한다.
-->

<?php
//db 연결 준비
require "../util/dbconfig.php";
//로그인한 상태일때만 지울수 있다
require_once '../util/loginchk.php';

if ($chk_login) {
  //로그인을 하였으면 전달되 id 획득 
  $id = $_GET['id'];
  $upload_path = './uploadfiles/';

  //upload된 파일을 가지고 있을때 업로드된 파일 삭제처리를 위한 코드
  //해당 id를 이용해서 첨부파일의 값이 있는지 확인
  //조회용 sql구문이 나오고
  //sql 구문을 통해 첨부된 파일이름 꺼내기
  //있으면 unlink를 통해 삭제처리진행
  //없으도 그냥unlink하고 다음 진행 
  $sql = "SELECT * FROM board WHERE id = " . $id;
  $resultset = $conn->query($sql);
  $row = $resultset->fetch_assoc();
  $existingfile = $row['uploadfiles'];
  if (isset($existingfile) && $existingfile != "") {
    unlink($upload_path . $existingfile);
  }
  //여기까지 upload된 폴더에서의 삭제처리한 코드 ---------------------

  //삭제처리를 위한 질의 구성
  $sql = "DELETE FROM board WHERE id=" . $id;
  //실행
  if ($conn->query($sql)) {
    echo outmsg(DELETE_SUCCESS);
  } else {
    echo outmsg(DELETE_FAIL);
  }

  $resultset->close();

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

  // 프로세스 플로우를 사용자 목록 페이지로 돌려준다.
  header('Location: ./bd_list.php');
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>