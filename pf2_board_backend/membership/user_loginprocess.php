<!-- 
  파일명 : user_loginprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-03
  업데이트일자 : 2022-01-03
  
  기능: 
  user_login.php 로그인 화면에서 입력된 값을 받아 
  유저명과 비밀번호를 확인, 등록된 사용자임을 확인한다.
-->

<?php
// 여기부터는 로그인 성공시 세션관리를 위한 코드 추가
// 세션은 항상 다른 모든 명령에 앞서 나와야 한다. 
session_start();
// db연결 준비
require_once "../util/dbconfig.php";

// 데이터베이스 작업 전, 로그인 화면으로 부터 값을 전달 받고
$username = $_REQUEST['username'];
$passwd = $_REQUEST['passwd'];
//echo  $username."  ".$passwd; 값이 잘 넘어왔는지 확인

// 사용자 계정 존재 여부 확인을 위한 질의 구성
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? and passwd = sha2(?,256)");
$stmt->bind_param("ss", $username, $passwd);

$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);

if (!empty($row['username'])) {
  echo outmsg(LOGIN_SUCCESS);
  // 여기부터 로그인 성공시 세션관리를 위한 추가 코드
  //session_start();
  echo outmsg('SESSION_CREATE');
  //echo outmsg($userip);

  //브라우저에서 쿠키를 허용한다는 전제하에 만들어준건데 실제로 여기서는 쓰지는 않는다.
  if(isset($_REQUEST['chkbox'])){
    $a = setcookie('username', $username, time() + 60);
    $b = setcookie('passwd', $passwd, time() + 60);
  }

  //'세션변수이름-우리가 정해주면된다'
  $_SESSION['username']=$username;

  // 여기까지 로그인 성공시 세션관리를 위한 추가 코드
  $conn->close();
  //header('Location: user_list.php');
  echo "<a href='./user_userlist.php'>목록보기</a>";
} else {
  echo outmsg(LOGIN_FAIL);
  $conn->close();
  //header('Location: index.php');
  echo "<a href='../index.php'>index 페이지로</a>";
}

?>