<?php require_once('Connections/conn.php'); ?>
<?php
$date =date("Y/m/d");
session_start();
if(isset($_SESSION['user_name']))

{




?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::  Admistartoion Page  ::</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="registerusers">
<table  width="72%" border="0" cellspacing="0" cellpadding="0"  align="center" > 
<tr > 
<td colspan="3" align="left" valign="top" style="background:url(image/top.gif);width:900px; height:96px;" ><FONT FACE="Tahoma" SIZE="6">
  Document Library</FONT><pre><FONT FACE="Tahoma">Group Name</FONT></pre>  </td>
  </tr>
  <tr bgcolor="#000000"> 
  <td align="center" valign="top" BGCOLOR="#336666">
    </td>
  <td align="center" valign="top" BGCOLOR="#336666">&nbsp;</td>
  <td align="left" valign="top" BGCOLOR="#336666">
  <?php include('menu.php'); ?></td>
  </tr>
  <tr>
   
    <td colspan="3" align="left" valign="top">    </td>
  </tr>
 <tr>
   <td width="215" align="left" valign="top"><br /><?php include("sideadminmenu.php")?><br /></td>
   <td width="26" align="left" valign="top">&nbsp;</td>
    <td width="751" align="left" valign="top"> <br /><h1><br />
    Administration Home :: </h1> <br /> 
    What the administrator can do<br /><br />
    &nbsp;&nbsp;o Generate user certificate along with all required information.<br /><br />
    &nbsp;&nbsp;o Generate an ACL to each and every user.<br /><br />
    &nbsp;&nbsp;o Manage users, groups and ACLs.<br /><br />
    &nbsp;&nbsp;o Perform various maintenance actions such as:<br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;i) Check log files.<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ii) Delet</td>
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
mysql_free_result($newfiles);

?>
<?php }else{

 header("location:../login.php");

}

?>