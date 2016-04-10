<?php
session_start();
include_once "connect_to_mysql.php";
$day = $_POST['day'];
$bp = $_POST['bp'];
$month = $_POST['month'];
$year = $_POST['year'];
$events = $_POST['events'];
$userid = $_SESSION['id'];
$milestone = $_POST['milestone'];

echo $total;

$sql = mysql_query("SELECT name,cid,last_name FROM groupmembers WHERE id='$id'");
while($row=mysql_fetch_array($sql))
{
	$cid = $row['cid'];
	$name = $row['name'] . ' ' . $row['last_name'];
	
	}
 

 mysql_query("INSERT INTO events (userid,month,day,year,events,milestone) 
     VALUES('$userid','$month','$day', '$year','$events','$milestone')") ; 
    
  mysql_query("INSERT INTO feeds (name,userid,feed,feeddate,type,cid) 
     VALUES('$name','$userid','$events', now(),'event',$cid)") ;



?>