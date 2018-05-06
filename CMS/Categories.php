
<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>
<?php Confirm_Login(); ?>

<?php 

// submit post and store the post in category variable
# isset — Determine if a variable is set and is not NULL
if (isset($_POST["Submit"])) {

	 $Category =($_POST["Category"]);

	 // show time of posting 
	 date_default_timezone_set("Asia/Dhaka");
  	 $Currenttime = time();
     $Datetime = strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
     $Datetime;
     $Admin = $_SESSION["User_Id"];


         	/*if (mysqli_connect_errno()) {

  echo "Failed to connect to MySQL: " . mysqli_connect_error();

}*/

     // set a validation
      if (empty($Category)) {
     	# code...
     	# $_SESSION--An associative array containing session variables available to the current script.
     	$_SESSION["ErrorMessage"] = "All fields must be filled out";
     	Redirect_to("categories.php");
     } 



     elseif (strlen($Category)>99) {
     	# code...
     	$_SESSION["ErrorMessage"] = "TOO LONG NAME";
     	Redirect_to("categories.php");
     }

     

 
else{

	$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error());
	# $Query is the sql statement
     	$Query= "INSERT INTO category (datetime, name, creatorname)    VALUES ('$Datetime','$Category','$Admin')";
     	$Execute = mysqli_query($Connection,$Query);
     	/*
$connetion_name=mysqli_connect("localhost","root","","web_table") or die(mysqli_error());
$sql_statement="INSERT INTO web_formitem (ID, formID, caption, key, sortorder, type, enabled, mandatory, data) VALUES (105, 7, Tip izdelka (6), producttype_6, 42, 5, 1, 0, 0)";
mysqli_query($connection_name,$sql_statement);*/

        if ($Execute) {
     		# code...
     		$_SESSION["SuccessMessage"]="Categorie Added Successfully";
     		Redirect_to("categories.php");
     	}
     	else{
     		$_SESSION["ErrorMessage"]="Categorie failed to Add";
     		Redirect_to("categories.php");
     	} 
     }
    
}


 ?>



<!DOCTYPE>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Dashboard</title>

	
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
					<li class="nav-item"><a href="Dashboard.php"> <i class="fab fa-dashcube"></i> Dashboard</a></li>
					<br>
					<li class="nav-item"><a href="AddNewPost.php"><i class="fas fa-plus-square"></i> Add new post</a></li>
					<br>
					<li class="nav-item  active"><a href="Categories.php"><i class="fas fa-hourglass-half"></i> Categories</a></li>
					<br>
					<li class="nav-item"><a href="Comments.php"><i class="fas fa-comments"></i>Comments</a></li>
					<br>
					<li class="nav-item"><a href="Admin.php"><i class="fas fa-address-card"></i>  Manage Admin</a></li>
					<br>
					<li class="nav-item"><a href="Index.php"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
					<br>
					<li class="nav-item"><a href="Logout.php"><i class="fab fa-blogger-b"></i> Log Out</a></li>
				</ul>
				</div> <!-- end of col sm 2 -->
			<div class="col-sm-10">
				<h1>Manage Categories</h1>

				<?php
					 echo Message();
					 echo SuccessMessage();
				?>
				<div>
					<!-- Create a form with  post Method for category and post -->
					<form action="categories.php" method="post">
						<fieldset>
							<div class="form-group">
								<label for="categoryname"> <span class="FieldInfo">Name:</span></label>
							    <input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
							</div>
							<input class="btn btn-primary" type="Submit" name="Submit" value="Add New Category">
						</fieldset>
					</form>
				</div> <!-- END OF DIV FORM-->
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>Sr No.</th>
							<th>Date Time</th>
							<th>Category Name</th>
							<th>Creator Name</th>
							<th>Action</th>
						</tr>

						<?php 

						$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error());
						$ViewQuery = "SELECT *FROM category ORDER BY datetime desc";
						$Execute = mysqli_query($Connection,$ViewQuery);
						$SrNo = 0;
						while ($DataRows = mysqli_fetch_array($Execute)) {
							# code...
							$Id = $DataRows["id"];
							$Datetime = $DataRows["datetime"];
							$CategoryName = $DataRows["name"];
							$CreatorName = $DataRows["creatorname"];
							$SrNo++;

						

						 ?>

						 <tr>
						 	<td> <?php echo $SrNo; ?></td>
						 	<td> <?php echo $Datetime; ?></td>
						 	<td> <?php echo $CategoryName; ?></td>
						 	<td> <?php echo $CreatorName; ?></td>
						 	<td><a href="DeleteCategory.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>

						 </tr>

						 <?php } ?>




					</table>
				</div>
				

			</div> <!-- end of col sm 10 -->
		</div> <!-- end of row -->
	</div> <!-- end of col container -->

	


</body>
</html>