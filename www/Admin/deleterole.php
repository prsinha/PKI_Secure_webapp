<?php require_once('../Connections/conn.php'); ?>
<?php
	session_start();
    $user_id = $_SESSION['user_id'];
    $id_role = $_GET["id"];
	
    if ($id_role!="") {
        include '../Connections/db_open.php';
        $sql = "DELETE FROM roles WHERE RID=$id_role";
        $result = @mysql_query($sql);
		
        include '../Connections/db_close.php';
        header("location:addroles.php");
    }
	else
	{
	header("location:addroles.php");
	}
?>

