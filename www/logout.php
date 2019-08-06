<?php 
session_start();
$user_name=$_SESSION['user_name'];

$date =date('l jS \of F Y h:i:s A');
    include 'Connections/db_open.php';
	//this function gets the ip address of the user for logging purpose
	function getRealIpAddr()
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
			{
			  $ip=$_SERVER['HTTP_CLIENT_IP'];
			}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
			{
			  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
			  $ip=$_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
		
$x= getRealIpAddr();
		$logdetails ="User : ".$user_name." Logged out on ".$date." from ".$x;
			$max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
			$ref=mysql_query($max_ref,$conn) or die(mysql_error());
			$max=mysql_fetch_assoc($ref);
			$newref=(int)$max['id'];
			$newref="LOG".$newref;
		$query = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
        mysql_query($query) or die('Error, query failed');
		
		session_destroy(); 

		 header("location:login.php");
?>
