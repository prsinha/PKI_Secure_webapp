<?php 
session_start();
if(isset($_SESSION['user_name']))
{
header("location:home.php");
}
else
{
header("location:login.php");
}

?>