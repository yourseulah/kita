<?php

//login_process.php 에서 생성한 세션변수가 존재하는지 확인 
  session_start();
  if(isset($_SESSION['username'])) {
    $chk_login = TRUE;
  }else { 
    $chk_login = FALSE;
  }
?>