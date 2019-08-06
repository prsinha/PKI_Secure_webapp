<?php require_once('Connections/conn.php'); ?>
<?php
$date =date("Y/m/d");
session_start();
if(isset($_SESSION['user_name']))
{
mysql_select_db($database_conn, $conn);
$query_logs = "SELECT LID, LDetails, LArchived FROM logdetails";
$logs = mysql_query($query_logs, $conn) or die(mysql_error());
$row_users = mysql_fetch_assoc($logs);
$totalRows_users = mysql_num_rows($logs);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::  Logs  ::</title>

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
    Logs</h1>

     <br />Below is a list of all logs in the system<br /><br />

 <?php //<td><b>Edit</b></td>
	  echo "<table border='1' cellspacing='0' cellpadding='0' width='90%'>
						<tr>
						<td><b>ID</b></td>
						<td><b>Details<b></td>
						<td><b>Archived</b></td>";
						?>
						<?php echo "</tr>";
	  do { ?>
      <?php echo "<tr>"; ?>
       <?php echo "<td>".$row_logs['LID']."</td>" ;?>
       <?php echo"<td>".$row_logs['LDetails']."</td>" ; ?>
	   <?php echo"<td>".$row_logs['LArchived']."</td>" ; ?>
       <?php echo "</tr>"; ?>
        <?php } while ($row_logs = mysql_fetch_assoc($logs));
		echo "</table>"; ?>
</td>
  </tr>
 <tr>
   <td align="left" valign="top">&nbsp;</td>
 </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"></td>
    <td align="left" valign="top"></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
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