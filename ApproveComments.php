<?php 
require_once("include/Session.php"); 
?>
<?php 
require_once("include/Function.php"); 
?>
<?php Confirm_Login(); ?>

 

<?php 

if (isset($_GET["id"])) {
	$IdFromURL = $_GET["id"];
	 $Connection = mysqli_connect("localhost","root","","phpcms");
	 $Admin = $_SESSION["User_Id"];
	 $QueryStatement = "UPDATE comments SET status = 'ON', approvedby = '$Admin' WHERE id = '$IdFromURL'";
	 $Execute = mysqli_query($Connection,$QueryStatement);
	 
	 if ($Execute) {
	 	$_SESSION["SuccessMessage"] = "Comment Approved Successfully";
	 	Redirect_to("Comments.php");
	 }else{
	 	$_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
	 	Redirect_to("Comments.php");
	 }

}


 ?>