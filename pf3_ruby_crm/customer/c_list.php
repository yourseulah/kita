<!--
  프로젝트명 : Customer Management / CRM 미니 버전
  파일명 : c_list.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-04
  업데이트일자 : 2022-02-04
  
  기능: 
  로그인후 제일 먼저 보이는 메인 페이지겸
  side nav에서 customer클릭하면 보이는 페이지

  상단에는 customer detail 박스 
  하단에는 customer list 박스를 위치시킨다
    
  2022-02-04 : 
  Apply bootstrap - icon, naming, common layout 분리
  card-body 안에 있는 bootstrap에 포함된 js코드 (cdn: contents delivery network)가 자동생성을 했기때문에 수정하기 불편하여 그대로 사용 
  추후 필요에 따라 수정가능함  
    DataTable Top : search기능
    DataTable bottom : pagination기능

  2022-02-06:
  SELECT구문 각각
  Customer List 테이블에 info 뿌리기 : fetch_assoc one result display
  Customer Detail 테이블 info 뿌리기 : while loop 
  
  2022-02-07
  Use GET method for displaying info of a specific id evenif it is under the same page
  DELETE process
-->

<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if ($chk_login) {
  $username = $_SESSION['username'];
  require "../layout/topnav.php";
  require "../layout/layoutSidenav.php";
?>

  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Customer Management</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Table</li>
      </ol>

      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body" style="font-weight: bold;">New Customer</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="c_create.php">Create Account</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>
      </div>

    <!-- Customer Detail -->
      <?php
      // display Customer Detail clicked from Customer List 
      if(isset($_GET['customerNumber']) && $_GET['customerNumber']!='') {
        //use GET method, WHERE in sql query to bring and display specific info
        $customerNumber = $_GET['customerNumber'];
        $upload_path = "../img/"; 
      ?>

      <div class="card mb-4" style="overflow: hidden;">
      <div class="card-header">
        <i class="fas fa-address-book"></i>
        Customer Details
        <i class="fas fa-angle-down" style="float: right; margin-top: 5px;" onclick="detailtoggle('detailtoggle');"></i>
      </div>
      
      <?php
      // customers & employees INNER JOIN QUERY 
      $sql = "SELECT c.customerNumber, c.customerName, c.contactFirstName, c.contactLastName, c.jobTitle as cjob, c.phone, c.email as cemail, c.addressLine1, c.addressLine2, c.city, c.state, c.postalCode, c.country, c.salesRepEmployeeNumber, c.creditTerm, c.creditLimit, c.upload, c.registDate, c.updateDate, e.firstName, e.lastName, e.employeeNumber, e.jobTitle as ejob, e.email as eemail, e.extension, e.officeCode
            FROM customers AS c
            INNER JOIN employees AS e 
              ON c.salesRepEmployeeNumber= e.employeeNumber
            WHERE c.customerNumber = ".$customerNumber."
            ORDER BY customerNumber DESC ";
      $resultset = $conn->query($sql);

      if ($row = $resultset->fetch_assoc()) {
      ?>
            <!-- start TOGGLE when click customerName -->
            <div id="detailtoggle" class=" detailshow ">
              <div class="card-body" style="display:flex; flex-direction:row;">

              <!-- div including Customer, Sales Rep, Payment, and Date -->
                <div class="col-xl-9" style=" display:flex; flex-direction:row;">

                  <!-- div including Customer and Payment -->
                  <div class="col-xl-6">
                    <div class="card mb-4">
                      <div class="card-header">
                        <i class="fas fa-address-book"></i>
                        Customer
                      </div>
                      <div class="card-body">
                        <table class="detailtable">
                          <tr>
                            <th colspan='2'>Customer Name</th>
                          </tr>
                          <tr>
                            <td colspan='2'><?= $row['customerName'] ?></td>
                          </tr>
                          <tr>
                            <th colspan='2'>Address</th>
                          </tr>
                          <tr>
                            <td colspan='1' style="border-right: 1px solid #ccc;"><?= $row['addressLine1'] ?></td>
                            <td colspan='1'><?= $row['addressLine2'] ?></td>
                          </tr>

                          <tr>
                            <td colspan='1' style="border-right: 1px solid #ccc;"><?= $row['city'] ?></td>
                            <td colspan='1'><?= $row['state'] ?></td>
                          </tr>
                          <tr>
                            <td colspan='1' style="border-right: 1px solid #ccc;"><?= $row['country'] ?></td>
                            <td colspan='1'><?= $row['postalCode'] ?></td>
                          </tr>

                          <tr>
                            <th colspan='2'>Contact Point</th>
                          </tr>
                          <tr>
                            <td colspan='1' style="border-right: 1px solid #ccc;"><?= $row['contactFirstName'] . " " . $row['contactLastName'] ?></td>
                            <td colspan='1'><?= $row['cjob'] ?></td>
                          </tr>
                          <tr>
                            <td colspan='1' style="border-right: 1px solid #ccc;"><?= $row['phone'] ?></td>
                            <td colspan='1'><?= $row['cemail'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="card mb-4">
                      <div class="card-header">
                        <i class="fas fa-money-check-alt"></i>
                        Payment
                      </div>
                      <div class="card-body">
                        <table class="detailtable">
                          <tr>
                            <th>Credit Term</th>
                          </tr>
                          <tr>
                            <td><?= $row['creditTerm'] ?></td>
                          </tr>
                          <tr>
                            <th>Credit Limit (USD)</th>
                          </tr>
                          <tr>
                            <td><?= $row['creditLimit'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>&nbsp;

                  <!-- div including Sales Rep and Date -->
                  <div class="col-xl-6">
                    <div class="card mb-4">
                      <div class="card-header">
                        <i class="fas fa-user-check"></i>
                        Sales Rep
                      </div>
                      <div class="card-body">
                        <table class="detailtable">
                          <tr>
                            <th colspan='2'>Full Name</th>
                          </tr>
                          <tr>
                            <td colspan='2'><?= $row['firstName'] . " " . $row['lastName'] ?></td>
                          </tr>

                          <tr>
                            <th colspan='1' >Email</th>
                            <th colspan='1'>Ext.</th>
                          </tr>
                          <tr>
                            <td colspan='1'><?= $row['eemail'] ?></td>
                            <td colspan='1'><?= $row['extension'] ?></td>
                          </tr>

                          <tr>
                            <th colspan='1'>Job Title</th>
                            <th colspan='1'>Office Code</th>
                          </tr>
                          <tr>
                            <td colspan='1'><?= $row['ejob'] ?></td>
                            <td colspan='1'><?= $row['officeCode']?></td>
                          </tr>

                        </table>
                      </div>
                    </div>

                    <div class="card mb-4">
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
                    </div>

                  </div>
                </div> &nbsp;

                <div class="col-xl-3">
                  <div class="card mb-4">
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
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body">
                <a class="back" href="./c_update.php?customerNumber=<?=$customerNumber?>">Update</a>
                <a class="back" href="./c_deleteprocess.php?customerNumber=<?=$customerNumber?>">Delete</a>
              </div>
            </div>
            <!-- 여기까지 customer name 클릭시 토글, 또는 토글 버튼 클릭시 토글 -->
          </div>
      <?php
      }

      }else {
      }       
      ?>

      <!-- Customer List Table -->
      <?php
      // customers & employees INNER JOIN QUERY 
      $sql = "SELECT c.customerNumber, c.customerName, c.contactFirstName, c.contactLastName, c.jobTitle, c.phone, c.country, c.salesRepEmployeeNumber, c.creditTerm, c.creditLimit, e.firstName, e.lastName, e.employeeNumber
      FROM customers AS c
      INNER JOIN employees AS e 
        ON c.salesRepEmployeeNumber= e.employeeNumber
      ORDER BY customerNumber DESC ";
      $resultset = $conn->query($sql);
      ?>

          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Customer List
            </div>
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th>Customer Name</th>
                    <th>Contact Name</th>
                    <th>Position</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Sales Rep</th>
                    <th>Credit Limit</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if (true) {
                  while ($row = $resultset->fetch_assoc()) {
                ?>
                  <tr>
                    <!-- click customerName, display customer detail above. 
                    use customerNumber to identify which customer detail to display (GET method) -->
                    <td><a onclick="detailtoggle('detailtoggle');" href="?customerNumber=<?=$row['customerNumber']?>"><?= $row['customerName'] ?></a></td>
                    <td><?= $row['contactFirstName'] . " " . $row['contactLastName'] ?></td>
                    <td><?= $row['jobTitle'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['country'] ?></td>
                    <td><?= $row['firstName'] . " " . $row['lastName'] ?></td>
                    <td><?= $row['creditLimit'] ?></td>
                  </tr>
                <?php
                } 
              }
              ?>
            </tbody>

              </table>
    
            </div>
          </div>
    </div>
  </main>

<?php
  require "../layout/tail.php";
} else {
  echo outmsg(LOGIN_NEED);
  header('Location: ../index.php');
}
?>