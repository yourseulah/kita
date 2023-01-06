<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["userip"]);
    setcookie("username", "");
    setcookie("passwd", "");
    header("Location: ../index.php");
?>