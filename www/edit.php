<?php 

$id_file = $_GET["id"];
$id_user=$_GET["uid"];
$r=$_GET["R"];
$w=$_GET["W"];
$o=$_GET["O"];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "manageusers")) {
  $updateSQL = sprintf("UPDATE userfilerights SET R=$r, W=$w, O=$o WHERE UserID=$id_user and FID=$id_file",
  						
               
                       );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  header("location:fileACL.php?id=$id_file");
}


?>