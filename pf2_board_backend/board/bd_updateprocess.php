<!-- 
  파일명 : bd_updateprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-05
  업데이트일자 : 2022-01-05
  
  기능: 
  bd_update.php 사용자정보 수정 화면에서 입력된 값을 받아 
  board 테이블에 사용자 수정된 데이터를 업데이트 한다. 
-->

<?php
//db연결 준비
require "../util/dbconfig.php";

//로그인한 상태일 때만 수정 가능 
require_once "../util/loginchk.php";

//2022-01-12 upload 처리 위해 추가
$upload_path = './uploadfiles/';

if($chk_login) {
// 데이터베이스 작업 전, 메모장 수정 화면으로 부터 값을 전달 받고
$id = $_POST['id'];
$title = $_POST['title'];
$contents = $_POST['description'];
$writtendate = $_POST['writtendate'];
//$lastdate = date("Y-m-d h:i:s"); app_initiate에서 table만들때 이미 on update으로 값을 줬으니까

//2022-01-12 file upload를 위한 추가 코드------------------
//bd_createprocess 와 비슷한 로직, 다만
//update에서는 기존 파일이 있을때 업로드 폴더에 있는 파일을 삭제 처리기능 추가


if(isset($_FILES['upload']['tmp_name']) && ( $_FILES['upload']['tmp_name'] != "")) {
  
  //일단 파일 네임 정의해주고
  //$filename = $_FILES['uploadfiles']['name'];
  //파일 중복 방지하기위한 타임함수
  $filename = time()."_".$_FILES['upload']['name'];


//file이 정상적으로 업로드 되었을 때 테이블에 추가 
if (move_uploaded_file($_FILES['upload']['tmp_name'], $upload_path.$filename)) {
  //기존 파일이 있는 경우 삭제처리 먼저
  $sql="SELECT * FROM board WHERE id = ".$id;
  $resultset = $conn -> query ($sql);
  $row = $resultset->fetch_assoc();
  $existingfile = $row['uploadfiles'];
  if(isset($existingfile) && $existingfile !="") {
    unlink($upload_path.$existingfile); //이미 있는 파일 삭제기능
  }
}

// 업데이트 처리를 위한 prepared sql 구성 및 bind
$stmt = $conn->prepare("UPDATE board SET title= ?, contents= ?, uploadfiles= ? WHERE id=?");
$stmt->bind_param("sssi", $title, $contents, $filename, $id);

} else { //업로드된 파일이 없을때

// 업데이트 처리를 위한 prepared sql 구성 및 bind
$stmt = $conn->prepare("UPDATE board SET title= ?, contents= ? WHERE id=?");
$stmt->bind_param("ssi", $title, $contents, $id);
}

$stmt->execute();

//실행 하고나서 바로resource 반납처리 - 서버상에서의 stmt의 메모리공간을 비워줌으로서 부담을 덜기
$stmt-> close();

 // 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

 // 프로세스 플로우를 인덱스 페이지로 돌려준다.
header('Location:./bd_detailview.php?id='.$id);

} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>Confirm and Return to index.</a>";
}

