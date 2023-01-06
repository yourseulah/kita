<!-- 
  프로젝트명 : 메모장 관리 시스템
  파일명 : c_update.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-07
  업데이트일자 : 2022-02-07
  
  기능: 
  내용을 수정한 후 수정화면 하단에 
  save, reset, back 버튼은 배치한다. 
-->

<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if ($chk_login) {
  $username = $_SESSION['username'];
  require "../layout/topnav.php";
  require "../layout/layoutSidenav.php";
  $customerNumber = $_GET['customerNumber'];

  $sql = "SELECT * FROM customers WHERE customerNumber=" . $customerNumber;
  $result = $conn->query($sql);

  //take out info needed only
  if (true) {
    $row = $result->fetch_assoc();
    $customerNumber = $row['customerNumber'];
    $lastname = $row['contactLastName'];
    $firstname = $row['contactFirstName'];
    $lineone = $row['addressLine1'];
    $linetwo = $row['addressLine2'];
    $upload_path = "../img/"; 
  } else {
    echo outmsg(INVALID_USER);
  }
?>

  <!-- entype for img/file upload form -->
  <form action="c_updateprocess.php" method="POST" enctype="multipart/form-data">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">Update Customer</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active"><a href="c_list.php">Table</a>&nbsp;I&nbsp;Update</li>
        </ol>

        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-users"></i>
            Customer Information
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-xl-6">
                <div class="card mb-4">
                  <div class="card-header">
                    <i class="fas fa-address-book"></i>
                    Customer
                  </div>
                  <div class="card-body">
                    <input type="hidden" name="customerNumber" value="<?= $customerNumber ?>" />
                    <input type="text" name="customername" value="<?= $row['customerName'] ?>" readonly />
                    <br><br>

                    <label>Address</label>
                    <div class="addressline">
                      <input type="text" name="lineone" value="<?= $lineone ?>" />&nbsp;
                      <input type="text" name="linetwo" value="<?= $linetwo ?>" />
                    </div>
                    <div class="restofaddress">
                      <input type="text" name="city" value="<?= $row['city'] ?>" />&nbsp;
                      <input type="text" name="state" value="<?= $row['state'] ?>" />&nbsp;
                      <input type="text" name="country" value="<?= $row['country'] ?>" />&nbsp;
                      <input type="text" name="postal" value="<?= $row['postalCode'] ?>" />
                    </div>
                    <br>

                    <label>Contact Point</label>
                    <div class="name">
                      <input type="text" name="firstname" value="<?= $firstname ?>" required />&nbsp;
                      <input type="text" name="lastname" value="<?= $lastname ?>" required />
                    </div>

                    <div class="contact">
                      <input type="text" name="position" value="<?= $row['jobTitle'] ?>" />&nbsp;
                      <input type="text" name="phone" value="<?= $row['phone'] ?>" />
                    </div>

                    <input type="text" name="email" value="<?= $row['email'] ?>" required />
                  </div>
                </div>
              </div>

              <div class="col-xl-6">
                <div class="col-xl-auto" style="display: flex !important">
                  <div class="card mb-4">
                    <div class="card-header">
                      <i class="fas fa-money-check-alt"></i>
                      Payment
                    </div>
                    <div class="card-body" style="flex-grow: 1 !important">
                      <input type="text" name="term" value="<?= $row['creditTerm'] ?>" />
                      <input type="text" name="limit" value="<?= $row['creditLimit'] ?>" />
                      <input type="hidden" name="employeeNumber" value="<?= $emp_number ?>" />
                    </div>
                  </div> &nbsp;

                  <div class="card mb-4" style="flex-grow: 1 !important">
                    <div class="card-header">
                      <i class="fas fa-file-image"></i>
                      Logo
                    </div>
                    <div class="card-body">
                    <?php
                      if (isset($row['upload']) && ($row['upload']) != "") {
                      ?>
                        <img id="logoimg" src="<?= $upload_path ?><?= $row['upload'] ?>" width="100px" height="auto" >
                      <?php
                      }
                      ?>
                      <input type="file" size="60" name="upload">
                    </div>
                  </div>
                </div>

                <div class="col-xl-auto" style="display: flex !important">
                  <div class="card mb-4" style="flex-grow: 1 !important">
                    <div class="card-header">
                      <i class="fas fa-calendar-alt"></i>
                      Date
                    </div>
                    <div class="card-body">
                      <table class="detailtable">
                        <tr>
                          <th>Register Date</th>
                        </tr>
                        <tr>
                          <td><?= $row['registDate'] ?></td>
                        </tr>
                        <tr>
                          <th>Updated Date</th>
                        </tr>
                        <tr>
                          <td><?= $row['updateDate'] ?></td>
                        </tr>
                      </table>
                    </div>
                  </div> &nbsp;

                  <?php
                  $sql = "SELECT * FROM employees where userName = '" . $username . "'";
                  $result = $conn->query($sql);
                  $emp_number = ""; //전역변수로 만들어준다 
                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $emp_number = $row['employeeNumber'];
                  ?>

                    <div class="card mb-4" style="flex-grow: 1 !important">
                      <div class="card-header">
                        <i class="fas fa-user-check"></i>
                        Sales Rep
                      </div>
                      <div class="card-body">
                        <table class="detailtable">
                          <tr>
                            <th colspan='1'>Full Name</th>
                            <th colspan='1'>Job Title</th>
                            <th colspan='1'>Office Code</th>
                          </tr>
                          <tr>
                            <td colspan='1'><?= $row['firstName'] . " " . $row['lastName'] ?></td>
                            <td colspan='1'><?= $row['jobTitle'] ?></td>
                            <td colspan='1'><?= $row['officeCode'] ?></td>
                          </tr>
                          <tr>
                            <th colspan='1'>Email</th>
                            <th colspan='2'>Ext.</th>
                          </tr>
                          <tr>
                            <td colspan='1'><?= $row['email'] ?></td>
                            <td colspan='2'><?= $row['extension'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>

                  <?php
                  }
                  ?>
                </div>
              </div>

              <div class="card-body">
                <input type=submit value="Save">
                <input type=reset value="Reset">
                <a class="back" href="c_list.php">Back</a>
              </div>

            </div>
    </main>
  </form>



<?php
  require "../layout/tail.php";
} else {
  echo outmsg(LOGIN_NEED);
  header('Location: ../index.php');
}
?>