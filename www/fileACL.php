<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
if(isset($_SESSION['user_name']))
{
$id_file = $_GET["id"];

mysql_select_db($database_conn, $conn);
$query_file = "SELECT userdetails.UserID,
CONCAT(userdetails.FName) AS Names,
userfilerights.R, userfilerights.W, userfilerights.O, userfilerights.V
FROM userfilerights
Right Join userdetails ON userfilerights.UserID = userdetails.UserID AND userfilerights.FID = '$id_file'";
$file = mysql_query($query_file, $conn) or die(mysql_error());
$row_file = mysql_fetch_assoc($file);
$totalRows_file = mysql_num_rows($file);

mysql_select_db($database_conn, $conn);
$query_filedet = "SELECT * FROM files where FID = '$id_file'";
$filedet = mysql_query($query_filedet, $conn) or die(mysql_error());
$row_filedet = mysql_fetch_assoc($filedet);
$totalRows_filedet = mysql_num_rows($filedet);

$date =date("Y/m/d");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: <?php echo $row_filedet['FName']?>  ACL ::</title>
   <SCRIPT LANGUAGE="JavaScript">
function popup(id,uid) 
{
var width  = 500;
 var height = 200;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=yes';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=no';
 params += ', status=no';
 params += ', toolbar=no';
 url='EditCL.php?id='+ id +'&uid='+uid;
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}
    </script>

<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form method="POST" name="manageusers">
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
   <td width="230" align="left" valign="top"><br /><?php include("sideadminmenu.php")?><br /></td>
   <td width="9" align="left" valign="top">&nbsp;</td>
    <td width="681" align="left" valign="top"> <br /><h1><br />
<?php echo $row_filedet['FName']?> Access Control List </h1> 
      <br /> 
    <table width="90%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2">
        
          <br />
<?php 
		 echo "<table border='1' cellspacing='0' cellpadding='0' width='90%'>
						<tr>
						<td><b>User</b></td>
                        <td><b>Own</b></td>
                        <td><b>Write<b></td>
                        <td><b>Read</b></td>
                        <td><b>View</b></td>
						<td><b>Edit</b></td>
						</tr>";
    	do { 
            echo "<tr>"; 
            echo "<td>".$row_file['Names']."</td>" ;
            echo "<td>"; 
			if ($row_file['O']!='1')
			{	echo "<input name='read' type='checkbox'  disabled='disabled' />";			}
			else
			{	echo "<input name='read1' type='checkbox' checked='checked' disabled='disabled' />";	}
			echo "</td>" ;
            echo "<td>"; 
			if ($row_file['W']!='1')
			{	echo "<input name='read' type='checkbox'  disabled='disabled' />";		}
			else
			{	echo "<input name='read1' type='checkbox' checked='checked' disabled='disabled' />";	}
			echo "</td>" ;            
            echo "<td>"; 
			if ($row_file['R']!='1')
			{	echo "<input name='read' type='checkbox'  disabled='disabled' />";			}
			else
			{	echo "<input name='read1' type='checkbox' checked='checked' disabled='disabled' />";	}
			echo "</td>" ; 
            echo "<td>";
			if ($row_file['V']!='1')
			{	echo "<input name='view' type='checkbox'  disabled='disabled' />";			}
			else
			{	echo "<input name='view1' type='checkbox' checked='checked' disabled='disabled' />";	}
			echo "</td>" ;

			echo "<td><a href='javascript: void(0)' onclick=popup('".$id_file."','".$row_file['UserID']."')><img src='image/b_edit.png' width='16' height='16' border='0' /><font color='#666666'>Edit</font></a></td>";          
            echo "</tr>"; 
        } while ($row_file = mysql_fetch_assoc($file));
		echo "</table>";
        ?> </tr>
     
    </table>
    <br /></td>
  </tr>
  <tr>
    <td align="left" valign="top"></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
    </tr>
  
  <tr>
    <td colspan="3"><DIV ALIGN="CENTER"><FONT SIZE="1" FACE="Tahoma">Copyright 
2008 . All Rights Reserved</FONT></DIV></td>
  </tr>
  <tr>
   <td colspan="3" BGCOLOR="#336666">&nbsp;</td>
   </tr> 
</table>

</form>
</body>
</html>
<?php

 }else{

 header("location:login.php");

}

?>