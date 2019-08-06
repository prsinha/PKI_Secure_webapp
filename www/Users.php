<?php require_once('Connections/conn.php'); ?>
<?php
$date =date("Y/m/d");
session_start();
if(isset($_SESSION['user_name']))
{
mysql_select_db($database_conn, $conn);
$query_users = "SELECT UserID , FName , Email FROM 6120project.userdetails u";
$users = mysql_query($query_users, $conn) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::  Users  ::</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="uploadform">
<table  width="72%" border="0" cellspacing="0" cellpadding="0"  align="center" >
<tr >
<td colspan="3" align="left" valign="top" style="background:url(image/top.gif);width:900px; height:96px;" ><FONT FACE="Tahoma" SIZE="6">
  Document Library</FONT><pre><FONT FACE="Tahoma">Group Name</FONT></pre></td>
  </tr>
  <tr bgcolor="#000000">
  <td align="center" valign="top" BGCOLOR="#336666">    </td>
  <td align="center" valign="top" BGCOLOR="#336666">&nbsp;</td>
  <td align="left" valign="top" BGCOLOR="#336666">
  <?php include('menu.php'); ?></td>
  </tr>
  <tr>

    <td colspan="3" align="left" valign="top">    </td>
  </tr>
 <tr>
   <td width="215" rowspan="2" align="left" valign="top"><br /><?php include("sideadminmenu.php")?><br /></td>
   <td width="26" rowspan="2" align="left" valign="top">&nbsp;</td>
    <td width="751" align="left" valign="top"> <br /><h1><br />
    Manage Users</h1>

     <br />Below is a list of all users in the system<br /><br />

 <?php //<td><b>Edit</b></td>
	  echo "<table border='1' cellspacing='0' cellpadding='0' width='90%'>
						<tr>
						<td><b>Name</b></td>
						<td><b>Email</b></td>
						<td><b>Delete<b></td>
						<td><b>Capability List</b></td>";
						 echo "</tr>";
	  do { 
       echo "<tr>"; 
       echo "<td>".$row_users['FName']."</td>" ;
       echo"<td>".$row_users['Email']."</td>" ; 
       echo"<td><a href='user_delete.php?id=".$row_users['UserID']."'><img src='image/b_drop.png' width='16' height='16' border='0' /><font color='#666666'>delete</font></a></td>" ;
       echo"<td><a href='user_capability.php?id=".$row_users['UserID']."'><img src='image/b_edit.png' width='16' height='16' border='0' /><font color='#666666'>C_list</font></a></td>" ;
       echo "</tr>"; 
       } while ($row_users = mysql_fetch_assoc($users));
		echo "</table>"; ?>
</td>
  </tr>
 <tr>
   <td align="left" valign="top">&nbsp;</td>
 </tr>
 <tr>
    <td align="left" valign="top"></td>
    <td align="center" colspan="2" valign="top">
	<input type="submit" name="AddUser" id="AddUser" value="Click here to add a user" onclick="window.open('registerusers.php')"></td>
    
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"></td>
    <td align="left" valign="top"></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"></td>
    </tr>
  <tr>
    <td colspan="3"><DIV ALIGN="CENTER"><FONT SIZE="1" FACE="Tahoma">Copyright 2008 . All Rights Reserved</FONT></DIV></td>
  </tr>
  <tr>
   <td colspan="3" BGCOLOR="#336666">&nbsp;</td>
   </tr>
</table></form>
</body>
</html>

<?php }else{  header("location:login.php"); }?>