<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>


<?php 

// submit post and store the post in category variable
# isset — Determine if a variable is set and is not NULL
if (isset($_POST["Submit"])) {

   $Name =($_POST["Name"]);
   $Email =($_POST["Email"]);
   $Comment =($_POST["Comment"]);

   // show time of posting 
   date_default_timezone_set("Asia/Dhaka");
     $Currenttime = time();
     $Datetime = strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
     $Datetime;
     $PostId = $_GET["id"];
     
       // set a validation
      if (empty($Name) || empty($Email) || empty($Comment)) {
      # code...
      # $_SESSION--An associative array containing session variables available to the current script.
      $_SESSION["ErrorMessage"] = "Filled the empty field motherfucker";
     } 
      elseif (strlen($Comment)>500) {
      # code...
      $_SESSION["ErrorMessage"] = "You goota be kidding me... Too many word bro";
      Redirect_to("FullPost.php");
     }

     

 
else{

  $Connection = mysqli_connect("localhost","root","","phpcms") or die(mysqli_error());
  $PostIdFromURL = $_GET['id'];
  # $Query is the sql statement
      $Query= "INSERT INTO comments (datetime,name,email,comment,approvedby,status,admin_panel_id) VALUES ('$Datetime','$Name','$Email','$Comment','pending','OFF','$PostIdFromURL')";
      $Execute = mysqli_query($Connection,$Query);
      
      /*
$connetion_name=mysqli_connect("localhost","root","","web_table") or die(mysqli_error());
$sql_statement="INSERT INTO web_formitem (ID, formID, caption, key, sortorder, type, enabled, mandatory, data) VALUES (105, 7, Tip izdelka (6), producttype_6, 42, 5, 1, 0, 0)";
mysqli_query($connection_name,$sql_statement);*/

        if ($Execute) {
        # code...
        $_SESSION["SuccessMessage"]="Comment Submitted Successfully";
        Redirect_to("FullPost.php?id={$PostId}");
      }
      else{
        $_SESSION["ErrorMessage"]="Failed to add post, try again";
        Redirect_to("FullPost.php?id={$PostId}");
      } 
     }
    
}


 ?>










<!DOCTYPE html>
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
	<div class="blog-header">
		
	</div>
	<div class="row">
		<div class="col-sm-8"> <!--starting  of main article section-->
      <?php
           echo Message();
           echo SuccessMessage();
        ?>
			<?php 
			// now to fetch data, first set the database connection
            $Connection = mysqli_connect("localhost","root","","phpcms");
            if (isset($_GET["SearchButton"])) {
            	# code...
            	$Search = $_GET["Search"];
            	$ViewQuery = "SELECT * FROM admin_panel
            	WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
            }else{
			// set the query exactly what you want to show or see 
            	$PostIdFromURL=$_GET["id"];
			$ViewQuery = "SELECT *FROM admin_panel WHERE id ='$PostIdFromURL'
			 ORDER BY datetime desc";}
			$Execute = mysqli_query($Connection,$ViewQuery);
			// iterate a loop to grap the data stored in the database
			while ($DataRows=mysqli_fetch_array($Execute)) {
			 	# code...
			 	$PostId = $DataRows["id"];
			 	$Datetime = $DataRows["datetime"];
			 	$Title = $DataRows["title"];
			 	$Category = $DataRows["category"];
			 	$Admin = $DataRows["author"];
			 	$Image = $DataRows["image"];
			 	$Post = $DataRows["post"];
		
             	 ?>

             	 <div class="thumbnail"><img class="img-responsive img-rounded img-fluid" src="UPLOAD/<?php echo $Image ?>">

             	 	<div class="figure-caption">
             	 		<h1> <?php echo htmlentities($Title); ?></h1>
             	 		<p>Category: <?php echo htmlentities($Category); ?> Published on <?php echo htmlentities($Datetime); ?></p>
                  <P>Written By <?php echo $Admin; ?></P>
             	 		<P> <?php echo nl2br($Post); ?></P>
              </div>
             	 </div>

             	  <?php } ?> 

                <br>
                <br>
                <br>
                <span><h4>Comments</h4></span>



                <?php 

                $Connection = mysqli_connect('localhost','root','','phpcms');
                $PostIdFromComments = $_GET['id'];
                $ExtractingCommentsQuery = "SELECT * FROM comments WHERE admin_panel_id = '$PostIdFromComments' 
                AND status = 'ON'";
                $Execute = mysqli_query($Connection,$ExtractingCommentsQuery);
                while ($FetchDataArray = mysqli_fetch_array($Execute)) {
                  $Comments_Date = $FetchDataArray["datetime"];
                  $Commentor_Name = $FetchDataArray["name"];
                  $Comments = $FetchDataArray["comment"];
                ?>

                <div>
                <p><?php echo $Commentor_Name; ?></p>
                <p><?php echo $Comments_Date; ?></p>
                <p><?php echo $Comments; ?></p>
                </div>
                <br>
                <hr>

                <?php } ?>


                <br>
                <br>
                <br>

                <h3><span class="FieldInfo">Share Your Thoughts With Us:</span> <br></h3>
                <h6><span class="FieldInfo">Comment here</span></h6>
                
                <div> <!--start comment section here-->





                


          <!-- Create a form with  post Method for category and post -->
          <form action="FullPost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
            <fieldset>

              <div class="form-group">
                <label for="Name"> <span class="FieldInfo">Name:</span></label>
                  <input class="form-control" type="text" name="Name" id="title" placeholder="Name">
              </div>

              <div class="form-group">
                <label for="Email"> <span class="FieldInfo">Email:</span></label>
                  <input class="form-control" type="text" name="Email" id="title" placeholder="Email">
              </div>

              <div class="form-group">
                <label for="Commentarea"> <span class="FieldInfo">Comment:</span></label>
                  <textarea class="form-control" type="text" name="Comment" id="Commentarea"></textarea> 
              </div>

              <br>
              <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
            </fieldset>
          </form>
        </div> <!-- END OF DIV FORM-->



        </div><!--End of main article section-->

		<div class="col-sm-offset-1 col-sm-3"> <!--start of side bar-->
			<h2>About Me</h2>
      <img class="img-responsive img-rounded" src="Image/6.jpeg">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>


      <div class="panel panel-primary">
        <div class="panel-heading">
          <h2 class="panel-title">Categories</h2>
        </div>
        <div class="panel-body">
          <?php 
        $Connection = mysqli_connect("localhost","root","","phpcms");
        $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
        $Execute = mysqli_query($Connection,$ViewQuery);
        while ($FetchDataArray=mysqli_fetch_array($Execute)) {
          $Id = $FetchDataArray['id'];
          $Category = $FetchDataArray['name'];
         ?>
         <a href="Index.php?Category=<?php echo $Category; ?>">
         <span><?php echo $Category."<br>"; ?></span>
         </a>
         <?php } ?>
        </div>
        <div class="panel-footer">
        
        </div>
      </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h2 class="panel-title">Recent Post</h2>
      </div>
      <div class="panel-body">

          <?php 
        $Connection = mysqli_connect("localhost","root","","phpcms");
        $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
        $Execute = mysqli_query($Connection,$ViewQuery);
        while ($FetchDataArray=mysqli_fetch_array($Execute)) {
          $Id = $FetchDataArray['id'];
          $Title = $FetchDataArray['title'];
          $Datetime = $FetchDataArray['datetime'];
          $Image = $FetchDataArray['image'];
          if (strlen($Datetime)>11) {
            $Datetime = substr($Datetime,0,13);}

         ?>
         <div>
          <img class="pull-left" style="margin-top: 10px; margin-left: 10px;" src="UPLOAD/<?php echo htmlentities($Image); ?>" width = 70;height=70;>
          <a href="FullPost.php?id=<?php echo $Id; ?>">
            <p style="margin-left: 90px;"> <?php echo htmlentities($Title); ?></p>
          </a>
          <P style="margin-left: 90px;"> <?php echo htmlentities($Datetime); ?></P>
          <hr>

          
         </div>
         
         <?php } ?>

      </div>
      <div class="panel-footer">
        
      </div>
    </div>  <!--End of side aria panel-->
		</div><!--end of side bar-->

	</div> <!--row ending-->

  <div>
  <?php include "Footer.php"; ?>
</div>
</div> <!--end of container-->

</body>
</html>