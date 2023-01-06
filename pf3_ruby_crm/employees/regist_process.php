<!-- 
  파일명 : oo_user_regist_process.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-27
  업데이트일자 : 2022-01-27
  
  기능: 
  regist.php 회원가입화면에서 입력된 값을 받아, validation 후
  user 테이블에 사용자 가입 데이터를 추가한다.
-->

<?php

require "../util/dbconfig.php";

$firstname = strtoupper($_POST['firstname']);
$lastname = strtoupper($_POST['lastname']);
$username = $_POST['username'];
$passwd = $_POST['passwd'];
$cpasswd = $_POST['cpasswd'];
$cellphone  = $_POST['cellphone'];
$extension = $_POST['extension'];
$email = $username ."@ruby.com";
$birthdate = $_POST['birthdate'];
$officecode = $_POST['officecode'];
$reportsto = strtoupper($_POST['reportsto']);
$jobtitle = strtoupper($_POST['jobtitle']);
$startdate = $_POST['startdate'];

//img upload folder 
$upload_path = "../img/";

// error when password and confirm password not equal
if ($passwd != $cpasswd) {
  echo outmsg(DIFF_PASSWD);
  
} else {
  //error when same username exists
  $sql = "SELECT username FROM employees WHERE username = '" .$username. "'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo outmsg(EXIST_USERNAME);

  } else {
    //if upload file exist, add date on file name 
    if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
      $filename = time() . "_" .$_FILES['upload']['name'];

      //if upload file successfully added to the img folder, insert to table
      if (move_uploaded_file($_FILES['upload']['tmp_name'], $upload_path.$filename)) {
      if(DBG) echo outmsg(UPLOAD_SUCCESS);
      $stmt = $conn->prepare("INSERT INTO employees(firstName, lastName, userName, passwd, cellphone, extension, email, birthDate, officeCode, reportsTo, jobTitle, startDate, upload) VALUES(?, ?, ?, sha2(?,256), ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
      $stmt->bind_param("sssssssssssss", $firstname, $lastname, $username, $passwd, $cellphone, $extension, $email, $birthdate, $officecode, $reportsto, $jobtitle, $startdate, $filename);

     //if upload fails
    } else { 
      if(DBG) echo outmsg(UPLOAD_ERROR);
    }

    
  } else {
    //without an upload
    //insert signup info in table 
    //$sql = "SET FOREIGN_KEY_CHECKS=0";
    //$conn->query($sql);
    $stmt = $conn->prepare("INSERT INTO employees(firstName, lastName, userName, passwd, cellphone, extension, email, birthDate, officeCode, reportsTo, jobTitle, startDate) VALUES(?, ?, ?, sha2(?,256), ?, ?, ?, ?, ?, ?, ?, ?) ");
    $stmt->bind_param("ssssssssssss", $firstname, $lastname, $username, $passwd, $cellphone, $extension, $email, $birthdate, $officecode, $reportsto, $jobtitle, $startdate);
  }
  }

  $stmt->execute();
  $conn->close();

  echo outmsg(REGIST_SUCCESS);
  header ('Location: ../index.php');
}

?>


