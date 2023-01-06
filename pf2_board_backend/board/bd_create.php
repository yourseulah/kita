<!--
  프로젝트명 : 메모장 관리 시스템
  파일명 : bd_create.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-05
  업데이트일자 : 2022-01-05
  
  기능: 
  list화면에서 New버튼을 클릭하면 메모생성 페이지실행화면으로 
  넘어와서 메모의 제목, 내용을 입력하고 
  저장, 취소, 목록 버튼을 만들어 각각의 페이지로 넘어가도록 한다.
-->

<?php
require "../util/dbconfig.php";

//로그인한 상태일때만 이 페이지 내용을 확인할 수 있다.
//로그인체크한 상태에서 작성자를 불러온다 ($username)
require "../util/loginchk.php";
if($chk_login) {
  $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>게시글생성페이지</title>
  <link rel="stylesheet" href="./css/bd_create.css">
</head>

<body>
<h6>현재 로그인된 사용자는 <?=$username?>님</h6>
  <h1>게시글 생성</h1>
  <h4>자유롭게 생성 할수 있는 페이지 입니다.</h4>
  <br>

  <!-- 2020-01-12 img/file upload form을 위한 entype 추가 -->
  <form action="./bd_createprocess.php" method="POST" enctype="multipart/form-data">
  <div class="middle">
    <table>
      <tr>
        <th>제목</th> 
        <th><input type="text" name="title" placeholder="제목을 입력하세요." required/></th>
        <th>작성자</th><th><?=$username?></th>
      </tr>
      <tr><td colspan="4">내용</td></tr>
      <tr><td colspan="4"><textarea name="description" placeholder="내용을 입력하세요."></textarea></td></tr>
    </table>
  </div>

  <div class="bottom">
    <input type="file" size="100" name="upload"><hr> 
    <!-- 2022-01-12 이미지 업로드 처리를 위한 file type 추가  -->
    <br>
    <input type=submit value="저장">
    <input type=reset value="취소">
  </form>

    <a href="./bd_list.php">목록</a>
  </div>

</body>
<?php
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>메인페이지로</a>" ;
}
?>
</html>