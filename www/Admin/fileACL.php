<?php require_once('../Connections/conn.php'); ?>
<?php
session_start();
if(isset($_SESSION['user_name']))

{
$id_files = $_GET["id"];

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn, $conn);
$query_fileACL = "SELECT files.FID, files.FName, files.FDetails, files.FType, files.FContent, files.DateUploaded,userdetails.UserID, CONCAT(userdetails.FName,' ',userdetails.MName,'. ',userdetails.LName) AS  Names, userdetails.RID, userdetails.Email, userfilerights.R, userfilerights.W, userfilerights.O FROM files,userdetails, userfilerights and userfilerights.FID=FID WHERE userfilerights.UserID=userdetails.UserID and  userfilerights.FID=files.FID ";
$fileACL = mysql_query($query_fileACL, $conn) or die(mysql_error());
$row_fileACL = mysql_fetch_assoc($fileACL);
$totalRows_fileACL = mysql_num_rows($fileACL);

$date =date("Y/m/d");





?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::  Home  ::</title>

<link href="../css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form method="POST" name="manageusers">
<table  width="72%" border="0" cellspacing="0" cellpadding="0"  align="center" > 
<tr > 
<td colspan="3" align="left" valign="top" style="background:url(../image/top.gif);width:900px; height:96px;" ><FONT FACE="Tahoma" SIZE="6">
  Document Library</FONT><pre><FONT FACE="Tahoma">Group Name</FONT></pre></td>
  </tr>
  <tr bgcolor="#000000"> 
  <td align="center" valign="top" BGCOLOR="#336666">    </td>
  <td align="center" valign="top" BGCOLOR="#336666">&nbsp;</td>
  <td align="left" valign="top" BGCOLOR="#336666">
  <font color="#FFFFFF" face="Tahoma">|</font><font face="Tahoma"> 
  <a href="..//home.php">Home</a> <font color="#FFFFFF">
  |</font> 
<a href="../documents.php">Documents</a> <font color="#FFFFFF">|</font> 
<a href="../admin.php">Admin</a> <font color="#FFFFFF">| <a href="#">Edit Personal Details</a> |   <a href="../login.php">Log out</a> |</font></font></div></td>
  </tr>
  <tr>
   
    <td colspan="3" align="left" valign="top">    </td>
  </tr>
 <tr>
   <td width="230" align="left" valign="top"><br /><br /><table width="234" border="0" cellspacing="0" cellpadding="0"> 
<tr> <td colspan="2" height="28" background="../image/menuup.gif"> <div align="center"><FONT COLOR="#FFFFFF" FACE="Tahoma"><b>
 Admin Tasks</b></FONT></div></td></tr> <tr> <td width="9" height="76" background="../image/menuleft.gif">&nbsp;</td><td width="203" height="76"> 
 <img src="../image/dot.gif" width="65" height="18" /><a href="maageusers.php" style="color:#000000">|&nbsp; Manage User Roles  &nbsp;|</a><br />
   <img src="../image/dot.gif" width="65" height="18" /><a href="../home.php" style="color:#000000">| &nbsp;Delete Users &nbsp;|</a><br />
    <img src="../image/dot.gif" width="65" height="18" /><a href="../home.php" style="color:#000000">| &nbsp;Add Roles &nbsp;|</a><br />
     <img src="../image/dot.gif" width="65" height="18" /><a href="../home.php" style="color:#000000">| &nbsp; Manage User File Roles &nbsp;|</a><br />
</td>
  </tr> 
<tr> <td colspan="2" height="28" background="../image/menudown.gif">&nbsp;</td></tr> </table></td>
    <td width="9" align="left" valign="top">&nbsp;</td>
    <td width="681" align="left" valign="top"> <br /><h1><br />
    FIle Access Control List:: </h1> 
      <br />
    <table width="90%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2">
        
        <?php 
		
		?>         
          <br />        </td>
        </tr>
      <tr>
        <td width="28%">Role Name</td>
        <td width="72%"><br />
          <br />        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <input type="submit" name="adduserrole" id="adduserrole" value="Add Role" /><br /><br />        </td>
      </tr>
    </table>
    <br /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
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
mysql_free_result($fileACL);
?>
<?php }else{

 header("location:login.php");

}

?>