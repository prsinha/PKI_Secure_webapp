<?php require_once('../Connections/conn.php'); ?>
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

        <link href="../css/style.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <form method="POST" action="<?php echo $editFormAction; ?>" name="registerusers">
            <table  width="72%" border="0" cellspacing="0" cellpadding="0"  align="center" >
                <tr >
                    <td colspan="3" align="left" valign="top" style="background:url(../image/top.gif);width:900px; height:96px;" ><FONT FACE="Tahoma" SIZE="6">
                    Document Library</FONT><pre><FONT FACE="Tahoma">Group Name</FONT></pre>  </td>
                </tr>
                <tr bgcolor="#000000">
                    <td align="center" valign="top" BGCOLOR="#336666">
                    </td>
                    <td align="center" valign="top" BGCOLOR="#336666">&nbsp;</td>
                    <td align="left" valign="top" BGCOLOR="#336666">
                        <font color="#FFFFFF" face="Tahoma">|</font><font face="Tahoma">
                            <a href="home.php">Home</a> <font color="#FFFFFF">
                            |</font>
                            <a href="documents.php">Documents</a> <font color="#FFFFFF">|</font>
                            <?php

                            if($_SESSION['role_id']=='0')
                            {
                                echo "<a href='Admin/Admin.php'>Admin</a> <font color='#FFFFFF'>|";
                            }?>
                            <a href="EditDetails.php">Edit Personal Details</a> |
                    <a href="login.php">Log out</a> |</font></font></div></td>
                </tr>
                <tr>

                    <td colspan="3" align="left" valign="top">    </td>
                </tr>
                <tr>
                    <td width="215" align="left" valign="top"><br /><br /><table width="215" border="0" cellspacing="0" cellpadding="0">
                            <tr> <td colspan="3" height="28" background="../image/menuup.gif"> <div align="center"><FONT COLOR="#FFFFFF" FACE="Tahoma"><b>
                            Admin Tasks</b></FONT></div></td></tr> <tr> <td width="9" height="76" background="../image/menuleft.gif">&nbsp;</td><td width="194" height="76">
                                    <img src="../image/dot.gif" width="65" height="18" /><a href="../home.php" style="color:#000000">|&nbsp; Home &nbsp;|</a><br />
                                    <img src="../image/dot.gif" width="65" height="18" /><a href="../home.php" style="color:#000000">| &nbsp;Home &nbsp;|</a><br />
                                    <img src="../image/dot.gif" width="65" height="18" /><a href="../home.php" style="color:#000000">| &nbsp;Home &nbsp;|</a><br />
                                </td>
                            <td width="12" height="76" background="../image/menuright.gif">&nbsp;</td></tr>
                    <tr> <td colspan="3" height="28" background="../image/menudown.gif">&nbsp;</td></tr> </table></td>
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
}else{
    header("location:../login.php");
}
?>