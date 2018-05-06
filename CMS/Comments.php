<?php 
require_once("include/Session.php"); 
?>
<?php 
require_once("include/Function.php"); 
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
					<li class="nav-item"><a href="Categories.php"><i class="fas fa-hourglass-half"></i> Categories</a></li>
					<br>
					<li class="nav-item active"><a href="Comments.php"><i class="fas fa-comments"></i>  Comments</a></li>
					<br>
					<li class="nav-item"><a href="Admin.php"><i class="fas fa-address-card"></i>  Manage Admin</a></li>
					<br>
					<li class="nav-item"><a href="Index.php"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
					<br>
					<li class="nav-item"><a href="Logout.php"><i class="fab fa-blogger-b"></i> Log Out</a></li>
				</ul>
				</div> <!-- end of col sm 2 -->
			<div class="col-sm-10">

				<div> 
					<?php
					 echo Message();
					 echo SuccessMessage();
					?> 
				</div>
				
				<h1>Approved Comments</h1>

				<div class="table-responsive"> <!--Starting Approved Comments Table-->
					<table class="table table-striped table-hover">
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Date</th>
							<th>Comment</th>
							<th>Approved By</th>
							<th>Revert Approve</th>
							<th>Delete</th>
							<th>Details</th>
						</tr>

				<?php 
				$Connection = mysqli_connect('localhost','root','','phpcms');
				$Admin = $_SESSION["User_Id"];
				/*
				if (isset($_POST['id'])) { // If the id post variable is set
    			$dmid = $_POST['id'];
				} else { // If the id post variable is not set
    			$dmid = 1;
				}

				*/
                $PostIdFromComments = (isset($_GET['id']) ? $_GET['id'] : '');
                $ExtractingCommentsQuery = " SELECT * FROM comments WHERE status= 'ON'";
                $Execute = mysqli_query($Connection,$ExtractingCommentsQuery);
                $SrNo = 0;
                while ($FetchDataArray = mysqli_fetch_array($Execute)) {
                  $CommentsId = $FetchDataArray['id'];
                  $Commentor_Name = $FetchDataArray["name"];
                  $Date_Time_Of_Comments = $FetchDataArray["datetime"];
                  $Person_Comment = $FetchDataArray["comment"];
                  $ApprovedBy = $FetchDataArray["approvedby"];
                  $Commented_Post_Id = $FetchDataArray['admin_panel_id'];
                  $SrNo++;
                  if (strlen($Person_Comment)>18) {
                  	$Person_Comment = substr($Person_Comment, 0,18).'...';
                  }
                  if (strlen($Commentor_Name)>10) {
                  	$Commentor_Name = substr($Commentor_Name, 0,10).'...';
                  }
				  ?>

				  <tr>
				  	<td><?php echo htmlentities($SrNo); ?></td>
				  	<td><?php echo htmlentities($Commentor_Name) ; ?></td>
				  	<td><?php echo htmlentities($Date_Time_Of_Comments); ?></td>
				  	<td><?php echo htmlentities($Person_Comment) ; ?></td>
				  	<td><?php echo htmlentities($ApprovedBy) ; ?></td>
				  	<td><a href="DisApproveComments.php?id=<?php echo $CommentsId; ?>"><span class="btn btn-warning">Dis-Approve</span></a></td>
				  	<td><a href="DeleteComments.php?id=<?php echo $CommentsId; ?>"><span class="btn btn-danger">Delete</span></a></td>
				  	<td><a href="FullPost.php?id=<?php echo $Commented_Post_Id;?>"target ="_blank">
				  	<span class="btn btn-primary">Live Preview</span></a></td>
				  </tr>
						<?php } ?>

					</table>
				</div> <!--Ending Comments Table-->


				<h1>Un-Approved Comments</h1>

				<div class="table-responsive"> <!--Starting Un-approved Comments Table-->
					<table class="table table-striped table-hover">
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Date</th>
							<th>Comment</th>
							<th>Approve</th>
							<th>Delete</th>
							<th>Details</th>
						</tr>

				<?php 
				$Connection = mysqli_connect('localhost','root','','phpcms');
				/*
				if (isset($_POST['id'])) { // If the id post variable is set
    			$dmid = $_POST['id'];
				} else { // If the id post variable is not set
    			$dmid = 1;
				}

				*/
                $PostIdFromComments = (isset($_GET['id']) ? $_GET['id'] : '');
                $ExtractingCommentsQuery = " SELECT * FROM comments WHERE status= 'OFF'";
                $Execute = mysqli_query($Connection,$ExtractingCommentsQuery);
                $SrNo = 0;
                while ($FetchDataArray = mysqli_fetch_array($Execute)) {
                  $CommentsId = $FetchDataArray['id'];
                  $Commentor_Name = $FetchDataArray["name"];
                  $Date_Time_Of_Comments = $FetchDataArray["datetime"];
                  $Person_Comment = $FetchDataArray["comment"];
                  $Commented_Post_Id = $FetchDataArray['admin_panel_id'];
                  $SrNo++;
                  if (strlen($Person_Comment)>18) {
                  	$Person_Comment = substr($Person_Comment, 0,18).'...';
                  }
                  if (strlen($Commentor_Name)>10) {
                  	$Commentor_Name = substr($Commentor_Name, 0,10).'...';
                  }
				  ?>

				  <tr>
				  	<td><?php echo htmlentities($SrNo); ?></td>
				  	<td><?php echo htmlentities($Commentor_Name) ; ?></td>
				  	<td><?php echo htmlentities($Date_Time_Of_Comments); ?></td>
				  	<td><?php echo htmlentities($Person_Comment) ; ?></td>
				  	<td><a href="ApproveComments.php?id=<?php echo $CommentsId; ?>"><span class="btn btn-success">Approve</span></a></td>
				  	<td><a href="DeleteComments.php?id=<?php echo $CommentsId; ?>"><span class="btn btn-danger">Delete</span></a></td>
				  	<td><a href="FullPost.php?id=<?php echo $Commented_Post_Id;?>"target ="_blank">
				  	<span class="btn btn-primary">Live Preview</span></a></td>
				  </tr>
						<?php } ?>

					</table>
				</div> <!--Ending Comments Table-->

			


			</div> <!-- end of col sm 10 -->
		</div> <!-- end of row -->
	</div> <!-- end of col container -->

	


</body>
</html>