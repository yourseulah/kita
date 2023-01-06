<!-- 
  파일명 : c_createprocess.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-06
  업데이트일자 : 2022-02-06
  
  기능: 
  c_create.php 화면에서 입력된 값을 받아
  customer 테이블에 데이터를 추가한다.
-->

<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if ($chk_login) {
  $username = $_SESSION['username'];

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

  //if upload file exist, add date on file name
  if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
    $filename = time() . "_" . $_FILES['upload']['name'];

    //if upload file sucessfully added to the img folder, insert to table
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $upload_path . $filename)) {
      if (DBG) echo outmsg(UPLOAD_SUCCESS);
      $stmt = $conn->prepare("INSERT INTO customers(customerName, contactLastName, contactFirstName, jobTitle, phone, email, addressLine1, addressLine2, city, state, country, postalCode, salesRepEmployeeNumber, creditTerm, creditLimit, upload) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssssssssssisis", $customername, $lastname, $firstname, $position, $phone, $email, $lineone, $linetwo, $city, $state, $country, $postal, $salesrepNumber, $term, $limit, $filename);

      //if upload fails
    } else {
      if (DBG) echo outmsg(UPLOAD_ERROR);
    }

  //if upload file does NOT exists, insert rest of info without it
  } else {
    $stmt = $conn->prepare("INSERT INTO customers(customerName, contactLastName, contactFirstName, jobTitle, phone, email, addressLine1, addressLine2, city, state, country, postalCode, salesRepEmployeeNumber, creditTerm, creditLimit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssisi", $customername, $lastname, $firstname, $position, $phone, $email, $lineone, $linetwo, $city, $state, $country, $postal, $salesrepNumber, $term, $limit);
  }

  $stmt->execute();
  $conn->close();


  header('Location: ./c_list.php');
} else {
  echo outmsg(LOGIN_NEED);
  header('Location: ../index.php');
}
?>