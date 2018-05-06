<?php 
# session_start() - Start new or resume existing session
session_start();

function Message(){

	# isset — Determine if a variable is set and is not NULL
	# $_SESSION--An associative array containing session variables available to the current script.

	 if (isset($_SESSION["ErrorMessage"])) {
	 	# code...
	 	$Output = "<div class = \"alert alert-danger\">";
	 	// NOW CONCATANET WITH variable Output with Session
	 	$Output.= htmlentities($_SESSION["ErrorMessage"]);
	 	$Output.= "</div>";
	 	$_SESSION["ErrorMessage"] = null;
	 	return $Output;
	 }
}



function SuccessMessage(){
	 if (isset($_SESSION["SuccessMessage"])) {
	 	# code...
	 	$Output = "<div class = \"alert alert-success\">";
	 	// NOW CONCATANET WITH variable Output with Session
	 	$Output.= htmlentities($_SESSION["SuccessMessage"]);
	 	$Output.= "</div>";
	 	$_SESSION["SuccessMessage"] = null;
	 	return $Output;
	 }
}

 ?>