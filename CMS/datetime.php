<?php 
  date_default_timezone_set("Asia/Dhaka");
  $Currenttime = time();
  $Datetime = strftime("%B-%d-%Y %H:%M:%S",$Currenttime);
  echo $Datetime;
 ?>