<?php require_once('Connections/conn.php'); ?>
<?php

    $id_files = $_GET["id"];
	
    if ($id_files!="") {
        include 'Connections/db_open.php';
        $sql = "SELECT * FROM files WHERE FID='$id_files'";
        $result = @mysql_query($sql);
        if($result)
        {
          $data = @mysql_result($result, 0, "FContent");
          $name = @mysql_result($result, 0, "FName");
          $size = @mysql_result($result, 0, "FSize");
          $type = @mysql_result($result, 0, "FType");
          header("Content-type: $type");
          header("Content-length: $size");
          header("Content-Disposition: attachment; filename=$name");
          header("Content-Description: PHP Generated Data");
          echo $data;  
		  
		  $logdetails ="User : ".$user_name." on ".$date." downloaded the following document ".$name;
			$max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
			$ref=mysql_query($max_ref,$conn) or die(mysql_error());
			$max=mysql_fetch_assoc($ref);
			$newref=(int)$max['id'];
			$newref="LOG".$newref;
			$query = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
        	mysql_query($query) or die('Error, query failed');
		  
        }
        else
        {
            echo "Error to download from MySQL DB";
			
			$logdetails ="User : ".$user_name." on ".$date." was not able to download file due to the following error 'Error to download from MySQL DB'";
			$max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
			$ref=mysql_query($max_ref,$conn) or die(mysql_error());
			$max=mysql_fetch_assoc($ref);
			$newref=(int)$max['id'];
			$newref="LOG".$newref;
			$query = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
        	mysql_query($query) or die('Error, query failed'); 
        }
        include 'Connections/db_close.php';
}
?>
