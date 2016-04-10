<?php 

$db_host = "localhost";
// Place the username for the MySQL database here
$db_username = "projecti_1234"; 
// Place the password for the MySQL database here
$db_pass = "huzzah";
// Place the name for the MySQL database here
$db_name = "projecti_123";

mysql_connect("$db_host","$db_username","$db_pass") or die(mysql_error());
mysql_select_db("$db_name") or die("no database by that name");

?>