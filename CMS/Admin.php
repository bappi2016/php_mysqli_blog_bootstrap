
<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>
<?php Confirm_Login(); ?>

<?php 

// submit post and store the post in category variable
# isset — Determine if a variable is set and is not NULL
if (isset($_POST["Submit"])) {

	 $UserName =($_POST["Username"]);
	 $Password =($_POST["Password"]);
	 $Confirm_Password =($_POST["confirmpassword"]);

	 // show time of posting 
	 date_default_timezone_set("Asia/Dhaka");
  	 $Currenttime = time();
     $Datetime = strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
     $Datetime;
     $Admin = $_SESSION["User_Id"];
// set a validation
      if (empty($UserName) || empty($Password) || empty($Confirm_Password)) {
     	# code...
     	# $_SESSION--An associative array containing session variables available to the current script.
     	$_SESSION["ErrorMessage"] = "All fields must be filled out";
     	Redirect_to("Admin.php");
     } 

elseif (strlen($Password)<4) {
     	# code...
     	$_SESSION["ErrorMessage"] = "Password Should be at least 4 character";
     	Redirect_to("Admin.php");
     }elseif (strlen($Password!==$Confirm_Password)) {
     	# code...
     	$_SESSION["ErrorMessage"] = "Confirm Password did not Match ";
     	Redirect_to("Admin.php");
     }

else{

	$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error($Connection));
	# $Query is the sql statement
     	$Query= "INSERT INTO registration (datetime, username, password,addedby)    VALUES ('$Datetime','$UserName','$Password','$Admin')";
     	$Execute = mysqli_query($Connection,$Query);
 		if ($Execute) {
     		$_SESSION["SuccessMessage"]="Admin Added Successfully";
     		Redirect_to("Admin.php");
     	}
     	else{
     		$_SESSION["ErrorMessage"]="Failed to Add Admin, Try Again";
     		Redirect_to("Admin.php");
     	} 
     }
  }


 ?>



<!DOCTYPE>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Manage Admin</title>

	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="assets/bootstrap/js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/publicstyles.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	
</head>
<body>
	<div class="container-fluid">
		<div class="row">
				<div class="col-sm-2">
				<br><br>
				<ul class="nav nav-pills nav-stacked nav-justified" id="side_menu">
					<li class="nav-item"><a class="nav-link " href="Dashboard.php"> <i class="fab fa-dashcube"></i> Dashboard</a></li>
					<br>
					<li class="nav-item"><a href="AddNewPost.php"><i class="fas fa-plus-square"></i> Add new post</a></li>
					<br>
					<li class="nav-item"><a href="categories.php"><i class="fas fa-hourglass-half"></i> Categories</a></li>
					<br>
					<li class="nav-item"><a href="Comments.php"><i class="fas fa-comments"></i>  Comments</a></li>
					<br>
					<li class="nav-item active"><a href="Admin.php"><i class="fas fa-address-card"></i>Manage Admin</a></li>
					<br>
					<li class="nav-item"><a href="Index.php"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
					<br>
					<li class="nav-item"><a href="Logout.php"><i class="fab fa-blogger-b"></i> Log Out</a></li>
				</ul>
				</div> <!-- end of col sm 2 -->
			<div class="col-sm-10">
				<h1>Manage Admin Access</h1>

				<?php
					 echo Message();
					 echo SuccessMessage();
				?>
				<div>
					<!-- Create a form with  post Method for category and post -->
					<form action="Admin.php" method="post">
						<fieldset>
							<div class="form-group">
								<label for="Username"> <span class="FieldInfo">UserName:</span></label>
							    <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
							</div>

							<div class="form-group">
								<label for="Password"> <span class="FieldInfo">Password:</span></label>
							    <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
							</div>

							<div class="form-group">
								<label for="confirmpassword"> <span class="FieldInfo">Confirm Password:</span></label>
							    <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" placeholder="Retype Same password">
							</div>
							<input class="btn btn-primary" type="Submit" name="Submit" value="Add New Admin">
						</fieldset>
					</form>
				</div> <!-- END OF DIV FORM-->
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>Sr No.</th>
							<th>Date Time</th>
							<th>Admin Name</th>
							<th>Added By</th>
							<th>Action</th>
						</tr>

						<?php 

						$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error($Connection));
						$ViewQuery = "SELECT *FROM registration ORDER BY datetime desc";
						$Execute = mysqli_query($Connection,$ViewQuery);
						$SrNo = 0;
						while ($DataRows = mysqli_fetch_array($Execute)) {
							# code...
							$Id = $DataRows["id"];
							$Datetime = $DataRows["datetime"];
							$AdminName = $DataRows["username"];
							$AddedBy = $DataRows["addedby"];
							$SrNo++;

						?>

						 <tr>
						 	<td> <?php echo $SrNo; ?></td>
						 	<td> <?php echo $Datetime; ?></td>
						 	<td> <?php echo $AdminName; ?></td>
						 	<td> <?php echo $AddedBy; ?></td>
						 	<td><a href="DeleteAdmin.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>

						 </tr>

						 <?php } ?>
					</table>
				</div>
				

			</div> <!-- end of col sm 10 -->
		</div> <!-- end of row -->
	</div> <!-- end of col container -->

	


</body>
</html>