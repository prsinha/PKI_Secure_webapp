<?php 
	require_once('Connections/conn.php'); 
	session_start();

	$uid = $_SESSION['user_id'];
	mysql_select_db($database_conn, $conn);
	$query_fileACL = "SELECT CONCAT(userdetails.FName,' ',userdetails.MName,'. ',userdetails.LName) AS  Names FROM userdetails
	WHERE userdetails.UserID = '".$uid."'";
	$fileACL = mysql_query($query_fileACL, $conn) or die(mysql_error());
	$row_fileACL = mysql_fetch_assoc($fileACL);
	$totalRows_fileACL = mysql_num_rows($fileACL);
	mysql_select_db($database_conn, $conn);
	$query_newfiles = "SELECT FName, DateUploaded FROM files  WHERE DateUploaded = '$date'";
	$newfiles = mysql_query($query_newfiles, $conn) or die(mysql_error());
	$row_newfiles = mysql_fetch_assoc($newfiles);
	$totalRows_newfiles = mysql_num_rows($newfiles);

	if($_SESSION['role_id']=='0')
	{ 
		echo "Welcome <em>".$row_fileACL['Names']."</em><br><br>";
		echo "<font size='1'><table width='215' border='0' cellspacing='0' cellpadding='0'> 
		<tr> <td colspan='2' height='28' background='image/menuup.gif'> <div align='center'><FONT COLOR='#FFFFFF' FACE='Tahoma'><b>
		Admin Tasks</b></FONT></div></td></tr> <tr> <td width='9' height='76' background='image/menuleft.gif'>&nbsp;</td><td width='194' height='76'>
		<img src='image/dot.gif'  /><a href='users.php' style='color:#000000'>Manage Users</a><br />  
		<img src='image/dot.gif' /><a href='Documents.php' style='color:#000000'>Manage File ACL</a><br />
		<img src='image/dot.gif'  /><a target='_blank' href='../ldap/htdocs/index.php' style='color:#000000'>Connect to LDAP</a><br />
		<img src='image/dot.gif'  /><a href='managelogs.php' style='color:#000000'>Manage Logs</a><br />
		</td>
		</tr> 
		<tr> <td colspan='2' height='28' background='image/menudown.gif'>&nbsp;</td></tr> </table></font>";
	}
	else
	{
		echo "Welcome <em>".$row_fileACL['Names']."</em><br><br>";  
		echo "<font size='1'><table width='215' border='0' cellspacing='0' cellpadding='0'> 
		<tr> <td colspan='2' height='28' background='image/menuup.gif'> <div align='center'><FONT COLOR='#FFFFFF' FACE='Tahoma'><b>
		Todays New files...</b></FONT></div></td></tr> <tr> <td width='9' height='76' background='image/menuleft.gif'>&nbsp;</td><td width='194' height='76'>";
	do { 
        echo "<img src='image/dot.gif' >
		<a href='documents.php'><font color=#000000>".$row_newfiles['FName']."</font></a> <br>"; 
        } while ($row_newfiles = mysql_fetch_assoc($newfiles)); 
	echo"	</td>
			</tr> 
			<tr> <td colspan='2' height='28' background='image/menudown.gif'>&nbsp;</td></tr> </table></font>";
}
?>