<?php require_once('Connections/conn.php'); ?>
<?php
	session_start();
    $user_name = $_SESSION['user_name'];
    $id_files = $_GET["id"];
	
    if ($id_files!="") 
	{
		
	
		
	mysql_select_db($database_conn, $conn);
	$query_files = "SELECT * FROM files where  FID='$id_files'";
	$files = mysql_query($query_files, $conn) or die(mysql_error());
	$row_files = mysql_fetch_assoc($files);
	$totalRows_files = mysql_num_rows($files);
	
	
		
			$logdetails ="User : ".$user_name." on ".$date." deleted the following document ".$row_files['FName'];
			$max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
			$ref=mysql_query($max_ref,$conn) or die(mysql_error());
			$max=mysql_fetch_assoc($ref);
			$newref=(int)$max['id'];
			$newref="LOG".$newref;
			$query = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
        	mysql_query($query) or die('Error, query failed');
		
        include 'Connections/db_open.php';
        $sql = "DELETE FROM files WHERE FID='$id_files'";
        $result = @mysql_query($sql);
		$query="DELETE FROM userfilerights WHERE FID='$id_files'";
		$resultquery=@mysql_query($query);
		
		  
        include 'Connections/db_close.php';
        header("location:Documents.php");
    }
	else
	{
	header("location:Documents.php");
	}
?>


