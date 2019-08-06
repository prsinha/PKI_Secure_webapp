<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
$user_id = $_SESSION['user_id'];
$id_users = $_GET["id"];

if ($id_users!="") {
    include ('Connections/db_open.php');
    $logdetails ="User : ".$user_name." on ".$date." deleted the following user ".$row_user['Email'];
    $max_ref="select count(logdetails.LID) + 1 as id from logdetails ";
    $ref=mysql_query($max_ref,$conn) or die(mysql_error());
    $max=mysql_fetch_assoc($ref);
    $newref=(int)$max['id'];
    $newref="LOG".$newref;
    $query = "INSERT INTO logdetails  (LID, LDetails) VALUES ('$newref', '$logdetails')";
    mysql_query($query) or die('Error, query failed');


//get the common name from the database.
   $query_cn = "SELECT User_cn FROM userdetails WHERE UserID='$id_users'";
   $res_cn=mysql_query($query_cn,$conn) or die(mysql_error());
   $f_cn=mysql_fetch_assoc($res_cn);
   $del_cn=$f_cn['User_cn'];
//Delete LDAP entry using the common name.
   include "LdapEntry.php";
   $ldap1 = new LdapEntry();
   $ldap1->delete_from_ldap($del_cn);
//Delete SQL entry
    $sql = "DELETE FROM userdetails WHERE UserID='$id_users'";
    $result = @mysql_query($sql);
    $query="DELETE FROM userfilerights WHERE UserID='$id_users'";
    $resultquery=@mysql_query($query);


    include ('Connections/db_close.php');
    header("location:Users.php");/**/
}
else
{
    header("location:Users.php");
}
?>


<font color="#99CCFF">a</font>