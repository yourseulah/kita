<!--
  프로젝트명 : 게시판 관리 시스템
  파일명 : bd_list.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-03
  업데이트일자 : 2022-01-03
  
  기능: 
  리스팅화면에서 제목을 클릭하면 상세 화면으로 이동한다.
  
  2022-01-06 : pagination기능 추가

  2022.01.10 : 검색기능 추가 
  bd_list.php에서 검색 후 검색결과를 bd_searchresult.php에서 수행
  
  2022-01-12 : 이미지파일 업로드기능 추가 
  1. 파일이 업로드 될 폴더를 uploadfiles 생성 
  2. app_initiate.php의 board 테이블 생성하며 이미지 파일 이름을 보관하기 위한 필드 uploadfiles 추가
  3. bd_create.php 파일과, bd_createprocess.php 파일에서 파일처리를 위한 코드 추가/수정
  4. bd_detailview.php 코드에서 첨부된 파일을 디스플레이 하기위한 코드 추가/수정
  5. bd_update.php와 bd_updateprocess.php 파일에서 첨부된 파일을 수정하기 위한 인터페이스와 수정처리 코드 추가 수정
  6. bd_deleteprocess.php 에서 레코드 삭제시 테이블의 레코드 뿐만 아니라 업로드용 디렉토리에 존재하는 파일도 삭제처리 코드 추가/수정
-->

<?php
//db연결준비
require "../util/dbconfig.php";
require_once "../util/utility.php";

//로그인한 상태일때만 이 페이지 내용을 확인할 수 있다.
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
    <title>게시판</title>
    <link rel="stylesheet" href="./css/bd_list.css">
  </head>

  <body>

    <div id="board_area">
      <h6>현재 로그인된 사용자는 <?= $username ?>님</h6>
      <h1>자유게시판</h1>
      <h4>자유롭게 쓸 수 있는 게시판입니다.</h4>
      <br>

      <?php
      // 여기부터 pagination용 추가
      // 1. 페이지를 $_GET을 이용하여 전달 받는다. 없으면 현재 $page = 1이다.
      if (isset($_GET['page_no']) && $_GET['page_no'] != "") { //pagination에 의해 리스트페이지가 구동될때 get방식으로 page_no 전달받는다 
        $page_no = $_GET['page_no'];
      } else {
        $page_no = 1; //최초 리스트페이지가 구동될때 첫번째 페이지를 기본으로 설정
      }

      // 2. 페이지당 보여줄 리스트 갯수값을 정한다.
      $total_records_per_page = 10;

      // 3. OFFSET을 계산하고 앞/뒤 페이지 등의 변수를 설정한다.
      $offset = ($page_no - 1) * $total_records_per_page;
      $previous_page = $page_no - 1;
      $next_page = $page_no + 1;
      //$adjacents = 2;

      // 4. 전체 페이지 수를 계산한다.
      $sql = "SELECT COUNT(*) AS total_records FROM board";
      $resultset = $conn->query($sql);
      $result = mysqli_fetch_array($resultset);
      $total_records = $result['total_records'];
      $total_no_of_pages = ceil($total_records / $total_records_per_page);
      // $second_last = $total_no_of_pages - 1;
      ?>

      <!-- ========================================================== -->
      <!-- pagination을 위한 기존 코드 수정 -->

      <div class="top">
        <div class="innertop">
          <a href="./bd_deletealldata.php">지우기</a>
          <a href="./bd_create.php">글쓰기</a>
          <a href="../index.php">Index</a>
        </div>
      </div>

      <div class="middle">
        <?php
        $sql = "SELECT * FROM board ORDER BY id DESC LIMIT " . $offset . ", " . $total_records_per_page;
        $resultset = $conn->query($sql);

        if (true) {

          echo "<table>
    <thead>
      <tr>
        <th width='70px'>No</th>
        <th width='500px'>제목</th>
        <th width='120px'>글쓴이</th>
        <th width='150px'>작성일</th>
        <th width='100px'>조회수</th>
        <th width='100px'>좋아요</th>
      </tr>
    </thead>";

          while ($row = $resultset->fetch_assoc()) {
            echo "
      <tbody>
        <tr>
          <td>" . $row['id'] . "</td>
          <td><a href='./bd_detailview.php?id=" . $row['id'] . "'>" . $row['title'] . "&nbsp;&#91;" . $row['cmtcnt'] . "&#93</a></td>
          <td>" . $row['b_username'] . " </td>
          <td>" . substr($row['writtendate'], 0, 10) . "</td>
          <td>" . $row['viewcnt'] . "</td>
          <td>" . $row['likecnt'] . "</td>
        </tr>
      </tbody>";
          }
          echo "</table>";
        }
        ?>
      </div>

    </div>

    <!-- 2022.01.10 검색기능 추가부분 -->
    <div class="search_box">
      <form action="./bd_searchresult.php" method="get">
        <select name="catgo">
          <option value="title">제목</option>
          <option value="b_username">글쓴이</option>
          <option value="contents">내용</option>
        </select>

        <input type="text" name="keyword" size="28" required>&nbsp;<button>검색</button>
      </form>
    </div>

    <!-- =================================================================== -->
    <!-- 여기부터 pagination 위한 추가 부분 
li태크 시작과 끝을 주목하자 -->


    <ul class="pagination">
      <!-- 현재페이지가 첫번째 페이지 이상일 때 First Page 태그가 보여지도록 -->
      <?php if ($page_no > 1) {
        echo "<li><a href='?page_no=1'>First Page</a></li>";
      } ?>

      <!-- 현재페이지가 첫번째 페이지이거나 작을때 Previous 태그가 비활성화 
  크다면 Previous 태그가 활성화 -->
      <li <?php if ($page_no <= 1) {
            echo "class='disabled'";
          } ?>>
        <a <?php if ($page_no > 1) {
              echo "href='?page_no=$previous_page'";
            } ?>>Previous</a>
      </li>

      <?php
      // 한 라인당 몇 페이지를 표현할 것인지를 반영하여 처리하기
      $page_per_line = 10;  // 한라인에 표시할 페이지 수
      $start_page = floor($page_no / $page_per_line) * $page_per_line + 1;
      $end_page = $start_page + ($page_per_line - 1); // 끝 페이지

      if ($end_page > $total_no_of_pages) {  // 계산된 $end_page가 전체 페이지수 보다 크면
        $end_page = $total_no_of_pages; // $end_page = $total_no_pages가 되어야 한다.
      }

      //for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
      for ($counter = $start_page; $counter <= $end_page; $counter++) {
        if ($counter == $page_no) { // 현재페이지가 열려져 있는 페이지 임을 강조 (active 클라스로 표시)
          echo "<li class='active'><a>$counter</a></li>";
        } else { // 아니라면 강조표시없이 그대로
          echo "<li><a href='?page_no=$counter'>$counter</a></li>";
        }
      }
      ?>

      <!-- 현재페이지가 총페이지수보다 같거나 크면 Next 태그 비활성화 
작을때 Next 태그 활성화-->
      <li <?php if ($page_no >= $total_no_of_pages) {
            echo "class='disabled'";
          } ?>>
        <a <?php if ($page_no < $total_no_of_pages) {
              echo "href='?page_no=$next_page'";
            } ?>>Next</a>
      </li>

      <?php if ($page_no < $total_no_of_pages) {
        echo "<li><a href='?page_no=$total_no_of_pages'>Last Page &rsaquo;&rsaquo;</a></li>";
      } ?>
    </ul>

    <!-- =============================================================== -->

  </body>

<?php
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>메인페이지로</a>";
}
?>

  </html>