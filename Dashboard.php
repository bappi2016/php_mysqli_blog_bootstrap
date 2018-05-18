<?php 
require_once("include/Session.php"); 

$Connection = mysqli_connect("localhost","root","","phpcms");
?>
<?php 
require_once("include/Function.php"); 
?>

<?php Confirm_Login(); ?>

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
			<div class="col-sm-2">  <!-- starting left side bar for admin dashboard -->
				<br><br>
				<ul class="nav nav-justified nav-stacked">
					<li class="nav-item active"><a href="Dashboard.php"> <i class="fab fa-dashcube"></i> Dashboard</a></li>
					<br>
					<li class="nav-item"><a href="AddNewPost.php"><i class="fas fa-plus-square"></i> Add new post</a></li>
					<br>
					<li class="nav-item"><a href="Categories.php"><i class="fas fa-hourglass-half"></i> Categories</a></li>
					<br>
					<li class="nav-item"><a href="Comments.php"><i class="fas fa-comments"></i>  Comments

					<?php 
					# Here we shows the number of unapproved comments in a small badge for admin notification 

		 			global $Connection; 
		 			// Check connection
					if (mysqli_connect_errno())
					  {
					  echo "Failed to connect to MySQL: " . mysqli_connect_error();
					  }
		 			$Query_Total_UnApproved = "SELECT COUNT(*) FROM comments WHERE status = 'OFF'";
		 			$ExecuteQuery = mysqli_query($Connection,$Query_Total_UnApproved);
		 			#The mysqli_fetch_array() function fetches a result row as an associative array, a numeric array, or both.
		 			$RowsUnApproved = mysqli_fetch_array($ExecuteQuery);
		 			$TotalUnApproved = array_shift($RowsUnApproved);
					if ($TotalUnApproved>0) {
		 				?>
					<span class="label label-warning pull-right">  <?php echo $TotalUnApproved; ?></span>
		 			<?php }  ?>

			 		</a></li>
					<br>
					<li class="nav-item"><a href="Admin.php"><i class="fas fa-address-card"></i>  Manage Admin</a></li>
					<br>
					<li class="nav-item"><a href="Index.php"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
					<br>
					<li class="nav-item"><a href="Logout.php"><i class="fab fa-blogger-b"></i> Log Out</a></li>
				</ul>
				</div> <!-- End of Admin LEft sidebar -->


			<div class="col-sm-10"> <!-- Strart  of Admin Main section to see the Blog post -->

				<div> 
					<?php
					 echo Message();
					 echo SuccessMessage();
					?> 
				</div>
				
				<h1>ADMIN DASHBOARD</h1>

				<div class="table-responsive"> <!--Start the table div for admin content-->
					<table class="table table-striped table-hover"> <!--Start the table tag for admin content-->
						<tr>
							<th>No</th>
							<th>Date Time</th>
							<th>Post Title</th>
							<th>Author</th>
							<th>Category</th>
							<th>Banner</th>
							<th>Comments</th>
							<th>Action</th>
							<th>Details</th>
						</tr>

				<?php 
				# First set the database connection with specific table name which is admin_panel and set the query to fetch the all stoded information SELECT (*) with ORDER BY CLUSE id which is a table entity or row

				global $Connection; 
				$ViewQuery = "SELECT * FROM admin_panel ORDER BY id desc;";
				$Execute = mysqli_query($Connection,$ViewQuery);
            	$SrNo = 0;
				// iterate a loop to grab the data stored in the database
				while ($DataRows=mysqli_fetch_array($Execute)) {
			 	# code...
			 	$Id = $DataRows["id"];
			 	$Datetime = $DataRows["datetime"];
			 	$Title = $DataRows["title"];
			 	$Admin = $DataRows["author"];
			 	$Category = $DataRows["category"];
			 	$Image = $DataRows["image"];
			 	$Post = $DataRows["post"];
			 	$SrNo++;
			 	?>
			 	<tr> <!--Start the main visible area or  body of admin Section that is table row-->
			 		<td><?php echo $SrNo; ?></td>
			 		<td>
			 		<?php 
			 		if (strlen($Datetime)>11) {$Datetime=substr($Datetime,0,11)."..";}
			 		echo $Datetime; ?>
			 		</td>
			 		<td>
			 		<?php
			 		if (strlen($Title)>20) {$Title=substr($Title,0,20)."..";}
					echo $Title; ?>
						
					</td>
			 		<td>
			 		<?php 
			 		if (strlen($Admin)>6) {$Admin=substr($Admin,0,6)."..";}
					echo $Admin; ?>
						
					</td>
			 		<td>
			 		<?php
			 		if (strlen($Category)>8) {$Category=substr($Category,0,8)."..";}
			 		echo $Category; ?>
			 			
			 		</td>
			 		<td><img class="img-responsive img-fluid" src="UPLOAD/<?php echo $Image; ?>" width = "200px"; height="40px"></td>

			 		<td><!--Start of Comment Processing Section-->

			 			<?php 
			 			# For Total Approved Comments that is status = on

			 			global $Connection;
			 			$QueryApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'ON'";
			 			$ExecuteQuery = mysqli_query($Connection,$QueryApproved);
			 			$RowsApproved = mysqli_fetch_array($ExecuteQuery);
			 			$TotalApproved = array_shift($RowsApproved);

			 			if ($TotalApproved>0) {
			 				?>
						
						<span class="label label-success pull-right">  <?php echo $TotalApproved; ?></span>
			 				
			 			<?php }  ?>


			 			<?php 
			 			# For Total Approved Comments that is status = off

			 			global $Connection;
			 			$QueryUnApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'OFF'";
			 			$ExecuteQuery = mysqli_query($Connection,$QueryUnApproved) or die(mysqli_error($Connection));
			 			$RowsUnApproved = mysqli_fetch_array($ExecuteQuery);
			 			$TotalUnApproved = array_shift($RowsUnApproved);

			 			if ($TotalUnApproved>0) {
			 				?>
						
						<span class="label label-warning pull-left">  <?php echo $TotalUnApproved; ?></span>
			 				
			 			<?php }  ?>
			 		</td><!--Ending of Comment Processing Section-->

			 		<td>
			 			<a href="EditPost.php?Edit=<?php echo $Id; ?>">
			 				<span class="btn btn-warning btn-sm">Edit</span>
			 			</a>
			 			<a href="DeletePost.php?Delete=<?php echo $Id; ?>">
			 				<span class="btn btn-danger btn-sm">Delete</span>
			 			</a>
			 		</td>

			 		<td>
			 			<a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank" >
			 				<span class="btn btn-primary btn-sm">Live Preview</span>
			 			</a>
			 		</td>

			 	</tr> <!--Ending the main visible area of admin Section that is table row-->
			 	<?php } ?>



					</table>
				</div><!--Ending the table div for admin content-->


			</div> <!-- end of col sm 10 -->
		</div> <!-- end of row -->

<div>
	<?php include "Footer.php"; ?>
</div>

	</div> <!-- end of col container -->

	


</body>
</html>