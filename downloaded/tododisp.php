<?php
session_start();
$uid = $_GET['id'];
$id = $_SESSION['id'];

include_once "connect_to_mysql.php";
$sql3 = mysql_query("SELECT id, name FROM groupmembers  ");
$list='<select name="assign" id="assign">';
while($row = mysql_fetch_array($sql3))
{$name = $row["name"];

$list .= '
   
   <option>' . $name . '</option>
   ';
	}

$list.='</select>';	
?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
function Show_Popup(action, userid) {
$('#popup').fadeIn('fast');
$('#window').fadeIn('fast');
}
function Close_Popup() {
$('#popup').fadeOut('fast');
$('#window').fadeOut('fast');
}
</script>
<style type="text/css">
li.items {
	width: 640px;
	
}
ul.item{
width: 680px;}
</style>
<?php 
$ucheck_pic = "adList.JPG";
$pic9 = "<img src=\"$ucheck_pic\" width=\"116.52px\" height=\"38.84px\" border=\"0\" />";
?>
<div align="right"  onClick="Show_Popup()" ><a id="button" href="#"><?php echo $pic9; ?> </a></div>
<html dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<!-- Start css3menu.com HEAD section -->
	<link rel="stylesheet" href="fgg_files/css3menu1/style.css" type="text/css" /><style>._css3m{display:none}</style>
	<!-- End css3menu.com HEAD section -->
	
</head>
<body style="background-color:#EBEBEB">

<!-- Start css3menu.com BODY section -->
<ul id="css3menu1" class="topmenu2">
	<li class="topfirst"><a href="#" style="height:18px;line-height:18px;"  id="assigned">Assigned</a></li>
	<li class="toplast"><a href="#" style="height:18px;line-height:18px;"  id="all">All</a></li>
</ul><p class="_css3m"><a href="http://css3menu.com/">CSS Menu Li Css3Menu.com</a></p>
<!-- End css3menu.com BODY section -->

</body>
</html>
<div id="area">
<?php
$sql10 = mysql_query("SELECT name,id FROM groupmembers WHERE id='$id' LIMIT 1");
while($rw1 = mysql_fetch_array($sql10))
{$name2 = $rw1["name"];}

$sql11 = mysql_query("SELECT DISTINCT name FROM todo WHERE assign='$name2'");
$todofeed .= ' <ul>';     	 
while($row = mysql_fetch_array($sql11))
{
	$name1 = $row["name"];
	$todofeed.='<br/><br/><li class="title">' . $name1 . ' &nbsp;<a class = "edit" href="todos.php?name=' . $name1 . '">Edit</a></li>';
	
	$sql33 = mysql_query("SELECT id, todo FROM todo WHERE name='$name1' AND  assign='$name2' ");
	while($row = mysql_fetch_array($sql33))
	{$todo1 = $row["todo"];

		$todofeed.='<ul class="item">
		<li id="items">' . $todo1 . '</li>
	</ul>';}
	$todofeed .= '<br/><br/><br/>'; }
$todofeed .= '</ul>';   
print "$todofeed";
?>

</div>
<div id="popup" style="display: none;"><h5>gjerlgj</h5></div>
<div id="window" style="display: none;">
<div id="popup_content" ><a href="#" onclick="Close_Popup();">Close</a>
<form action="todos2.php">
Name of list:<input name="nameoflist" type="text" />
Assigned to:<?php print "$list"; ?><br />
<input type="submit" name="Submit" value="Submit Form" />
<input type="hidden" name="id" id="id" value="<?php echo $uid ;?>" />
</form>

<?php 
include_once "connect_to_mysql.php";


if (isset($_POST['nameoflist'])){
	$nameoflist = $_POST['nameoflist'];
	$assign = $_POST['assign']; 
	$sql = mysql_query("INSERT INTO test (nameoflist) 
     VALUES('$nameoflist')")  
     or die (mysql_error()); }
	 include_once "connect_to_mysql.php";



$cnlink = '<a href="todos2.php?id=' . $userid . '">Create new List</a>';
$sql5 = mysql_query("SELECT token,id FROM groupmembers WHERE id='$id' LIMIT 1");
while($rw = mysql_fetch_array($sql5))
{$token = $rw["token"];}

$sql2 = mysql_query("SELECT DISTINCT name FROM todo WHERE token='$token'");
$todofeed .= ' <ul id = "nav">';     	 
while($row = mysql_fetch_array($sql2))
{
	$name1 = $row["name"];
	$todofeed.='<br/><br/><li class="title">' . $name1 . ' &nbsp;<a class = "edit" href="todos.php?name=' . $name1 . '">Edit</a></li>';
	
	$sql3 = mysql_query("SELECT id, todo FROM todo WHERE name='$name1' AND  token='$token' ");
	while($row = mysql_fetch_array($sql3))
	{$todo1 = $row["todo"];

		$todofeed.='<ul class="item">
		<li id="items">' . $todo1 . '</li>
	</ul>';}
	$todofeed .= '<br/><br/><br/>'; }
$todofeed .= '</ul>';     





 ?>

 </div>
</div>
<div id="mainfeed">
<?php 
print "$todofeed";

?>
</div>
  <script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script> 
   <script type="text/javascript">
   
   $('#assigned').click(function()
   {
    $('#area').show();
	$('#mainfeed').hide();
   return false;
	   });
	   $('#all').click(function()
   {
    $('#mainfeed').show();
	$('#area').hide();
   return false;
	   });
	  
	   
   </script>
<style type="text/css">
#popup {
height: 100%;
width: 100%;
background: #000000;
position: absolute;
top: 0;
-moz-opacity:0.75;
-khtml-opacity: 0.75;
opacity: 0.75;
filter:alpha(opacity=75);
}
#window {
width: 600px;
height: 300px;
margin: 0 auto;
border: 1px solid #000000;
background: #ffffff;
position: absolute;
top: 200px;
left: 25%;
}

li#items {
   font-weight: bold;
   margin: 0;
   padding: 3px 10px 5px 20px;
   border-bottom: 1px solid #ccc;
   
   
   
   list-style-image: url("Chk.JPG");
}
li.title
{font-weight: bold;
	}
	
li
{}
a.edit:hover
{background-color:#0000FF}	
#button
{position: absolute;
right: 600px;
top: 50px;
border-radius: 5px;
border:thick;}
#area
{display:none;}
</style>