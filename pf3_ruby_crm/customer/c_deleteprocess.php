<!-- 
  파일명 : c_deleteprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-07 
  업데이트일자 : 2022-02-07
  
  기능: 
  customerNumber를 GET 패러미터로 받아 삭제처리한다.
-->

<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if ($chk_login) {
  $username = $_SESSION['username'];
  $customerNumber = $_GET['customerNumber'];
  $upload_path = "../img/";

  //See if the uploaded file exists
  $sql = "SELECT * FROM customers WHERE customerNumber = " . $customerNumber;
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $existingfile = $row['upload'];

  //if exists, unlink the file
  if (isset($existingfile) && $existingfile !="") {
    unlink($upload_path.$existingfile);
  }
  // and delete
  $sql = "DELETE FROM customers WHERE customerNumber= " . $customerNumber;
  
  //execute
  if ($conn->query($sql)) {
    echo outmsg(DELETE_SUCCESS);
  } else {
    echo outmsg(DELETE_FAIL);
  }

  //return resource
  $result->close();
  $conn->close();

  header('Location: ./c_list.php');
} else {
  echo outmsg(LOGIN_NEED);
  header('Location: ../index.php');
}
?>