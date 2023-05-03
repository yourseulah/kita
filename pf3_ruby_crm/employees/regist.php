<!-- 
  파일명 : user_regist.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-27
  업데이트일자 : 2022-01-27
  
  2022-01-27 : 이미지파일 업로드기능 추가 
  1. 파일이 업로드 될 폴더 img 생성 
  2. employees 테이블 생성하며 이미지 파일 이름을 보관하기 위한 필드 upload추가
  3. 파일처리를 위한 코드 추가/수정
  4. detailview.php 코드에서 첨부된 파일을 디스플레이 하기위한 코드 추가/수정
  5. update.php와 updateprocess.php 파일에서 첨부된 파일을 수정하기 위한 인터페이스와 수정처리 코드 추가 수정
  6. deleteprocess.php에서 레코드 삭제시 테이블의 레코드 뿐만 아니라 업로드용 디렉토리에 존재하는 파일도 삭제처리 코드 추가/수정
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <link rel="stylesheet" href="../css/regist_style.css">
</head>

<body>
  <div class="main">
    <div class="wrapper">
      <div class="logo"><a href="../index.php"><img src="../img/ruby.png" width="120" height="120" style="display: block;
        margin: 15px auto"></a></div>
      <div class="content">
        <form action="./regist_process.php" method="POST" enctype="multipart/form-data">
          <!-- !!!!enctype MUST : $_FILES 읽기위한!!! -->

          <div class="name">
            <input type="text" name="firstname" placeholder="First name" required />&nbsp;
            <input type="text" name="lastname" placeholder="Last name" required />
          </div>

          <input type="text" name="username" placeholder="Username" required />

          <div class="password">
            <input type="password" name="passwd" placeholder="Password" required />&nbsp;
            <input type="password" name="cpasswd" placeholder="Confirm" required />
          </div>

          <div class="phone">
            <input type="text" name="cellphone" placeholder="Cellphone" required />&nbsp;
            <input type="text" name="extension" placeholder="Ext." />
          </div>

          <!-- email hidden, insert in the table concatenating with username -->
          <label>Birth Date</label>
          <input type="date" name="birthdate" />
          <label>Start date</label>
          <input type="date" name="startdate" />

          <?php
          require "../util/dbconfig.php";
          $sql = "SELECT * FROM offices";
          $resultset = $conn->query($sql);
          if (!$resultset) {
            die("Error: " . $conn->error);
          }
          ?>

          <label>Profile</label>
          <input type="file" size="60" name="upload">

          <select name='officecode'>
            <option value="">Select Office</option>
            <?php
            while ($row = $resultset->fetch_assoc()) {
            ?>
              <option value="<?= $row['officeCode'] ?>"><?= $row['city'] ?></option>
            <?php } ?>
          </select>

          <input type="text" name="reportsto" placeholder="Report To" />
          <input type="text" name="jobtitle" placeholder="Job title" />

          <input type=submit value="Signup">
        </form>

      </div>
    </div>
  </div>

</body>

</html>