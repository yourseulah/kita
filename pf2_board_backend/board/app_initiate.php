<!-- 
  파일명 : app_initiate.php
  최초작업자 : Seulah Lee
  최초작성일자 : 2022-01-04
  업데이트일자 : 2022-01-04
  
  기능: 
  board app의 사용자 등록을 위한 users 테이블을 생성한다.
  이 코드는 납품시 최초 1 회 실행하며, 현재 버전은 백업에 대한 고려는 하지 않았다.
-->

<?php
require "../util/dbconfig.php";

// 기존 테이블이 있으면 삭제하고 새롭게 생성하도록 질의 구성
// 질의 실행과 동시에 실행 결과에 따라 메시지 출력
$sql = "DROP TABLE IF EXISTS board";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPTBL_SUCCESS);
}

// 1. 게시판용 테이블 생성
// 데이터베이스명과 사용자명에 더 많은 유연성을 부여하며
// 테이블 생성시 데이터베이스 이름을 붙이는 부분을 생략함!!
// $sql = "CREATE TABLE `toymembership`.`users` (
// b_username 은 UNIQUE 로 되어 있으면 안된다. 한 b_username당 여러글을 쓸수도 있으니까
$sql = "CREATE TABLE `board` (
    `id` INT NOT NULL AUTO_INCREMENT , 
    `b_username` VARCHAR(20) NOT NULL COMMENT 'default for now' , 
    `title` VARCHAR(50) NOT NULL COMMENT 'board title' , 
    `contents` TEXT NOT NULL COMMENT 'board contents' , 
    `writtendate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'first written date' , 
    `lastdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last updated date' ,  
    `viewcnt` INT NOT NULL DEFAULT 0 COMMENT 'view count' ,
    `likecnt` INT NOT NULL DEFAULT 0 COMMENT 'like count' ,
    `cmtcnt` INT NOT NULL DEFAULT 0 COMMENT 'comment count' ,
    `uploadfiles` VARCHAR(200) NULL COMMENT 'uploaded img',
    PRIMARY KEY (`id`) 
    ) 
    ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci";

// 위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}

// 2. 댓글용 테이블 생성
$sql = "CREATE TABLE `comment` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `board_id` int(11) NOT NULL COMMENT 'board 테이블 외래참조키',
      `c_username` varchar(20) NOT NULL,
      `contents` varchar(600) NOT NULL, 
      `writtendate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'written date',
      `likecnt` INT NOT NULL DEFAULT 0 COMMENT 'like count' ,
      PRIMARY KEY (`id`),
      FOREIGN KEY (`board_id`) REFERENCES `board` (`id`) ON DELETE CASCADE
    )
    ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci";

// 위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}

if(DBG) {
  //리스트 pagination을 위한 모의 데이터 추가
  $rndnumber = rand(201, 550); //레코드의 갯수는 최소 201개에서 550개중에 랜덤 픽
  for($count=1; $count<=$rndnumber; $count++) {
    $b_username = "admin";
    $title = $count.'번게시글제목';
    $contents = $count.'번게시글의 내용입니다';
    $sql = "INSERT INTO board(b_username, title, contents) VALUES('".$b_username."', '".$title."', '".$contents."')";
    $conn ->query($sql);
  }
}

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 작업 실행 단계별 메시지 확인을 위해 Confrim and return to back하도록 수정함!!
// 백그라운드로 처리되도록 할 경우 위 코드로 대체 할 것!!
echo "<a href='../index.php'>Confirm and Return to back</a>";

?>