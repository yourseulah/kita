<!----------------------------------------------------------------------------- 
  파일명 : site_initiate.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-26
  업데이트일자 : 2022-01-26
  
  기능: 
  최초, root 권한을 이용하여 사이트가 동작하는데 필요한 환경을 만든다.
  데이터베이스 생성, 애플리케이션용 계정 생성, 테이블 생성 등을 포함한다.
  이 코드는 납품시 최초 1 회만 실행하며, 세팅 후 회수 처리하여
  사용자의 우발적 시스템 초기화를 방지하여야 한다.
------------------------------------------------------------------------------>

<?php

//Project name 
$toyappname = 'Portfolio_ERP';

//Server, user, pw, dbname define
$dbservername = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = $toyappname;

//message defined in
require_once "../util/utility.php";

//create servcer connection (db does not exist yet)
$conn = new mysqli($dbservername, $dbusername, $dbpassword);

//check connection 
if ($conn->connect_error) {
  echo outmsg(SERVERCONN_FAIL);
  die ("Connection Fail : " .$conn->connect_error);
} else {
  if (DBG) echo outmsg(SERVERCONN_SUCCESS);
}

//if db exists, drop. same for user
$sql = "DROP DATABASE IF EXISTS " .$dbname;
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPDB_SUCCESS);
} else {
  if (DBG) echo outmsg(DROPDB_FAIL);
}

$sql = "DROP USER IF EXISTS " .$dbname;
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPUSER_SUCCESS);
} else {
  if (DBG) echo outmsg(DROPUSER_FAIL);
}

//create useraccount and databse for the application
// 1. 사용자 계정을 생성하고, 
// 2. 리소스 제한 없이 사용하도록 권한을 부여하고,
// 3. 데이터베이스를 생성하고,
// 4. 생성된 사용자 계정에 데이터베이스에 대한 모든 권한을 부여 

//1. 사용자계정을 생성
$sql = "CREATE USER IF NOT EXISTS '" .$dbname. "'@'%' IDENTIFIED BY '" .$dbname. "'";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATEUSER_SUCCESS);
} else {
  echo outmsg(CREATEUSER_FAIL);
}

//2. 리소스 제한 없이 사용하도록 권한 부여
$sql = "GRANT USAGE ON *.* TO '" .$dbname. "'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(LIMITRSC_SUCCESS);
} else {
  echo outmsg(LIMITRSC_FAIL);
}

//3. 데이터베이스 생성
$sql = "CREATE DATABASE IF NOT EXISTS `" .$dbname. "`";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATEDB_SUCCESS);
} else {
  echo outmsg(CREATEDB_FAIL);
}

//4. 생성된 사용자 계정에 데이터베이스에 대한 모든 권한을 부여 
$sql = "GRANT ALL PRIVILEGES ON `" .$dbname. "`.* TO '" .$dbname. "'@'%' identified by '".$dbname."'";
if  ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(GRANTUSER_SUCCESS);
} else {
  echo outmsg(GRANTUSER_FAIL);
}

//db connection resource return
$conn->close();

//code complete message
if(DBG) echo outmsg(COMMIT_CODE);

echo "<a href='../offices/app_initiate.php'>Confirm</a>" ;

?>

<!-- 
!!WATCH OUT!!  
GRAVE ` 표기 
EXISTS 'S' 붙이기 
-->