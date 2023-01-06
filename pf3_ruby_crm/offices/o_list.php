<!--
  프로젝트명 : Customer Management / CRM 미니 버전
  파일명 : o_list.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-07
  업데이트일자 : 2022-02-07

  기능:
  테이블 생성과 동시에 입력한 office 데이터값을 
  보여주는 페이지
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
      <h1 class="mt-4">Office List</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Table</li>
      </ol>

      <!-- Office List Table -->
      <?php
      // offices table
      $sql = "SELECT * FROM offices ORDER BY officeCode DESC ";
      $resultset = $conn->query($sql);
      ?>

      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Office List
        </div>
        <div class="card-body">
          <table id="datatablesSimple">
            <thead>
              <tr>
                <th>Office Code</th>
                <th>City</th>
                <th>Phone</th>
                <th>Address</th>
                <th>State</th>
                <th>Country</th>
                <th>PostalCode</th>
                <th>Territory</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (true) {
                while ($row = $resultset->fetch_assoc()) {
              ?>
                  <tr>
                    <td><a><?= $row['officeCode'] ?></a></td>
                    <td><?= $row['city']?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['addressLine1'] ." ". $row['addressLine2'] ?></td>
                    <td><?= $row['state'] ?></td>
                    <td><?= $row['country'] ?></td>
                    <td><?= $row['postalCode'] ?></td>
                    <td><?= $row['territory'] ?></td>
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