<?php 
require_once("include/Session.php"); 
?>
<?php 
require_once("include/Function.php"); 
?>

 

<?php 

if (isset($_GET["id"])) {
	$IdFromURL = $_GET["id"];
	 $Connection = mysqli_connect("localhost","root","","phpcms");
	 $QueryStatement = "DELETE FROM registration WHERE id = '$IdFromURL'";
	 $Execute = mysqli_query($Connection,$QueryStatement);
	 if ($Execute) {
	 	$_SESSION["SuccessMessage"] = "Admin Deleted Successfully";
	 	Redirect_to("Admin.php");
	 }else{
	 	$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
	 	Redirect_to("Admin.php");
	 }

}


 ?>