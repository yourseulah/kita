<!-- 
  파일명 : app_initiate.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-27
  업데이트일자 : 2022-01-27
  
  기능: 
  office table 

  궁금증:
  birthdate, start type을 어떻게 지정해야하는지 
-->

<?php
require "../util/dbconfig.php";

//drop table if exists
$sql = "DROP TABLE IF EXISTS offices";
if ($conn->query($sql) == TRUE) {
  if(DBG) echo outmsg(DROPTBL_SUCCESS);
}

//create table
$sql = "CREATE TABLE `offices` (
  `officeCode` varchar(10) NOT NULL , 
  `city` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `addressLine1` varchar(50) NOT NULL,
  `addressLine2` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `postalCode` varchar(15) NOT NULL,
  `territory` varchar(10) NOT NULL,
  PRIMARY KEY (`officeCode`)
  ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'office table';";

//execute query
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}

//data for the table `offices`
$sql = "INSERT INTO `offices`(`officeCode`, `city`,`phone`,`addressLine1`,`addressLine2`,`state`,`country`,`postalCode`,`territory`) values 

('SEL', 'Seoul', '+1 02 219 4782','142, Teheran-ro, Gangnam-gu','Suite 300','NA','KOREA','06236','NA'),

('JKF', 'New York', '+1 212 555 3000','523 East 53rd Street','apt. 5A','NY','USA','10022','NA'),

('SFO', 'San Francisco','+1 650 219 4782','100 Market Street','Suite 300','CA','USA','94080','NA'),

('SYD', 'Sydney','+61 2 9264 2451','5-11 Wentworth Avenue','Floor #2',NULL,'Australia','NSW 2010','APAC'),

('LHR', 'London','+44 20 7877 2041','25 Old Broad Street','Level 7',NULL,'UK','EC2N 1HN','EMEA');";

//execute query
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(INSERT_SUCCESS);
} else {
  echo outmsg(INSERT_FAIL);
}

//return resource
$conn->close();

//direct to 
echo "<a href='../employees/app_initiate.php'>Confirm</a>";
?>



