<?php
    global $conn;
/*	
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = '6120project';
*/
$dbhost = 'MySQLServer';
$dbuser = 'ssluser';
$dbpass = 'ssluser';
$dbname = '6120project';
 $conn = mysql_pconnect($dbhost, $dbuser, $dbpass, MYSQL_CLIENT_SSL) or die ('Error connecting to mysql');
mysql_select_db($dbname,$conn);
?>