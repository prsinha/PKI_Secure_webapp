<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

/*	
$hostname_conn = "localhost";
$database_conn = "6120project";
$username_conn = "root";
$password_conn = "root";
*/
$hostname_conn = 'MySQLServer';
$username_conn = 'ssluser';
$password_conn = 'ssluser';
$database_conn = '6120project';
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn , MYSQL_CLIENT_SSL) or trigger_error(mysql_error(),E_USER_ERROR); 
?>