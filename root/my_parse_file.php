<?php 
session_start();
include_once "connect_to_mysql.php";
$userid = $_SESSION['id'];

	
$sql0 = mysql_query("SELECT * FROM groupmembers WHERE id = '$userid'");
	while($row = mysql_fetch_array($sql0))
	{
		$name2 = $row['name'];
	}
	



$name1 = $_POST['name'];
$assign = $_POST['assign'];
$token = $_POST['token'];

$todo = $_POST['todo'];

$sql1 = mysql_query("SELECT name FROM todo");
	while($row = mysql_fetch_array($sql1))
	{
		$nm = $row['name'];
		if($nm == $name1)
		{
			$flag = 1;
			}
		}
 $sql = mysql_query("INSERT INTO todo (todo,name,userid,assign,token,cid) 
     VALUES('$todo','$name1','$userid','$assign','$token','". $_SESSION['cid'] ."')")  
     or die (mysql_error());
	 
	 
	 
	  
	
	$sql3 = mysql_query("SELECT id, todo FROM todo WHERE name='$name1' ");
	while($row = mysql_fetch_array($sql3))
	{$todo1 = $row["todo"];

		$todofeed.='<ul id="main">
		<li id="items">' . $todo1 . '</li>
	</ul>';}
     


?>

<?php print "$todofeed"; ?>

<style type="text/css">
#main
{ list-style-image: url("Chk.JPG");

margin: 30px;}

#items
{
	font-family: Helvetica, Arial, sans-serif;
}
</style>