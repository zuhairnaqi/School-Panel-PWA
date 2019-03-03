<?php 
ob_start();
session_start();
require_once("../config.php");

unset($_SESSION['schooladmin']);
session_destroy();
header('location: '.BASE_URL.'admin/login.php');
?>