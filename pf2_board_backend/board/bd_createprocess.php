<!-- 
  파일명 : bd_createprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-05
  업데이트일자 : 2022-01-05
  
  기능: 
  bd_create.php 화면에서 입력된 값을 받아
  board 테이블에 데이터를 추가한다.
-->

<?php
require "../util/dbconfig.php";
//로그인한 상태일때만 글쓰기 작성 가능
require "../util/loginchk.php";

//로그인한 사용자에 한해서 기능 제공하기 위해 체크인 확인
if($chk_login) {
//데이터베이스 작업전, 글쓰기 화면으로부터 전달받은 값 가져오기 
//username은 로그인한 상태이므로 session으로부터 꺼내올수 있다.
$username = $_SESSION['username'];
//타이틀과 내용을 post방식으로 전달되어 받음
$title = $_POST['title'];
$contents = $_POST['description'];
$writtendate = date("Y-m-d h:i:s");
//이미지 업로드 처리를 위한 추가변수 
//이미지가 업로드될 폴더로서 board폴더 아래 uploadfiles이라는 폴더 생성후 진행
$upload_path = './uploadfiles/';

// 여기부터 집중!------------------------------------------
//$_FILES는 파일처리를 위한 PHP 초전역변수!
//$_SESSION, $_POST, $_GET 등이 모두 PHP초전역 변수! 
//$_FILES['첫번째인자']['두번째인자']의 첫번째 인자는 
//직전의 form 화면에서 <input type = "file" name="첫번째인자"/>이다.

//업로드한 첨부파일이 있고 
//업로드한 파일을 저장용 폴더로 정상적으로 잘 옮겼다면 
//file을 첨부하여 저장하면 테이블에 업로드한 파일명을 추가하도록 처리 
//그렇지 않으면 기존 질의 처리구문으로 진행 
if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
  //먼저 업로드한 파일 이름은 다음 명령어로 가져온다. 
  //$filename = $_FILES['upload']['name'];
  //하지만 파일을 올라다 보면 파일명이 중복되는 경우가 비일비재하므로
  //파일명 중복을 피하기위해 타임스탬프를 파일명 앞에 붙여 유일하게 처리한다.
  //time()함수는 현재시간스탬프 가져오는 친구
  $filename = time()."_".$_FILES['upload']['name'];

  //upload한 파일을 $upload_path 폴더 아래에 $filename으로 잘 옮겨졌으면 
  if (move_uploaded_file($_FILES['upload']['tmp_name'], $upload_path.$filename)) {
    //upload 성공확인을 위한 메세지 추가
    if(DBG) echo outmsg(UPLOAD_SUCCESS);
    //파일명 입력 처리를 위한 prepared sql 구성 및 bind
    $stmt = $conn->prepare(("INSERT INTO board(title, b_username, contents, writtendate, uploadfiles) VALUES(?, ?, ?, ?, ?)"));
    $stmt -> bind_param("sssss", $title, $username, $contents, $writtendate, $filename);
  } else { //잘 안옮겨졌으면 
    //upload 실패확인을 위한 오류메세지 추가
    if(DBG) echo outmsg(UPLOAD_ERROR);
    }

  } else { // file을 추가하지 않은 기존 추가구문이라면 
    $stmt = $conn->prepare(("INSERT INTO board(title, b_username, contents, writtendate) VALUES(?, ?, ?, ?)"));
    $stmt -> bind_param("ssss", $title, $username, $contents, $writtendate);
  }

  // 여기까지가 이미지 업로드를 위해 수정한 코드--------------------------------
  // 지금 단계에에서 파일 첨부하여 저장하기가 잘 되는지 phpadmin통해서 파일이름 등록되는지 확인! 

  //상황에 따라 각각 구성된 질의 구문 처리
  $stmt-> execute();
  //실행 하고나서 바로resource 반납처리
  //서버상에서의 stmt의 메모리공간을 비워줌으로서 부담을 덜기
  $stmt-> close();

  //데이터베이스 연결 인터페이스 resource 반납처리
  $conn -> close();

  //서버의 메모리공간 절약을 위해 $stmt , $conn, $resultset 보통 이 3가지를 반납처리를 한다

  //추가처리를 완료하였음을 알린 후 게시판 목록 페이지로 이동
  echo outmsg(COMMIT_CODE);
  echo "<a href='./bd_list.php'>목록페이지로</a>";

}  else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>메인페이지로</a>" ;
}



?>
