<SCRIPT language=JavaScript>
function myscript(){
window.opener.location.href=window.opener.location.href; // refresh the main page
window.opener.focus(); // focus on the main page
window.close(); // close the popup page
}
</SCRIPT>
<?php
    require_once('Connections/conn.php');
    mysql_select_db($database_conn, $conn);
    $date =date("Y/m/d");
    session_start();
    if(isset($_SESSION['user_name']))
    {
        $id_files=$_GET['id'];
        $id_user=$_GET['uid'];
        if (!function_exists("GetSQLValueString"))
        {
            function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
            {
                $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
                $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
                switch ($theType)
                {
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

        $query_filerights = "SELECT userfilerights.R, userfilerights.W, userfilerights.O , userfilerights.V
        FROM userfilerights WHERE userfilerights.UserID =  '$id_user' AND userfilerights.FID =  '$id_files'";
        $filerights = mysql_query($query_filerights, $conn) or die(mysql_error());
        $row_filerights = mysql_fetch_assoc($filerights);

        $query_udet = "SELECT CONCAT(userdetails.FName,' ',userdetails.MName,'. ',userdetails.LName) AS Names
        FROM userdetails WHERE  UserID =  '$id_user' ";
        $udet = mysql_query($query_udet, $conn) or die(mysql_error());
        $row_udet = mysql_fetch_assoc($udet);

        $query_filedet = "SELECT * FROM files WHERE  FID = '$id_files'";
        $filedet = mysql_query($query_filedet, $conn) or die(mysql_error());
        $row_filedet = mysql_fetch_assoc($filedet);

        $query_ufright = "SELECT count(userdetails.UserID) as id FROM userdetails Inner Join userfilerights ON userfilerights.UserID = userdetails.UserID WHERE userdetails.UserID =  '$id_user'  and  userfilerights.FID='$id_files'";
        $ufright = mysql_query($query_ufright, $conn) or die(mysql_error());
        $row_ufright = mysql_fetch_assoc($ufright);
    
        $x=$row_ufright['id'];
        if($x=='1')
        {
            if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form"))
            {
              $updateSQL = sprintf("UPDATE userfilerights SET R=%s, W=%s, O=%s , V=%s WHERE UserID='$id_user' AND FID='$id_files'",
                                   GetSQLValueString(isset($_POST['read']) ? "true" : "", "defined","1","0"),
                                   GetSQLValueString(isset($_POST['write']) ? "true" : "", "defined","1","0"),
                                   GetSQLValueString(isset($_POST['own']) ? "true" : "", "defined","1","0"),
                                   GetSQLValueString(isset($_POST['view']) ? "true" : "", "defined","1","0"));
              $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
/*
              $filerights = mysql_query($query_filerights, $conn) or die(mysql_error());
              $row_filerights = mysql_fetch_assoc($filerights);
              $udet = mysql_query($query_udet, $conn) or die(mysql_error());
              $row_udet = mysql_fetch_assoc($udet);
              $filedet = mysql_query($query_filedet, $conn) or die(mysql_error());
              $row_filedet = mysql_fetch_assoc($filedet);
              $ufright = mysql_query($query_ufright, $conn) or die(mysql_error());
              $row_ufright = mysql_fetch_assoc($ufright);*/
              echo "<SCRIPT language=JavaScript>myscript();</SCRIPT>";
            }
        }
        elseif($x=='0')
        {
            if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
                $insertSQL = sprintf("INSERT INTO userfilerights (UserID, FID, R, W, O, V) VALUES (%s, %s, %s, %s, %s, %s)",
                               GetSQLValueString($id_user, "text"),
                               GetSQLValueString($id_files,"text"),
                               GetSQLValueString(isset($_POST['read']) ? "true" : "", "defined","1","0"),
                               GetSQLValueString(isset($_POST['write']) ? "true" : "", "defined","1","0"),
                               GetSQLValueString(isset($_POST['own']) ? "true" : "", "defined","1","0"),
                               GetSQLValueString(isset($_POST['view']) ? "true" : "", "defined","1","0"));
                $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
/*
              $filerights = mysql_query($query_filerights, $conn) or die(mysql_error());
              $row_filerights = mysql_fetch_assoc($filerights);
              $udet = mysql_query($query_udet, $conn) or die(mysql_error());
              $row_udet = mysql_fetch_assoc($udet);
              $filedet = mysql_query($query_filedet, $conn) or die(mysql_error());
              $row_filedet = mysql_fetch_assoc($filedet);
              $ufright = mysql_query($query_ufright, $conn) or die(mysql_error());
              $row_ufright = mysql_fetch_assoc($ufright);*/
               echo "<SCRIPT language=JavaScript>myscript();</SCRIPT>";
            }
        }
?>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<table width="486" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="left" valign="top"><h2>Editing <?php echo $row_udet['Names']." rights on file ". $row_filedet['FName']; ?></h2></td>
  </tr>
  <tr>
    <td  align="left" valign="top">Own</td>
    <td align="left" valign="top">Write</td>
    <td align="left" valign="top">Read</td>
    <td  align="left" valign="top">View</td>
  </tr>
  <tr>
    <td align="left" valign="top"><input <?php if (!(strcmp($row_filerights['O'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="own" id="own"></td>
    <td align="left" valign="top"><input <?php if (!(strcmp($row_filerights['W'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="write" id="write"></td>
    <td align="left" valign="top"><input <?php if (!(strcmp($row_filerights['R'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="read" id="read"></td>
    <td align="left" valign="top"><input <?php if (!(strcmp($row_filerights['V'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="view" id="view"></td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><input type="submit" name="Update" id="Update" value="Update" onClick="refresh();"  ></td>
    </tr>
</table>
<input type="hidden" name="MM_update" value="form" />
<input type="hidden" name="MM_insert" value="form" />
</form>
<?php 
}
else
{
    header("location:login.php");
}
mysql_free_result($udet);
mysql_free_result($filedet);
mysql_free_result($filerights);
refresh();
?>
<SCRIPT language=JavaScript>
<!--
function refresh(){
 
//window.opener.location.href=window.opener.location.href; // refresh the main page
//window.opener.focus(); // focus on the main page

//window.close(); // close the popup page

}
-->
</SCRIPT>

