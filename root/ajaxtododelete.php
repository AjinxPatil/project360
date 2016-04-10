<?php
session_start();

include_once "connect_to_mysql.php";
$todo = $_POST['todo'];
print "$todo";

$sql = mysql_query("DELETE FROM todo WHERE todo='$todo'");
?>