<?php
    require_once('Connections/conn.php');
    session_start();
    if(isset($_SESSION['user_name']))
    {
        $id_user = $_GET["id"];
        //$date =date("Y/m/d");
        $time=date("h:i:s");
        $date = mktime(0,0,0,date("m"),date("d")-5,date("Y"));
        mysql_select_db($database_conn, $conn);
        $query_logs = "SELECT * FROM logdetails WHERE LArchived = 0";
        $logs = mysql_query($query_logs, $conn) or die(mysql_error());
        $row_logs = mysql_fetch_assoc($logs);
        $totalRows_logs = mysql_num_rows($logs);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::  Home  ::</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
   <SCRIPT LANGUAGE="JavaScript">
function popup(id) 
{
 var width  = 486;
 var height = 300;
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
 url='editlog.php?id='+ id;
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
    Manage Logs  </h1> 
      <br /> 
    <table width="90%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2">
        <?php 
		 echo "<table border='1' cellspacing='0' cellpadding='0' width='90%'>
						<tr>
						<td><b>Log Date</b></td>
						<td><b>Log Time</b></td>
						<td><b>Log Details<b></td>
						<td><b>Archive Log</b></td>
						
						</tr>";
		do { 
            echo "<tr>";
            echo "<td>".$row_logs['LDate']."</td>" ;
            echo"<td>".$row_logs['LTime']."</td>" ;
    		echo"<td>".$row_logs['LDetails']."</td>" ;
    		echo "<td><a href='javascript: void(0)' onclick=popup('".$row_logs['LID']."')><img src='image/b_edit.png' width='16' height='16' border='0' /><font color='#666666'>Archive</font></a></td>";
            echo "</tr>";
         } while ($row_logs= mysql_fetch_assoc($logs));
		echo "</table>"; ?>
          <br />        </td>
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
mysql_free_result($logs);
 }else{ header("location:login.php");}?>