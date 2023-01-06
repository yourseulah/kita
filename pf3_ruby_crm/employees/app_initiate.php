<!-- 
  파일명 : app_initiate.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-26
  업데이트일자 : 2022-01-26
  
  기능: 
  employee table for employee register

  배운점 :
  에러발생시 디버깅 그리고 sql 관련해서는 phpAdmin에서 직접 query돌려보기
  html input types
-->

<?php
require "../util/dbconfig.php";

//drop table if exists
$sql = "DROP TABLE IF EXISTS employees";
if ($conn->query($sql) == TRUE) {
  if(DBG) echo outmsg(DROPTBL_SUCCESS);
}

//create table
$sql = "CREATE TABLE `employees` (
  `employeeNumber` INT(6) NOT NULL AUTO_INCREMENT , 
  `lastName` VARCHAR(30) NOT NULL COMMENT 'last name' ,
  `firstName` VARCHAR(30) NOT NULL COMMENT 'first name' , 
  `userName` VARCHAR(20) UNIQUE NOT NULL COMMENT 'username' , 
  `passwd` VARCHAR(256) NOT NULL COMMENT 'password' , 
  `cellphone` VARCHAR(13) NOT NULL COMMENT 'Emergency Contact Number' , 
  `extension` VARCHAR(10) NOT NULL COMMENT 'extension number' , 
  `email` VARCHAR(100) NOT NULL COMMENT 'email address' , 
  `birthDate` DATE NOT NULL COMMENT 'birthdate' , 
  `officeCode` VARCHAR(10) NOT NULL COMMENT 'office code' , 
  `reportsTo` VARCHAR(20) NOT NULL COMMENT 'reporting to',
  `jobTitle` varchar(50) NOT NULL COMMENT 'job position',
  `startDate` DATE NOT NULL COMMENT 'start date' , 
  `upload` VARCHAR(200) NULL COMMENT 'profile img',
  `registDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration date' ,
  `updateDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'updated date' , 
  PRIMARY KEY (`employeeNumber`),
  KEY `reportsTo` (`reportsTo`),
  KEY `officeCode` (`officeCode`),
  CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`officeCode`) REFERENCES `offices` (`officeCode`)
  ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'employee registration table';";

//execute query
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}

$sql = "alter table employees auto_increment=1001";
$conn->query($sql);

//return resource
$conn->close();

//direct to 
echo "<a href='../customer/app_initiate.php'>Confirm</a>";
?>



