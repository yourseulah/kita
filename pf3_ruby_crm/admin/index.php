<?php
$target = "localhost";
//EC2(AWS), localhost, dothome
if ($target == "dothome") {
  header('Location: ../offices/app_initiate.php');
} else {
  header('Location: ./site_initiate.php');
}
