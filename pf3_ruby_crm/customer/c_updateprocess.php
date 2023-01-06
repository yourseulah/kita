<!-- 
  파일명 : c_updateprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-07
  업데이트일자 : 2022-02-07
  
  기능: 
  c_update.php 사용자정보 수정 화면에서 입력된 값을 받아 
  customers 테이블에 사용자 수정된 데이터를 업데이트 한다. 
-->

<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if ($chk_login) {
  $username = $_SESSION['username'];

  $customerNumber = $_POST['customerNumber'];
  $customername = $_POST['customername'];
  $lineone = $_POST['lineone'];
  $linetwo = $_POST['linetwo'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $country = $_POST['country'];
  $postal = $_POST['postal'];
  $firstname = strtoupper($_POST['firstname']);
  $lastname = strtoupper($_POST['lastname']);
  $position = $_POST['position'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $salesrepNumber = $_POST['employeeNumber'];
  $term = $_POST['term'];
  $limit = $_POST['limit'];

  //img upload folder 
  $upload_path = "../img/";

  //similar to c_createprocess except deleting existing file
  //if files eixists, name the file with current date
  if(isset($_FILES['upload']['tmp_name']) && ($_FILES['upload']['tmp_name'] != "")) {
    $filename= time(). "_" . $_FILES['upload']['name'];
    if(move_uploaded_file($_FILES['upload']['tmp_name'], $upload_path.$filename)) {
      $sql="SELECT * FROM customers WHERE customerNumber = " . $customerNumber;
      $resultset = $conn->query($sql);
      $row = $resultset->fetch_assoc();
      $existingfile = $row['upload'];

       //add delete process for the original img if it exists
      if(isset($existingfile) && $existingfile !="") {
        unlink($upload_path.$existingfile);
      }
    }

  //prepare sql for UPDATE w/ a changed upload file 
  $stmt = $conn->prepare("UPDATE customers SET addressLine1=?, addressLine2=?, city=?, state=?, country=?, postalCode=?, contactFirstName=?, contactLastName=?, jobTitle=?, phone=?, email=?, creditTerm=?, creditLimit=?, upload=? WHERE customerNumber=?");
  $stmt->bind_param("ssssssssssssisi", $lineone, $linetwo, $city, $state, $country, $postal, $firstname, $lastname, $position, $phone, $email, $term, $limit, $filename, $customerNumber);

  } else {
  //prepare sql for UPDATE w/o a changed upload file 
  $stmt = $conn->prepare("UPDATE customers SET addressLine1=?, addressLine2=?, city=?, state=?, country=?, postalCode=?, contactFirstName=?, contactLastName=?, jobTitle=?, phone=?, email=?, creditTerm=?, creditLimit=? WHERE customerNumber=?");
  $stmt->bind_param("ssssssssssssii", $lineone, $linetwo, $city, $state, $country, $postal, $firstname, $lastname, $position, $phone, $email, $term, $limit, $customerNumber);
  }

  $stmt->execute();

  $stmt->close();
  
  header('Location: ./c_list.php');
} else {
  echo outmsg(LOGIN_NEED);
  header('Location: ../index.php');
}
?>