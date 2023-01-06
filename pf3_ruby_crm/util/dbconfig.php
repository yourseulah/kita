<!----------------------------------------------------------------------------- 
  파일명 : dbconfig.php
  최초작성자 : Seulah Lee
  최초작성일 : 2022-01-26
  업데이트일 : 2022-01-26
  
  기능: 
  DBMS 시스템 접속용 기본 정보 선언.
  실제 애플리케이션 제작에서는 클라이언트 사이트의 환경,
  즉, DBMS의 종류별 configuration 정보를 참조하여 구성함.
------------------------------------------------------------------------------>

<?php
//Project name 
$toyappname = 'Portfolio_ERP';
//$toyappname = 'seulahlee'; //dothome용

//server, user, pw, db define
$dbservername = 'localhost';
$dbusername = $toyappname;
$dbpassword = $toyappname;
//$dbpassword = "Dltmfdk91#"; //dothome용
$dbname = $toyappname;

//message defined in
require "../util/utility.php";

//create server and db connection 
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

//check db connection
if ($conn->connect_error) {
  echo outmsg(DBCONN_FAIL);
  die("연결실패 : " .$conn->connect_error);
} else {
  if (DBG) echo outmsg(DBCONN_SUCCESS);
}

?>
