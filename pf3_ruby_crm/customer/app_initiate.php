<!-- 
  파일명 : app_initiate.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-02-04
  업데이트일자 : 2022-02-04
  
  기능: 
  customer table 생성
-->

<?php
require "../util/dbconfig.php";

//drop table if exists
$sql = "DROP TABLE IF EXISTS customer";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPTBL_SUCCESS);
}

//create table
$sql = "CREATE TABLE `customers` (
  `customerNumber` int(6) NOT NULL AUTO_INCREMENT,
  `customerName` varchar(50) NOT NULL,
  `contactLastName` varchar(50) NOT NULL,
  `contactFirstName` varchar(50) NOT NULL,
  `jobTitle` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL, 
  `addressLine1` varchar(50) NOT NULL,
  `addressLine2` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postalCode` varchar(15) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `salesRepEmployeeNumber` int(6) DEFAULT NULL,
  `creditTerm` varchar(50) DEFAULT NULL,
  `creditLimit` decimal(10,2) DEFAULT NULL,
  `upload` VARCHAR(200) NULL COMMENT 'profile img',
  `registDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration date' ,
  `updateDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'updated date' , 
  PRIMARY KEY (`customerNumber`),
  KEY `salesRepEmployeeNumber` (`salesRepEmployeeNumber`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`salesRepEmployeeNumber`) REFERENCES `employees` (`employeeNumber`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE utf8_general_ci";

//execute query
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}

$sql = "alter table customers auto_increment=101";
$conn->query($sql);

//return resource
$conn->close();

//direct to
echo "<a href='../index.php'>Customer Table Created Confirm</a>";
?>