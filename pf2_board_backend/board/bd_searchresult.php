<!--
  파일명 : bd_searchresult.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-10
  업데이트일자 : 2022-01-10
  
  기능: 
  list화면에서 search에서 카테고리에 맞는 속성의 결과값을 가져오도록한다.
-->

<?php
//db연결준비
require "../util/dbconfig.php";
require_once "../util/utility.php";

//preparestatement로 하는 방법 찾아보자--
//$keyword = '%'.$_POST['keyword'].'%';
// $sql = "SELECT * FROM board WHERE ? LIKE ?";
// $stmt = $conn->prepare($sql);
// ?$stmt -> bind_param("ss", $category, $keyword);
// $stmt->execute();
//$resultset = $stmt->get_result();
// echo outmsg($category);
// echo outmsg($keyword);

// $category = $_POST['catgo'];
// $keyword = $_POST['keyword'];
// $sql = "SELECT * FROM board WHERE ".$category." like '%".$keyword."%'";
// $resultset = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search</title>
  <link rel="stylesheet" href="./css/bd_searchresult.css">
</head>
<body>

<div id="board_area">
<h1>Search 결과페이지</h1>
  <h4>Search한 결과값이 나오는 페이지입니다.</h4>
  <br>

  <div class="top">
  <a href="./bd_list.php">목록</a>
  </div>

<?php
// 여기부터 pagination용 추가=======================================
  // 1. 페이지를 $_GET을 이용하여 전달 받는다. 없으면 현재 $page = 1이다.
  if(isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
  } else {
    $page_no =1;
  }

  // 2. 페이지당 보여줄 리스트 갯수값을 정한다.
  $total_records_per_page = 10;

 // 3. OFFSET을 계산하고 앞/뒤 페이지 등의 변수를 설정한다.
  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  // 4. 전체 페이지 수를 계산한다.
  $category = $_GET['catgo'];
  $keyword = $_GET['keyword'];

  $sql = "SELECT count(*) AS total_records FROM board WHERE ".$category." like '%".$keyword."%'";
  $resultset = $conn->query($sql);
  $result = mysqli_fetch_array($resultset);
  $total_records = $result['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  $sql = "SELECT * FROM board WHERE ".$category." like '%".$keyword."%' ORDER BY id DESC LIMIT ".$offset.", ".$total_records_per_page;
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

  while($row = $resultset->fetch_assoc()) {
    echo "
    <tbody>
      <tr>
        <td>".$row['id']."</td>
        <td><a href='./bd_detailview.php?id=".$row['id']."'>".$row['title']."</a></td>
        <td>".$row['b_username']."</td>
        <td>".substr ($row['writtendate'],0,10)."</td>
        <td>".$row['viewcnt']."</td>
        <td>".$row['likecnt']."</td>
      </tr>
    </tbody>";
  }
  echo "</table>";
}
?>
</div>

<br>


<!-- 여기부터 pagination 위한 추가 부분 
li태크 시작과 끝을 주목하자 -->

<ul class="pagination">
  <!-- 현재페이지가 첫번째 페이지 이상일 때 First Page 태그가 보여지도록 -->
  <?php if($page_no > 1) {
    echo "<li><a href='?page_no=1&catgo=$category&keyword=$keyword'>First Page</a></li>";
  } ?>

  <!-- 현재페이지가 첫번째 페이지이거나 작을때 Previous 태그가 비활성화 
  크다면 Previous 태그가 활성화 -->
  <li <?php if($page_no <= 1) { echo "class='disabled'"; } ?>>
    <a <?php if($page_no > 1) {
      echo "href='?page_no=$previous_page&catgo=$category&keyword=$keyword'";
    } ?>>Previous</a>
  </li>

  <?php
  // 한 라인당 몇 페이지를 표현할 것인지를 반영하여 처리하기
  $page_per_line = 10;  // 한라인에 표시할 페이지 수, 예: 3
  $start_page = floor($page_no / $page_per_line)*$page_per_line + 1;
  $end_page = $start_page + ($page_per_line - 1); // 끝 페이지, 예: 6

  if($end_page > $total_no_of_pages) {  // 계산된 $end_page가 전체 페이지수 보다 크면
    $end_page = $total_no_of_pages; // $end_page = $total_no_pages가 되어야 한다.
  }

	//for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
  for ($counter = $start_page; $counter <= $end_page; $counter++){  
	if ($counter == $page_no) { // 현재페이지가 열려져 있는 페이지 임을 강조 (active 클라스로 표시)
	echo "<li class='active'><a>$counter</a></li>";
    } else { // 아니라면 강조표시없이 그대로
      echo "<li><a href='?page_no=$counter&catgo=$category&keyword=$keyword'>$counter</a></li>";
    }
  }
?>

<!-- 현재페이지가 총페이지수보다 같거나 크면 Next 태그 비활성화 
작을때 Next 태그 활성화-->
<li <?php if($page_no >= $total_no_of_pages){
  echo "class='disabled'";
  } ?>>
  <a <?php if($page_no < $total_no_of_pages) {
  echo "href='?page_no=$next_page&catgo=$category&keyword=$keyword'";
  } ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
  echo "<li><a href='?page_no=$total_no_of_pages&catgo=$category&keyword=$keyword'>Last Page &rsaquo;&rsaquo;</a></li>";
  } ?>
  </ul>

</body>
</html>


