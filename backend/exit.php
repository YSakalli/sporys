<?php
session_start();
$_SESSION = array();
setcookie("id", "", time() - 3600, "/");
session_destroy();
header("Location:../login.php");
?>