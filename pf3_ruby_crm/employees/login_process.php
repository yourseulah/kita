<!-- 
  파일명 : loginprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-26
  업데이트일자 : 2022-01-26
  
  기능 : 
  session 관리 목적
  index.php 로그인 화면에서 입력된 값을 받아온
  username passwd이 등록된 사용자임을 확인한다.

  배운점 :   
  세션 어디서 시작해서 어디를 거쳐 끝나는지
  $conn->close();이 if문 안에 있지않고 바로 해줘도 된다. 
  테이블 속성값은 case sensitive
-->

<?php
//session manage start 
session_start(); 

//db connect
require_once "../util/dbconfig.php";

//get login info from index.php
$username = $_POST['username'];
$passwd = $_POST['passwd'];

//prepare statement - validate login info
$stmt = $conn->prepare("SELECT * FROM employees WHERE userName = ? and passwd = sha2(?,256)");
$stmt->bind_param("ss", $username, $passwd);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);
$conn->close();


if(!empty($row['userName'])) {
  echo outmsg(LOGIN_SUCCESS);

  //session management
  echo outmsg(SESSION_CREATE);
  $_SESSION['username'] = $username; 

  //echo "login success";
  header('Location: ../customer/c_list.php');
} else {
  echo outmsg(LOGIN_FAIL);
  echo "login fail";
  //header('Location: ../index.php');
}

?>

