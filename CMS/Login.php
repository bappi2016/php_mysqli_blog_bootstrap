
<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>

<?php 

// submit post and store the post in category variable
# isset — Determine if a variable is set and is not NULL
if (isset($_POST["Submit"])) {

	 $UserName =($_POST["Username"]);
	 $Password =($_POST["Password"]);
	 


         	/*if (mysqli_connect_errno()) {

  echo "Failed to connect to MySQL: " . mysqli_connect_error();

}*/

     // set a validation
      if (empty($UserName) || empty($Password)) {
     	# code...
     	# $_SESSION--An associative array containing session variables available to the current script.
     	$_SESSION["ErrorMessage"] = "All fields must be filled out";
     	Redirect_to("Login.php");
     } 

else{

	$Access_Account = Login_Attempt($UserName,$Password);
	$_SESSION["User_Id"]=$Access_Account["username"];
	if ($Access_Account) {
		$_SESSION["SuccessMessage"] = "Welcome back {$_SESSION["User_Id"]} to Backtrack Admin Panel";
		Redirect_to("Dashboard.php");
	}else{
		$_SESSION["ErrorMessage"] = "Name or Password Didn't Match";
     	Redirect_to("Login.php");
	}

	 
     }
    
}


 ?>



<!DOCTYPE>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login to Dashboard</title>

	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


	<script src="assets/bootstrap/js/jquery.js"></script>

	
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>





	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/publicstyles.css">


	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	
</head>
<body>
	<div class="container-fluid">
		<div class="row">
				
			<div class="col-sm-offset-4 col-sm-4">
				<br>
				<br>
				<br>

				<?php
					 echo Message();
					 echo SuccessMessage();
				?>
				<br>
				<br>
				<br>
				<br><br>
				<br>
				<br>
				<br>
				<h4>Welcome Back Bro.... </h4>
				

				
				<div>
					<!-- Create a form with  post Method for category and post -->
					<form action="Login.php" method="post">
						<fieldset>
							<div class="form-group">
								<label for="Username"> <span class="FieldInfo">UserName:</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
							    <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
							    </div>
							</div>

							<div class="form-group">
								<label for="Password"> <span class="FieldInfo">Password:</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>

							    <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
							    </div>
							</div>
							<input class="btn btn-primary" type="Submit" name="Submit" value="Login">
						</fieldset>
					</form>
				</div> <!-- END OF DIV FORM-->
			
				

			</div> <!-- end of col sm 4 -->
		</div> <!-- end of row -->
	</div> <!-- end of col container -->

	


</body>
</html>