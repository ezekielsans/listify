<?php
error_reporting(E_ALL);
session_start();
$_SESSION =[];
session_destroy();

header("Location: ../components/Login/login.php ");
exit;

?>