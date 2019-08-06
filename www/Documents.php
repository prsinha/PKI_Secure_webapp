<?php 
require_once('Connections/conn.php');
include 'Connections/db_open.php';

$date =date("Y/m/d");
session_start();
if(isset($_SESSION['user_name']))
{
    $id_files = $_GET["id"];
    $uid = $_SESSION['user_id'];
    $user_id = $_SESSION['user_id'];
    $role_id=$_SESSION['role_id'];

    mysql_select_db($database_conn, $conn);
    //$query_files = "SELECT * FROM files";
    $query_files = "SELECT files.FID , files.FName , files.FDetails , userfilerights.R , userfilerights.W , userfilerights.O , userfilerights.V
                    FROM files
                    LEFT JOIN userfilerights ON (files.FID =userfilerights.FID AND userfilerights.UserID = '$uid')";
    $files = mysql_query($query_files, $conn) or die(mysql_error());
    $row_files = mysql_fetch_assoc($files);
    $totalRows_files = mysql_num_rows($files);

    mysql_select_db($database_conn, $conn);
    $query_newfiles = "SELECT FName, DateUploaded FROM files  WHERE DateUploaded = '$date'";
    $newfiles = mysql_query($query_newfiles, $conn) or die(mysql_error());
    $row_newfiles = mysql_fetch_assoc($newfiles);
    $totalRows_newfiles = mysql_num_rows($newfiles);

    if(isset($_POST['upload']))
    {
        $max_ref="select count(files.FID) as id from files ";
        $ref=mysql_query($max_ref,$conn) or die(mysql_error());
        $max=mysql_fetch_assoc($ref);
        $newref=(int)$max['id']+1;
        $newref=(string)$newref;
        $len=strlen($newref);
        $add="0";
        $pad=3-$len;
        $padstr=str_pad($add,$pad,STR_PAD_LEFT);
        $newref=$padstr.$newref;
        $newref="FIL".$newref;
        $fileName = $_FILES['userfile']['name'];
        $fdetails=$_POST['details'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        $fp = fopen($tmpName, 'r');
        $content = fread($fp, $fileSize);
        $content = addslashes($content);
        fclose($fp);

        if(!get_magic_quotes_gpc()){
            $fileName = addslashes($fileName);
        }
        $query_file = "INSERT INTO files (FID ,FName, FDetails, FSize, FType, FContent,DateUploaded ) VALUES ('$newref','$fileName', '$fdetails', '$fileSize', '$fileType', '$content','$date')";
        mysql_query($query_file) or die('Error, query insert into files failed');
        $query_rights = "INSERT INTO userfilerights (UserID, FID, R, W, O, V) VALUES ('$user_id', '$newref', '1', '1','1','1')";
        mysql_query($query_rights) or die('Error, query insert into iserfilerightsfailed');

        $logdetails ="User : ".$user_name." on ".$date." uploaded the following document ".$fileName;
        $max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
        $ref=mysql_query($max_ref,$conn) or die(mysql_error());
        $max=mysql_fetch_assoc($ref);
        $newref=(int)$max['id'];
        $newref="LOG".$newref;
        $query_logs = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
        mysql_query($query_logs) or die('Error, query failed');
        header("location:Documents.php?id=new");
    }


    mysql_select_db($database_conn, $conn);
    $query_ufile = "SELECT userfilerights.R, userfilerights.W, userfilerights.O
                    FROM   userfilerights
                    Left Join userdetails ON userfilerights.UserID = userdetails.UserID AND userdetails.UserID = '$uid' ";
    $ufile = mysql_query($query_ufile, $conn) or die(mysql_error());
    $row_ufile = mysql_fetch_assoc($ufile);
    $totalRows_ufile = mysql_num_rows($ufile);
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>::  Documents  ::</title>

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
                        Documents</h1>

                        <br />Below is a list of all docuemnts in the system<br /><br />

                       <?php //<td><b>Edit</b></td>
                       echo "<table border='1' cellspacing='0' cellpadding='0' width='90%'>
                                           <tr>
                                           <td><b>Name</b></td>
                                           <td><b>Details</b></td>
                                           <td><b>Download<b></td>
                                           <td><b>Delete</b></td>";
                       if($_SESSION['role_id']=='0')
                       {
                           echo "<td><b>A C L</b></td>";
                       }
                       echo "</tr>";
                       do {
                           //Condition to view files
                           if($row_files['O'] == 1 || $row_files['W'] == 1 || $row_files['R'] == 1 || $row_files['V'] == 1 || $_SESSION['role_id']=='0')
                           {
                               echo "<tr>";
                               echo"<td>".$row_files['FName']."</td>" ;
                               echo "<td>";
                               if($row_files['FDetails']!='')
                               {       echo $row_files['FDetails'];   }
                               else{   echo '&nbsp;';   }
                               echo "</td>" ;
                               //Condition to read
                               echo"<td>";
                               if($row_files['O'] == 1 || $row_files['W'] == 1 || $row_files['R'] == 1 || $_SESSION['role_id']=='0')
                               {       echo "<a href='file_download.php?id=".$row_files['FID']."'><img src='image/download.gif' width='16' height='16' border='0' /><font color='#666666'>download</font></a>" ;
                               }else{  echo '&nbsp;' ;  }
                               echo"</td>";

                               //Condition to write
                               echo"<td>";
                               if($row_files['O'] == 1 || $row_files['W'] == 1 || $_SESSION['role_id']=='0')
                               {     echo "<a href='file_delete.php?id=".$row_files['FID']."'><img src='image/b_drop.png' width='16' height='16' border='0' /><font color='#666666'>delete</font></a>" ;
                               }else{    echo '&nbsp;' ;    }
                               echo"</td>";

                               if($_SESSION['role_id']=='0')
                               {     echo"<td align='center'><a href='fileACL.php?id=".$row_files['FID']."'><img src='image/users.png' width='16' height='16' border='0' /><font color='#666666'>acl</font></a></td>" ;   }
                               echo "</tr>";
                           }
                           } while ($row_files = mysql_fetch_assoc($files));
                       echo "</table>"; ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">
                        <div id="NewDocument" align="left">


                            <table width="577" align="left" border="0" cellpadding="0" cellspacing="0" class="box">
                                <tr>
                                    <td colspan="2" align="left" valign="top"><h2>File Upload</h2></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">Browse file to upload</td>
                                    <td align="left" valign="top"><input name="userfile" type="file" class="box" id="userfile" /><br /><br /></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">File Details</td>
                                    <td align="left" valign="top"><textarea name="details" cols="50" id="details"></textarea><br /><br /></td>
                                </tr>
                                <tr><td width="400" align="left" valign="top"><br><br></td>
                                    <td width="80" align="left" valign="top"><input name="upload" type="submit"  class="box" id="upload" value="Upload" /></td>
                            </tr></table>
                    </div></td>
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
                    <td colspan="3"><DIV ALIGN="CENTER"><FONT SIZE="1" FACE="Tahoma">Copyright
                    2008 . All Rights Reserved</FONT></DIV></td>
                </tr>
                <tr>
                    <td colspan="3" BGCOLOR="#336666">&nbsp;</td>
                </tr>
        </table></form>
    </body>
</html>
<?php
mysql_free_result($files);
}else{
    header("location:login.php");
}

?>