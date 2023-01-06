<?php
$target = "EC2";
//EC2(AWS), localhost, dothome
  if ($target == "dothome") {
    header('Location: ../membership/app_initiate.php'); 
  } else {
  header('Location: site_initiate.php');
  }
?>