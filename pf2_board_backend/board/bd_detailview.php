<!-- 
  프로젝트명 : 게시판 관리 시스템
  파일명 : bd_detailview.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-05
  업데이트일자 : 2022-01-05
  
  기능: 
  상세화면에서는 제목과 내용, 작성자, 등록일을 디스플레이 시키고
  상세화면 하단에는 수정, 삭제, 목록으로 버튼을 배치한다.
  조회수, 좋아요수 업데이트 
-->

<?php
//db연결준비
require "../util/dbconfig.php";

//로그인한 상태일때만 이 페이지 내용을 확인할 수 있다.
//로그인체크한 상태에서 작성자를 불러온다 ($username)
require "../util/loginchk.php";
if ($chk_login) {
  $username = $_SESSION['username'];
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글상세페이지</title>
    <link rel="stylesheet" href="./css/bd_detailview.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body>

    <div id="board_area">
      <h6>현재 로그인된 사용자는 <?= $username ?>님</h6>
      <h1>게시글 상세페이지</h1>
      <h4>상세글 확인 및 삭제할수 있는 페이지 입니다.</h4>
      <br>

      <div class="middle">
        <?php

        $board_id = $_GET['id'];
        //파일업로드 처리 폴더와 테이블 필드 확인을 확실히 하고 나면 
        //이제 업로드한 파일의 폴더를 확실히 해두고! 
        $upload_path = './uploadfiles/';
        $sql = "SELECT * FROM board WHERE id = " . $board_id;
        $resultset = $conn->query($sql);

        // if ($resultset->num_rows > 0) { 이렇게 해도 됨
        if (true) {
          $row = $resultset->fetch_assoc();
          $writer = $row['b_username'];
          //table로 상세내용 확인 페이지 레이아웃하기
        ?>
          <table>
            <tr>
              <th>No</th>
              <th> <?= $row['id'] ?> </th>
              <th>작성자</th>
              <th> <?= $writer ?> </th>
            </tr>
            <tr>
              <td>제목</td>
              <td> <?= $row['title'] ?> </td>
              <td>조회수</td>
              <td> <?= $row['viewcnt'] ?> </td>
            </tr>
            <tr>
              <td>작성일</td>
              <td> <?= $row['writtendate'] ?> </td>
              <td>수정일</td>
              <td> <?= $row['lastdate'] ?> </td>
            </tr>
            <tr>
              <th colspan='4'>내용</th>
            </tr>
            <tr>
              <td colspan='4' valign='top' align='left' style='min-height:500px; border-bottom: 1px solid #CCC'><?= $row['contents'] ?> </td>
            </tr>

            <?php
            if (isset($row['uploadfiles']) && ($row['uploadfiles'] != "")) {
            ?>
              <tr>
                <td>첨부파일</td>
                <td>
                  <img src="<?= $upload_path ?><?= $row['uploadfiles'] ?>" width='200px' height='auto'>
                </td>
              </tr>
            <?php
            } else {
              echo "<tr><td colspan='2' align='left'>No Image in this record.</td></tr>";
            }
            ?>


          </table>
        <?php
        }
        ?>
        <?php
        $sql = "UPDATE board SET viewcnt = viewcnt + 1 WHERE id =" .  $board_id;
        $resultset = $conn->query($sql);
        ?>
      </div>

      <div class="bottom">
        <a href="./bd_likeprocess.php?id=<?= $board_id ?>">좋아요</a>
        <!-- 로그인한 사용자와 작성자가 같으면 수정과 삭제 버튼 활성화 -->
        <?php
        if ($username == $writer) {
        ?>
          <a href="./bd_update.php?id=<?= $board_id ?>">수정</a>
          <a href="./bd_deleteprocess.php?id=<?= $board_id ?>">삭제</a>
        <?php
        }
        ?>
        <!-- 로그인한 사용자와 작성자가 같지 않으면 스킵-->
        <a href="./bd_list.php">목록</a>
      </div>
    </div>

    <div id="comment_area">
      <!-- 2022-01-12 댓글입력 폼 -->
      <div class="comment_create">
        <form action="./bd_cm_process.php" method="POST">
          <input type="hidden" name="board_id" value="<?= $board_id ?>">
          <input type="text" name="c_username" value="<?= $username ?>" readonly><br>
          <textarea name="description"></textarea> <br>

          <input type=submit value="완료">
          <input type=reset value="취소">
        </form>
        <br>
      </div>

      <!-- 2022-01-12 댓글 진열 -->
      <div class="comment_view">
        <?php
        $sql = "SELECT * FROM comment WHERE board_id = " . $board_id . " ORDER BY id DESC";
        $resultset = $conn->query($sql);
        if (true) {
        ?>
          <?php
          while ($row = $resultset->fetch_assoc()) {
            $comment_id = $row['id'];
            $contents = $row['contents'];
            $c_username = $row['c_username'];
          ?>

            <div class="default_display" id="comment_default_display<?= $comment_id ?>">
              <table>
                <tr>
                  <td><?= $row['c_username'] ?>&nbsp;&nbsp;&nbsp;<span style="font-size: 12px; color: #424242"><?= $row['writtendate'] ?></span></td>
                </tr>
                <tr>
                  <td height="50px" style="background-color: white;"><?= $row['contents'] ?></td>
                </tr>
                <!-- <tr><td><?= $row['writtendate'] ?></td></tr> -->
              </table>

              <div class="comment_bottom">
                <!-- 로그인한 사용자와 작성자가 같으면 수정과 삭제 버튼 활성화 -->
                <?php
                if ($username == $c_username) {
                ?>
                  <a href="./bd_cm_deleteprocess.php?comment_id=<?= $comment_id ?>&board_id=<?= $board_id ?>">삭제</a>
                  <a onclick='comment_edit(<?= $comment_id ?>)'>수정</a>
                <?php
                }
                ?>
                <a href="./bd_cm_likeprocess.php?comment_id=<?= $comment_id ?>&board_id=<?= $board_id ?>"><i class="fa fa-thumbs-up"></i>&nbsp;<?= $row['likecnt'] ?></a>
              </div>
            </div>

            <div class="comment_create default_hide" id="comment_update_display<?= $comment_id ?>">
              <form action="./bd_cm_updateprocess.php" method="POST">
                <input type="hidden" name="board_id" value="<?= $board_id ?>">
                <input type="hidden" name="comment_id" value="<?= $comment_id ?>">
                <input type="text" name="c_username" value="<?= $username ?>" readonly><br>
                <textarea name="description"><?= $contents ?></textarea> <br>

                <input type=submit value="완료">
                <input type=reset value="취소" onclick='comment_edit(<?= $comment_id ?>)'>
              </form>
              <br>
            </div>

          <?php
          }
          ?>


        <?php
        }
        ?>



      </div>
    </div>

  <?php
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>메인페이지로</a>";
}
  ?>


  <script src='../js/comment_edit.js'></script>
  </body>

  </html>