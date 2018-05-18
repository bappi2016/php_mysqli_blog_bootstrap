<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>
<?php 
$_SESSION["User_Id"] = null;

session_destroy();
Redirect_to("Login.php");

 ?>