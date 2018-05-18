<?php require_once("include/Session.php"); ?>
<?php require_once("include/Function.php"); ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>backtrack</title>

  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="assets/bootstrap/js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/publicstyles.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
  </head>

<body>

<div class="container-fluid">

	<div class="blog-header">
		<h1>Well Come To Bractrack</h1>
	</div>

	<div class="row">

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>

      <!-- Search Button form-->
      <form class="navbar-form navbar-left">
		<div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="Search">
        </div>
        <button type="submit" class="btn btn-default" name="SearchButton">Submit</button>
      </form>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="col-sm-8"> <!--starting  of main article section-->
      
			<?php 
			// now to fetch data, first set the database connection
            $Connection = mysqli_connect("localhost","root","","phpcms");
            # here we set a query for search option; if user search something on name= "SearchButton" then out get method will active
            if (isset($_GET["SearchButton"])) {
            	$Search = $_GET["Search"];
            	# Query when search button is active or visitor search something and we fetch the data from admin panel table
            	$ViewQuery = "SELECT * FROM admin_panel
            	WHERE id LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
            	}
				#set query when category is active in URL for sidebar option 
				elseif (isset($_GET["Category"])) {
				 	$Category = $_GET["Category"];
				 	$ViewQuery = "SELECT * FROM admin_panel WHERE category = '$Category' ORDER BY id desc";
				 } 
			# query when pagination is active that is index.html?page=1;
            elseif (isset($_GET["Page"])) {
            	$Page = $_GET["Page"];
            	# statement for some odd case like page = 0 or nagetive page index
            	if ($Page==0 || $Page<1) {
            		$ShowPostFrom = 0;
            	}else{
            		# here we show the index from 0 for page = 1,
            		$ShowPostFrom = ($Page*5)-5; }
            	$ViewQuery = " SELECT *FROM admin_panel ORDER BY id desc LIMIT $ShowPostFrom,5";
            	}
           
			else{
			// set the default query exactly what you want to show or see
			$ViewQuery = " SELECT *FROM admin_panel ORDER BY id desc LIMIT 0,3";}
			$Execute = mysqli_query($Connection,$ViewQuery);
			// iterate a loop to grab the data stored in the database
			while ($DataRows=mysqli_fetch_array($Execute)) {
			 	# variable to grap date = placeholder variable["table entity or row"]
			 	$PostId = $DataRows["id"]; # here $DataRows is just a placeholder variable
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
             <p>Category:<?php echo htmlentities($Category); ?> Published on <?php echo htmlentities($Datetime); ?>

             	<?php 
             	# After image,title and category we shows the approved comment number in here
	 			$Connection = mysqli_connect("localhost","root","","phpcms");
	 			$QueryApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$PostId' AND status = 'ON'";
	 			$ExecuteQuery = mysqli_query($Connection,$QueryApproved) or die(mysqli_error($Connection));
	 			$RowsApproved = mysqli_fetch_array($ExecuteQuery);
	 			$TotalApproved = array_shift($RowsApproved);
				if ($TotalApproved>0) {
	 			?>
				<span class="badge pull-right">
				Comments: <?php echo $TotalApproved; ?></span>
	 			<?php }  ?>
    			</p>


     	 		<P> <!--Blog post inside the p tag-->
     	 		<?php
     	 		# in this section we shows the limited context of blog post that is 150 word
				if (strlen($Post)>150) {
     	 		$Post = substr($Post,0,150).'...';
     	 		}
     	 		echo $Post; 
     	 		?>
     	 		</P><!-- end section of Blog post inside the p tag-->

             	 </div><!--full Blog post div which will open with a new tab -->
             	 	<a href="FullPost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info pull-right">Read More &rsaquo;&rsaquo; </span> </a>
             	 </div>

             	 <?php
             	 # End of while loop and blog post section
             	 }?> 

            <nav><!-- start section for pagination for blog post-->
        	<ul class="pagination pull-left pagination-lg">
    		<?php 
    		# here we set the get method for page in the URL and set the ternary operator 
    		$Page = (isset($_GET['Page']) ? $_GET['Page'] : '');
    		if ($Page>1) {
    		?>
    		<!-- if user have in the page which is greater than 1 then we show the back arrow and decrease by 1-->
    		<li> <a href="Index.php?Page=<?php echo $Page-1; ?>"> &laquo;</a></li>
    		<?php }
			?>

	        <?php 
	        # here we dynamically handle the pagination list length with the number of post per page and total number of post which are stored in database
	        $Connection = mysqli_connect("localhost","root","","phpcms");
	        $QueryPagination = "SELECT COUNT(*) FROM admin_panel"; # primarily count all the stored entity
	        $ExecuteQueryPagination = mysqli_query($Connection,$QueryPagination);
	        $RowPagination = mysqli_fetch_array($ExecuteQueryPagination);
	        #array_shift() shifts the first value of the array off and returns it, shortening the array by one element and moving everything down. All numerical array keys will be modified to start counting from zero while literal keys won't be touched.
			$TotalPost = array_shift($RowPagination);
	        $PostPagination = $TotalPost/5;
	        $PostPagination = ceil($PostPagination);
	        # USING THE TERNARY OPERATOR TO SET THE INDEX FOR PAGE
			$Page = (isset($_GET['Page']) ? $_GET['Page'] : '');
			# set a for loop with the range of total post number per page
	        for ($i=1; $i <=$PostPagination ; $i++) { 
	        # for active link we check if the index page is equal to the pagination page which is i or not
			if ($i==$Page){
	        ?>
	        <li class = "active"><a href="Index.php?Page=<?php echo $i; ?>"> <?php echo $i; ?></a></li>
	        <?php 
	        }else{?>
	        <li><a href="Index.php?Page=<?php echo $i; ?>"> <?php echo $i; ?></a></li>
			<?php 
		     } 

		    }# end of for loop for chacking active index page?>
			<?php 
    		$Page = (isset($_GET['Page']) ? $_GET['Page'] : '');
    		if ((int)$Page+1<=$PostPagination) {
    		?>
    		<li> <a href="Index.php?Page=<?php echo $Page+1; ?>"> &raquo;</a></li>
    		<?php }
 			?>
 				
 			</ul>
        </nav><!-- end section for pagination for blog post-->
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


			<div class="panel panel-primary"> <!--start Side panel for Extracting Category -->
				<div class="panel-heading">
					<h2 class="panel-title">Categories</h2>
				</div>
				<div class="panel-body">

				<?php 
				# Here in panel body we extract the category and recent post from our database, so at first call our database, then write a query which table we want to extrat and which entity ..
				$Connection = mysqli_connect("localhost","root","","phpcms");
				$ViewQuery = "SELECT * FROM category ORDER BY id desc";
				$Execute = mysqli_query($Connection,$ViewQuery);
				while ($FetchDataArray=mysqli_fetch_array($Execute)) {
				 $Id = $FetchDataArray['id'];
				 $Category = $FetchDataArray['name']; # here we saved the table row for category as name
				 ?>
				 <a href="Index.php?Category=<?php echo $Category; ?>">
				 <span><?php echo $Category."<br>"; ?></span>
				 </a>
				 <?php } ?>
				</div>
				<div class="panel-footer">
				</div>
			</div> <!--Ending Side panel for Extracting Category -->

		<div class="panel panel-primary"> <!--start Side panel for Extracting Recent Blog Post -->
			<div class="panel-heading">
				<h2 class="panel-title">Recent Post</h2>
			</div>
			<div class="panel-body">

				<?php 
				$Connection = mysqli_connect("localhost","root","","phpcms");
				$ViewQuery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5";
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
				 
				<?php } # End of while loop ?>

			</div>
			<div class="panel-footer">
				
			</div>
		</div>	<!--Ending Side panel for Extracting Blog Post -->

</div><!--end of side bar-->

</div> <!--row ending-->

<div>
	<?php include "Footer.php"; ?>
</div>

</div> <!--end of container-->

</body>
</html>