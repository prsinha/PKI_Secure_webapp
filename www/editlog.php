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
        $id_log=$_GET['id'];
        
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


    mysql_select_db($database_conn, $conn);
	$query_logdet = "SELECT * FROM logdetails where LID='$id_log'";
	$logdet = mysql_query($query_logdet, $conn) or die(mysql_error());
	$row_logdet = mysql_fetch_assoc($logdet);
	$totalRows_logdet = mysql_num_rows($logdet);
    
   
        if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) 
        {
          $updateSQL = sprintf("UPDATE logdetails SET LArchived=%s where LID='$id_log'",
          GetSQLValueString(isset($_POST['LArchived']) ? "true" : "", "defined","1","0"));
          $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error()); 
		 echo "<SCRIPT language=JavaScript>myscript();</SCRIPT>";
        }
    
?>
<form method="POST" id=="form" name="form">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><h1>Edit Log Details</h1></td>
  </tr>
  <tr>
    <td width="53">&nbsp;</td>
    <td width="243"><b>Log Details</b><br><br></td>
    
  </tr>
  <tr>
    <td width="53">&nbsp;</td>
    <td width="243"><em><?php echo $row_logdet['LDetails']?></em><br><br></td>
   
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Archive this log  ::  
	 <input <?php if (!(strcmp($row_logdet['LArchived'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" name="LArchived" id="LArchived"><br><br>    </td>
  
   </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><input type="submit" name="update" id="update" value="Update">&nbsp;&nbsp;
    &nbsp;&nbsp; <input type="submit" name="cancel" id="cancel" value="Cancel" onclick="window.close()"> </td>
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

?>

