
<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>

<?php 

// submit post and store the post in category variable
# isset — Determine if a variable is set and is not NULL
if (isset($_POST["Submit"])) {

	 $Title =($_POST["Title"]);
	 $Category =($_POST["Category"]);
	 $Post =($_POST["Post"]);

	 // show time of posting 
	 date_default_timezone_set("Asia/Dhaka");
  	 $Currenttime = time();
     $Datetime = strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
     $Datetime;
     $Admin = "Ajama Aamir";
     $Image = $_FILES["Image"]["name"];
     $Target = "UPLOAD/".basename($_FILES["Image"]["name"]);


         	/*if (mysqli_connect_errno()) {

  echo "Failed to connect to MySQL: " . mysqli_connect_error();

}*/

     // set a validation
      if (empty($Title)) {
     	# code...
     	# $_SESSION--An associative array containing session variables available to the current script.
     	$_SESSION["ErrorMessage"] = "Title can't be empty";
     	Redirect_to("AddNewPost.php");
     } 



     elseif (strlen($Title)<2) {
     	# code...
     	$_SESSION["ErrorMessage"] = "Title Should be At least 2 character";
     	Redirect_to("AddNewPost.php");
     }

     

 
else{

	$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error);
	$EditFromURL = $_GET['Edit'];
		# $Query is the sql statement
     	$Query= "UPDATE admin_panel SET datetime='$Datetime', title='$Title', category='$Category',author='$Admin', image='$Image',post='$Post' WHERE id='$EditFromURL' ";

     	$Execute = mysqli_query($Connection,$Query);
     	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
     	/*
$connetion_name=mysqli_connect("localhost","root","","web_table") or die(mysqli_error());
$sql_statement="INSERT INTO web_formitem (ID, formID, caption, key, sortorder, type, enabled, mandatory, data) VALUES (105, 7, Tip izdelka (6), producttype_6, 42, 5, 1, 0, 0)";
mysqli_query($connection_name,$sql_statement);*/

        if ($Execute) {
     		# code...
     		$_SESSION["SuccessMessage"]="Post Updated Successfully";
     		Redirect_to("dashboard.php");
     	}
     	else{
     		$_SESSION["ErrorMessage"]="Failed to Update post, try again";
     		Redirect_to("dashboard.php");
     	} 
     }
    
}


 ?>



<!DOCTYPE>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit Post</title>

	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/bootstrap/js/jquery.js"></script>

	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/adminstyle.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<h1>AJMAL AAMIR</h1>
				<ul class="nav nav-pills nav-stacked nav-justified flex-sm-column" id="side_menu">
					<li class="nav-item"><a href="dashboard.php"> <i class="fab fa-dashcube"></i> Dashboard</a></li>
					<li class="nav-item"><a href="AddNewPost.php"><i class="fas fa-plus-square"></i> Add new post</a></li>
					<li class="nav-item"><a class="nav-link active" href="categories.php"><i class="fas fa-hourglass-half"></i> Categories</a></li>
					<li class="nav-item"><a href="#"><i class="fas fa-comments"></i>  Comments</a></li>
					<li class="nav-item"><a href="#"><i class="fas fa-address-card"></i>  Manage Admin</a></li>
					<li class="nav-item"><a href="#"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
				</ul>
				</div> <!-- end of col sm 2 -->
			<div class="col-sm-10">
				<h1>Update Post</h1>

				<?php
					 echo Message();
					 echo SuccessMessage();
				?>
				<div>
					<?php 
					$SearchQueryParameter = $_GET['Edit'];
					$Connection = mysqli_connect("localhost","root","","phpcms");
					$Query = "SELECT * FROM admin_panel WHERE id = '$SearchQueryParameter'";
					$ExecuteQuery = mysqli_query($Connection,$Query);
					while ($DataRows=mysqli_fetch_array($ExecuteQuery)) {
						$TitleToBeUpdated = $DataRows['title'];
						$CategoryToBeUpdated = $DataRows['category'];
						$ImageToBeUpdated = $DataRows['image'];
						$PostToBeUpdated = $DataRows['post'];
					}

					 ?>







					<!-- Create a form with  post Method for category and post -->
					<form action="EditPost.php?Edit=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="title"> <span class="FieldInfo">Title:</span></label>
							    <input value="<?php echo $TitleToBeUpdated ?>" class="form-control" type="text" name="Title" id="title" placeholder="Title">
							</div>
							<!--div for selecting category and  fetch data form database-->
							<div class="form-group">  <!-- starting select category section-->
								<span class="FieldInfo">Existing Category: </span>
								<?php echo $CategoryToBeUpdated;?>
								<br>
								<label for="categoryselect"> <span class="FieldInfo">Category:</span></label>
							    <select class="form-control" id="categoryselect" name="Category">
							    	<?php 

						$Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error());
						$ViewQuery = "SELECT *FROM category ORDER BY datetime desc";
						$Execute = mysqli_query($Connection,$ViewQuery);
						while ($DataRows = mysqli_fetch_array($Execute)) {
							# code...
							$Id = $DataRows["id"];
							$CategoryName = $DataRows["name"];
							?>

							<option> <?php echo $CategoryName; ?></option>
							<?php } ?>
							    </select> 
							</div> <!-- Ending select category section-->

							<div class="form-group">
								<span class="FieldInfo">Existing Image: </span>
								<img src="UPLOAD/<?php echo $ImageToBeUpdated;?>" width=200px; height = 80px;>
								<br>
								<label for="imageselect"> <span class="FieldInfo">Select Image:</span></label>
							    <input class="form-control" type="File" name="Image" id="imageselect">
							</div>

							<div class="form-group">
								<label for="postarea"> <span class="FieldInfo">Post:</span></label>
							    <textarea class="form-control" type="text" name="Post" id="postarea">
							    	<?php echo $PostToBeUpdated; ?>
							    </textarea> 
							</div>

							<br>
							<input class="btn btn-primary" type="Submit" name="Submit" value="Update Post">
						</fieldset>
					</form>
				</div> <!-- END OF DIV FORM-->
				

						


				
				

			</div> <!-- end of col sm 10 -->
		</div> <!-- end of row -->
	</div> <!-- end of col container -->




</body>
</html>