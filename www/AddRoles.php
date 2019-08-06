<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
if(isset($_SESSION['user_name']))
{
    $id_role= $_GET["id"];
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
                            if($id_role=='new')
                            {
                                if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "manageusers"))
                                {
                                    $max_ref="select max(roles.RID) as id from roles ";
                                    $ref=mysql_query($max_ref,$conn) or die(mysql_error());
                                    $max=mysql_fetch_assoc($ref);
                                    $newref=(int)$max['id']+1;
                                    $newref=(string)$newref;
                                    $insertSQL = sprintf("INSERT INTO roles (RID, RName, RDetails) VALUES (%s, %s, %s)",
                                        GetSQLValueString($newref, "int"),
                                        GetSQLValueString($_POST['role'], "text"),
                                        GetSQLValueString($_POST['roledetails'], "text"));

                                    mysql_select_db($database_conn, $conn);
                                    $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

                                    $insertGoTo = "Admin.php";
                                    if (isset($_SERVER['QUERY_STRING'])) {
                                        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                                        $insertGoTo .= $_SERVER['QUERY_STRING'];
                                    }
                                    header("location:AddRoles.php?id=new");
                                }
                            }
                            else
                            {
                                $editFormAction = $_SERVER['PHP_SELF'];
                                if (isset($_SERVER['QUERY_STRING'])) {
                                    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
                                }
                                if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "manageusers")) {
                                    $updateSQL = sprintf("UPDATE roles SET RName=%s, RDetails=%s WHERE RID=$id_role",

                                        GetSQLValueString($_POST['role'], "text"),
                                        GetSQLValueString($_POST['roledetails'], "text"));

                                    mysql_select_db($database_conn, $conn);
                                    $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
                                    header("location:AddRoles.php?id=new");
                                }
                                mysql_select_db($database_conn, $conn);
                                $query_role = "SELECT * FROM roles WHERE RID = $id_role";
                                $role = mysql_query($query_role, $conn) or die(mysql_error());
                                $row_role = mysql_fetch_assoc($role);
                                $totalRows_role = mysql_num_rows($role);
                            }

                            mysql_select_db($database_conn, $conn);
                            $query_roles = "SELECT * FROM roles";
                            $roles = mysql_query($query_roles, $conn) or die(mysql_error());
                            $row_roles = mysql_fetch_assoc($roles);
                            $totalRows_roles = mysql_num_rows($roles);
                            $date =date("Y/m/d");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>::  Home  ::</title>

        <link href="css/style.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <form method="POST" action="<?php echo $editFormAction; ?>" name="manageusers">
            <table  width="72%" border="0" cellspacing="0" cellpadding="0"  align="center" >
                <tr >
                    <td colspan="3" align="left" valign="top" style="background:url(../image/top.gif);width:900px; height:96px;" ><FONT FACE="Tahoma" SIZE="6">
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
                        Manage Users :: </h1>
                        <br />
                        <table width="90%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" align="left" valign="top">Below is a list of Groups in the system
                                    <br />
                                    <?php
                                    echo "<table border='1' cellspacing='0' cellpadding='0' width='80%'>
                                <tr>
                                <td><b>Group Name</b></td>
                                <td><b>Group Details</b></td>
                                <td><b>Edit<b></td>
                                <td><b>Delete</b></td>
                                </tr>";

                                    do { ?>
                                        <?php
                                        echo "<tr>";
                                        echo "<td>".$row_roles['RName']."</td>";
                                        echo "<td>".$row_roles['RDetails']."</td>";
                                        echo"<td><a href='AddRoles.php?id=".$row_roles['RID']."'><img src='image/b_edit.png' width='16' height='16' border='0' /><font color='#666666'>Edit</font></a></td>" ;
                                        echo"<td><a href='deleterole.php?id=$id_file&uid=".$row_roles['RID']."'><img src='image/b_edit.png' width='16' height='16' border='0' /><font color='#666666'>Edit</font></a></td>" ;
                                        echo "</tr>";
                                        ?>
                                        <?php } while ($row_roles = mysql_fetch_assoc($roles));
                                    echo "</table>";
                                    ?><br /><br />            </td>
                            </tr>
                            <tr>
                                <td width="28%" align="left" valign="top">Role Name</td>
                                <td width="72%" align="left" valign="top"><input name="role" type="text" id="role" value="<?php echo $row_role['RName']; ?>" size="80" />
                                    <br />
                                <br />        </td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">Role Details</td>
                                <td align="left" valign="top"><textarea name="roledetails" cols="80" rows="4" id="roledetails"><?php echo $row_role['RDetails']; ?></textarea>
                                    <br />
                                <br /></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">
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
            <input type="hidden" name="MM_update" value="manageusers" />
            <input type="hidden" name="MM_insert" value="manageusers" />
        </form>
    </body>
</html>
<?php
mysql_free_result($roles);
mysql_free_result($role);
}else{

    header("location:login.php");
}
?>
