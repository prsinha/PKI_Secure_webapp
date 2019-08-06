<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
if(isset($_SESSION['user_name']))
{
$id_user = $_GET["id"];
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
$query = "SELECT f.FID , f.FName , uf.R , uf.W , uf.O , uf.V FROM files f LEFT JOIN userfilerights uf ON(uf.FID = f.FID AND uf.UserID = '$id_user')";
//$query = "SELECT files.FID,files.FName,userdetails.UserID, CONCAT(userdetails.FName,' ',userdetails.MName,'. ',userdetails.LName) AS  Names,  userfilerights.R, userfilerights.W, userfilerights.O FROM files,userdetails, userfilerights  WHERE userfilerights.UserID=userdetails.UserID and  userfilerights.FID=files.FID and userfilerights.FID=$id_file";
$userACL = mysql_query($query, $conn) or die(mysql_error());
$row_userACL = mysql_fetch_assoc($userACL);
$totalRows_userACL = mysql_num_rows($userACL);

mysql_select_db($database_conn, $conn);
$query_udet = "SELECT CONCAT(userdetails.FName,' ',userdetails.MName,'. ',userdetails.LName) AS Names
FROM userdetails where UserID = '$id_user'";
$udet = mysql_query($query_udet, $conn) or die(mysql_error());
$row_udet = mysql_fetch_assoc($udet);
$totalRows_udet = mysql_num_rows($udet);

$date =date("Y/m/d");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::  Home  ::</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
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
    <?php echo $row_udet['Names']; ?> Capability List  </h1> 
      <br /> 
    <table width="90%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2">
        <?php 
		 echo "<table border='1' cellspacing='0' cellpadding='0' width='90%'>
						<tr>
						<td><b>File</b></td><td><b>Own</b></td><td><b>Write<b></td>
						<td><b>Read</b></td><td><b>View</b></td><td><b>Edit</b></td>
						</tr>";
		do { 
            echo "<tr>";
            echo "<td>".$row_userACL['FName']."</td>" ;
            echo"<td>";
            if ($row_userACL['O']!='1')
            {           echo "<input name='read' type='checkbox'  disabled='disabled' />";           }
            else
            {          	echo "<input name='read1' type='checkbox' checked='checked' disabled='disabled' />";    }
            echo "</td>" ;
            echo"<td>";
            if ($row_userACL['W']!='1')
            {          	echo "<input name='read' type='checkbox'  disabled='disabled' />";            }
            else
            {           echo "<input name='read1' type='checkbox' checked='checked' disabled='disabled' />";   }
            echo "</td>" ;           
            echo"<td>";
            if ($row_userACL['R']!='1')
            {			echo "<input name='read' type='checkbox'  disabled='disabled' />";		}
            else
            {			echo "<input name='read1' type='checkbox' checked='checked' disabled='disabled' />";	}
            echo "</td>" ;
            echo"<td>";
            if ($row_userACL['V']!='1')
            {           echo "<input name='view' type='checkbox'  disabled='disabled' />";           }
            else
            {          	echo "<input name='view1' type='checkbox' checked='checked' disabled='disabled' />";    }
            echo "</td>" ;

            echo "<td><a href='javascript: void(0)' onclick=popup('".$row_userACL['FID']."','".$id_user."')><img src='image/b_edit.png' width='16' height='16' border='0' /><font color='#666666'>Edit</font></a></td>";
            echo "</tr>";
         } while ($row_userACL = mysql_fetch_assoc($userACL));
		echo "</table>"; ?>
        <br /></td>
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
<?php mysql_free_result($userACL);
 }else{ header("location:login.php");}?>