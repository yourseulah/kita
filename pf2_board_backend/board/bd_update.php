<!-- 
  프로젝트명 : 메모장 관리 시스템
  파일명 : bd_update.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-05
  업데이트일자 : 2022-01-05
  
  기능: 
  제목과 내용을 수정한 후 
  수정화면 하단에 완료, 취소, 목록으로 버튼은 배치한다. 
-->

<?php
//연결준비
require "../util/dbconfig.php";

//로그인한 상태일 때만 수정 가능 
require_once '../util/loginchk.php';

//------------------------------------------
//be_detailview.php에서 첨부파일 디스플레이 되는것 확인되면 이제 update! 
//여기서도 우선 업로드 경로명 확인!
$upload_path = './uploadfiles/'; //upload파일 처리


if ($chk_login) {
  //수정할 레코드 id값을 받아온다.
  $id = $_GET['id'];
  //해당 id로 데이터를 검색하는 질의문 구성
  $sql = "SELECT * FROM board WHERE id = " . $id;
  //해당 질의문 실행하여 결과 가져오기
  $result = $conn->query($sql);

  // 결과셋을 한 개의 행으로 처리하고,
  // 필요로 하는 각 컬럼의 값을 얻어온다.
  if (true) {
    $row = $result->fetch_array();
    $title = $row['title'];
    $contents = $row['contents'];
    $writtendate = $row['writtendate'];
    $lastdate = $row['lastdate'];
    //업로드명 파일 가져오기 2022-01-12 
    $uploadfile = $row['uploadfiles'];
  } else {
    echo outmsg(INVALID_USER);
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글수정페이지</title>
    <link rel="stylesheet" href="./css/bd_update.css">
  </head>

  <body>

    <div id="board_area">
      <h1>게시글 수정</h1>
      <h4>자유롭게 수정 할수 있는 페이지 입니다.</h4>
      <br>

      <form action="./bd_updateprocess.php" method="POST" enctype="multipart/form-data">

        <div class="middle">
          <table>
            <input type="hidden" name="id" value="<?= $id ?>">
            <tr>
              <th>제목</th>
              <th><input type="text" name="title" value="<?= $title?>" /></th>
              <th>작성일</th>
              <th><input type="text" name="writtendate" value="<?= $writtendate ?>" readonly /></th>
            </tr>
            <tr>
              <td colspan="4" style='border-bottom: 1px solid #CCC'>내용</td>
            </tr>
            <tr>
              <td colspan="4"><textarea name="description" style='border-bottom: 1px solid #CCC'><?= $contents ?></textarea></td>
            </tr>
            <!-- 이거 중요!!!!! <input type=text>와 <textarea>는 value값을 적어주는 방식이 다르다 -->

            <!-- 2022-01-12 경로명과 파일명 결합해서 이미지파일 뿌려준다 -->
            <?php
            if (isset($row['uploadfiles']) && ($row['uploadfiles'] != "")) {
            ?>
              <tr>
                <td>첨부파일</td>
                <td>
                  <img src="<?= $upload_path . $uploadfile ?>" width='200px' height='auto'>
                </td>
              </tr>
            <?php
            } else {
              echo "<tr><td colspan='2' align='left'>No Image in this record.</td></tr>";
            }
            ?>
          </table>
        </div>

        <div class="bottom">
          <input type="file" size="100" name="upload">
          <hr>
          <br>
          <input type=submit value="완료">
          <input type=reset value="취소">

      </form>
      <a href="./bd_list.php">목록</a>
    </div>

    </div>
  </body>

<?php
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>

</html>