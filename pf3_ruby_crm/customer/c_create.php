<!--
  프로젝트명 : 메모장 관리 시스템
  파일명 : c_create.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-04
  업데이트일자 : 2022-02-04
  
  기능: 
  Table화면에서 Create Account버튼을 클릭하면 New Customer 등록화면으로
  넘어와서 customer detail정보 입력 후  
  save, reset, back 목록 버튼을 만들어 각각의 페이지로 넘어가도록 한다.

  2022-02-06 :
  로그인한 username이 고객의 salesrep이 되므로 
  employeeNumber를 제외한 나머지는 display
-->

<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if ($chk_login) {
  $username = $_SESSION['username'];
  require "../layout/topnav.php";
  require "../layout/layoutSidenav.php";
?>

  <!-- entype for img/file upload form -->
  <form action="c_createprocess.php" method="POST" enctype="multipart/form-data">
    <main>
      <div class="container-fluid px-4">
        <h1 class="mt-4">New Customer</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active"><a href="c_list.php">Table</a>&nbsp;I&nbsp;Create</li>
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

                    <input type="text" name="customername" placeholder="Customer Name" required />

                    <label>Address</label>
                    <div class="addressline">
                      <input type="text" name="lineone" placeholder="AddressLine 1" required />&nbsp;
                      <input type="text" name="linetwo" placeholder="AddressLine 2" />
                    </div>
                    <div class="restofaddress">
                      <input type="text" name="city" placeholder="City" required />&nbsp;
                      <input type="text" name="state" placeholder="State" />&nbsp;
                      <input type="text" name="country" placeholder="Country" />&nbsp;
                      <input type="text" name="postal" placeholder="Postal Code" />
                    </div>

                    <label>Contact Point</label>
                    <div class="name">
                      <input type="text" name="firstname" placeholder="First Name" required />&nbsp;
                      <input type="text" name="lastname" placeholder="Last Name" required />
                    </div>

                    <div class="contact">
                      <input type="text" name="position" placeholder="Position" required />&nbsp;
                      <input type="text" name="phone" placeholder="Phone" required />
                    </div>

                    <input type="text" name="email" placeholder="Email" required />
                  </div>
                </div>
              </div>

              <?php
              $sql = "SELECT * FROM employees where userName = '" . $username . "'";
              $result = $conn->query($sql);
              $emp_number = ""; //전역변수로 만들어준다 
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $emp_number = $row['employeeNumber'];
              ?>

                <div class="col-xl-6">
                  <div class="card mb-4">
                    <div class="card-header">
                      <i class="fas fa-user-check"></i>
                      Sales Rep
                    </div>
                    <div class="card-body">
                      <!-- <input type="hidden" name="employeeNumber" value="<?= $emp_number ?>" /> -->
                      
                      <table class="detailtable">
                      <tr>
                        <th colspan='1'>Full Name</th>
                        <th colspan='1'>Job Title</th>
                        <th colspan='1'>Office Code</th>
                      </tr>
                      <tr>
                        <td colspan='1'><?= $row['firstName'] . " " . $row['lastName'] ?></td>
                        <td colspan='1'><?= $row['jobTitle'] ?></td>
                        <td colspan='1'><?= $row['officeCode']?></td>
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

                <div class="col-xl-auto" style="display: flex !important">
                  <div class="card mb-4">
                    <div class="card-header">
                      <i class="fas fa-money-check-alt"></i>
                      Payment
                    </div>
                    <div class="card-body" style="flex-grow: 1 !important">
                      <input type="text" name="term" placeholder="Payment Term" />
                      <input type="text" name="limit" placeholder="Credit Limit" />
                      <input type="hidden" name="employeeNumber" value="<?= $emp_number ?>" />
                    </div>
                  </div> &nbsp;

                  <div class="card mb-4" style="flex-grow: 1 !important">
                    <div class="card-header">
                      <i class="fas fa-file-image"></i>
                      Logo
                    </div>
                    <div class="card-body">
                      <input type="file" size="60" name="upload">
                    </div>
                  </div>
                </div>
                </div>
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