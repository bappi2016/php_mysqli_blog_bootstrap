
<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>
<?php Confirm_Login(); ?>

<?php 

// submit post and store the post in category variable
# isset — Determine if a variable is set and is not NULL ... when admin press the submit option then this section will active
if (isset($_POST["Submit"])) {
	# Number of post method equal to number of post option that is title category and post and submit
	# $Variable name = ($_POST "the super global variable for Post method"["exact field name in the name tag"]
	 $Title =($_POST["Title"]);
	 $Category =($_POST["Category"]);
	 $Post =($_POST["Post"]);

	 // show time of posting 
	 date_default_timezone_set("Asia/Dhaka");
  	 $Currenttime = time();
     $Datetime = strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
     $Datetime;
     $Admin = $_SESSION["User_Id"];
     $Image = $_FILES["Image"]["name"];
     $Target = "UPLOAD/".basename($_FILES["Image"]["name"]);


     // set a validation
      if (empty($Title)) {
     	# $_SESSION--An associative array containing session variables available to the current script.
     	$_SESSION["ErrorMessage"] = "Title can't be empty";
     	Redirect_to("AddNewPost.php");
     } 
		elseif (strlen($Title)<2) {
     	$_SESSION["ErrorMessage"] = "Title Should be At least 2 character";
     	Redirect_to("AddNewPost.php");
     }

   else{

	$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error($Connection));
	# $Query is the sql statement
	#$sql_statement = "INSERT INTO table_name (table row, table row) VALUES ('$Variable name with stored info')";
     	$Query= "INSERT INTO admin_panel (datetime,title,category,author,image,post) VALUES ('$Datetime','$Title','$Category','$Admin','$Image','$Post')";
     	$Execute = mysqli_query($Connection,$Query);
     	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
     	/*
$connetion_name=mysqli_connect("localhost","root","","web_table") or die(mysqli_error());
mysqli_query($connection_name,$sql_statement);*/

        if ($Execute) {
     		$_SESSION["SuccessMessage"]="Post Added Successfully";
     		Redirect_to("AddNewPost.php");
     	}
     	else{
     		$_SESSION["ErrorMessage"]="Failed to add post, try again";
     		Redirect_to("AddNewPost.php");
     	} 
     }
    
}# End od isset if statement


 ?>



<!DOCTYPE>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Add New Post</title>

	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="assets/bootstrap/js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/publicstyles.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	
</head>
<body>
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-2"> <!-- starting left side bar for admin dashboard -->
				<br><br>
				<ul class="nav nav-pills nav-stacked nav-justified flex-sm-column" id="side_menu">
					<li class="nav-item"><a class="nav-link" href="Dashboard.php"> <i class="fab fa-dashcube"></i> Dashboard</a></li>
					<br>
					<li class="nav-item  active"><a href="#"><i class="fas fa-plus-square"></i> Add new post</a></li>
					<br>
					<li class="nav-item"><a href="categories.php"><i class="fas fa-hourglass-half"></i> Categories</a></li>
					<br>
					<li class="nav-item"><a href="Comments.php"><i class="fas fa-comments"></i>  Comments</a></li>
					<br>
					<li class="nav-item"><a href="Admin.php"><i class="fas fa-address-card"></i>  Manage Admin</a></li>
					<br>
					<li class="nav-item"><a href="Index.php"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
					<br>
					<li class="nav-item"><a href="Logout.php"><i class="fab fa-blogger-b"></i> Log Out</a></li>

				</ul>
				</div>  <!-- Ending left side bar for admin dashboard -->

			<div class="col-sm-10">  <!-- starting add new post for admin dashboard -->
				<h1>Add New Post</h1>

				<?php
					 echo Message();
					 echo SuccessMessage();
				?>
				<div> <!--ADD NEW POST FORM-->
					<!-- Create a form with  post Method for category and post -->
					<form action="AddNewPost.php" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="title"> <span class="FieldInfo">Title:</span></label>
							    <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
							</div>
							<!--div for selecting category and  fetch data form database-->
							<div class="form-group">  <!-- starting select category section-->
								<label for="categoryselect"> <span class="FieldInfo">Category:</span></label>
							    <select class="form-control" id="categoryselect" name="Category">
					<?php 

						$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error());
						$ViewQuery = "SELECT *FROM category ORDER BY id desc";
						$Execute = mysqli_query($Connection,$ViewQuery);
						# here to show the all existing category we fetch the database and show the name to admin with a loop
						while ($DataRows = mysqli_fetch_array($Execute)) {
							$Id = $DataRows["id"];
							$CategoryName = $DataRows["name"];
							?>
							<option> <?php echo $CategoryName; ?></option>
							<?php } ?>
							    </select> 
							</div> <!-- Ending select category section-->

							<div class="form-group">
								<label for="imageselect"> <span class="FieldInfo">Select Image:</span></label>
							    <input class="form-control" type="File" name="Image" id="imageselect">
							</div>

							<div class="form-group">
								<label for="postarea"> <span class="FieldInfo">Post:</span></label>
							    <textarea class="form-control" type="text" name="Post" id="postarea"></textarea> 
							</div>

							<br>
							<input class="btn btn-primary" type="Submit" name="Submit" value="Add New Post">
						</fieldset>
					</form>
				</div> <!-- END OF DIV FORM-->
				

			</div> <!-- end of col sm 10 -->
		</div> <!-- end of row -->
	</div> <!-- end of col container -->

	


</body>
</html>