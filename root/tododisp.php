<?php
session_start();
$id = $_SESSION['id'];

require 'db.inc.php';
$sql231=mysql_query("Select name from groupmembers where cid = '$cid'");
 $list='<select name="assign" id="assign">';
 
while($row = mysql_fetch_array($sql231))
{$name1 = $row["name"];

$list .= '
   
   <option>' . $name1 . '</option>
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

ul.item{
width: 570px;}
</style>

<?php 
$ucheck_pic = "adList.JPG";
$pic9 = "<img src=\"$ucheck_pic\" width=\"58.26px\" height=\"19.42px\" border=\"0\" />";
?>
<div id="sidebar">
<div id="sidebox">
<table cellspacing="0" width="100%" cellpadding="10">
<tr><td id="sidetitle">Lists</td></tr>
<tr><td id="assigned1" class="sideitems">Your tasks</td></tr>
<tr><td id="all1" class="sideitems">All tasks</td></tr>
<tr><td id="completed1" class="sideitems">Completed tasks</td></tr>
</table>
</div>
</div>
<div id="featContent">
<a href="#" onClick="Show_Popup()"><button id="addBtn">New List</button></a>
<div id="area">
<?php
$sql10 = mysql_query("SELECT name,id FROM groupmembers WHERE id='$id' LIMIT 1");
while($rw1 = mysql_fetch_array($sql10))
{$name2 = $rw1["name"];}

$sql11 = mysql_query("SELECT DISTINCT name FROM todo WHERE assign='$name2' AND iscomplete = '0' ORDER BY time DESC");
$todofeed .= ' <ul id="nav2">';     	 
while($row = mysql_fetch_array($sql11))
{
	$name1 = $row["name"];
	
	$todofeed.='<br/><br/><li class="title">' . $name1 . ' &nbsp;<a style="text-decoration:none;font-size:14px;" class = "edit" href="todos.php?name=' . $name1 . '">Edit</a></li>';
	
	
	$sql33 = mysql_query("SELECT id, todo FROM todo WHERE name='$name1' AND  assign='$name2' ");
	while($row = mysql_fetch_array($sql33))
	{$todo1 = $row["todo"];

		$todofeed.='<ul class="item">
		<li id="' . $todo1 . '" class="items">' . $todo1 . '<button class="redBtn" id="btn' . $todo1 . '" onclick="ajaxdelete(\'' . $todo1 . '\')">Complete</button></li>
	</ul>';}
	$todofeed .= '<br/><br/><br/>'; }
$todofeed .= '</ul>';   
print "$todofeed";
?>
</div>
<!--/*main*/-->
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
$sql5 = mysql_query("SELECT id,cid FROM groupmembers WHERE id='". $_SESSION['id'] ."' LIMIT 1");
while($rw = mysql_fetch_array($sql5))
{$token = $rw["token"];
$cid1 = $rw["cid"];

}

$sql2 = mysql_query("SELECT DISTINCT name,assign FROM todo WHERE cid = '$cid1' ORDER BY time DESC");
$todofeed1 .= ' <ul id = "nav">';
     	 
while($row = mysql_fetch_array($sql2))
{	$assigned = $row["assign"];
	$name1 = $row["name"];
	$todofeed1 .='<br/><br/><li class="title">' . $name1 . ' &nbsp;<a class = "edit" href="todos.php?name=' . $name1 . '">Edit</a></li>';
	$todofeed1 .='<br/>&nbsp;&nbsp;Assigned to: ' . $assigned . '';
	
	$sql3 = mysql_query("SELECT id, todo FROM todo WHERE name='$name1' AND cid = '$cid1' ");
	while($row = mysql_fetch_array($sql3))
	{$todo1 = $row["todo"];

		$todofeed1 .='<ul class="item">
		<li class="itemsall">' . $todo1 . '</li>
	</ul>';}
	$todofeed1 .= '<br/><br/><br/>'; }
$todofeed1 .= '</ul>';     
 ?>
 <div id="mainfeed">
<?php 
print "$todofeed1";
?>
</div>
<div id="completed">
<?php
$sql10 = mysql_query("SELECT name,id FROM groupmembers WHERE id='$id' LIMIT 1");
while($rw1 = mysql_fetch_array($sql10))
{$name2 = $rw1["name"];}

$sql11 = mysql_query("SELECT DISTINCT name FROM todo WHERE assign='$name2' AND iscomplete = '1' ORDER BY time DESC");
$todofeed5 .= ' <ul id="nav2">';     	 
while($row = mysql_fetch_array($sql11))
{
	$name1 = $row["name"];
	
	$todofeed5.='<br/><br/><li class="title">' . $name1 . ' &nbsp;<a class = "edit" href="todos.php?name=' . $name1 . '">Edit</a></li>';
	
	
	$sql33 = mysql_query("SELECT id, todo FROM todo WHERE name='$name1' AND  assign='$name2' ");
	while($row = mysql_fetch_array($sql33))
	{$todo1 = $row["todo"];

		$todofeed5.='<ul class="item">
		<li id="' . $todo1 . '" class="itemsassigned">' . $todo1 . '</li>
	</ul>';}
	$todofeed5 .= '<br/><br/><br/>'; }
$todofeed5 .= '</ul>';   
print "$todofeed5";
?>
</div>





</div>
<div id="popup" style="display: none;"><h5>gjerlgj</h5></div>
<div id="window" style="display: none;">
<div id="popup_content" ><a href="#" onClick="Close_Popup();">Close</a>
<div id="pophead">Add New List</div>
<form action="todos2.php">
<b>Name of list:</b><input name="nameoflist" id="namepopup" type="text" />
<br/><br/><b>Assigned to:&nbsp;</b><?php print "$list"; ?><br />
<input type="submit" align="middle" name="Submit" value="Submit Form" />
<input type="hidden" name="id" id="id" value="<?php echo $id ;?>" />
</form>
</div>
</div>
  <script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script> 
   <script type="text/javascript">
   
   $('#assigned1').click(function()
   {
    $('#area').show();
	$('#mainfeed').hide();
	$('#completed').hide();
   return false;
	   });
	   $('#all1').click(function()
   {
    $('#mainfeed').show();
	$('#area').hide();
	$('#completed').hide();
   return false;
	   });
	    $('#completed1').click(function()
   {
    $('#completed').show();
	$('#area').hide();
	$('#mainfeed').hide();
   return false;
	   });
	/*$('#items').hover(
  function () {
    $(this).append($('#deletebtn'));
  }, 
  function () {
     $("#deletebtn").remove();
  }
);*/
	  
	   
   </script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript">

function ajaxdelete(x){
    //$("#form1").hide();
	
	 var hr = new XMLHttpRequest();
     var url = "ajaxtododelete.php";
    

     var vars = "todo="+x;
    hr.open("POST", url, true);
   
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    hr.send(vars); 
	 $("#btn"+x).click(function()
   {
    $("#"+x).fadeOut();
	   });
  
}
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
border-radius:5px;
border: 10px solid rgba(219, 219, 219, 0.3);
padding: 10px;
}

li.items {
   
   margin: 0;
   
   border-bottom: 1px solid #ccc;
   
   
   
   list-style-image: url("tick3.png");
}
li.itemsall {
   
   margin: 0;
   
   border-bottom: 1px solid #ccc;
   
   
   
   list-style-image: url("tick2.png");
}
li.itemsassigned {
   
   margin: 0;
   
   border-bottom: 1px solid #ccc;
   
   
   
   list-style-image: url("tick1.png");
}
li.title
{font-weight: bold;
	}
	
li
{}
	
/*#button
{position:relative;
bottom:120px;
border-radius: 5px;
border:thick;}*/

#buttons
{}

#area
{display:none;

position:relative;
left:35px;
width:550px;
}
#mainfeed
{
position:relative;
left:35px;
width:550px;
}
#completed
{display:none;

position:relative;
left:35px;
width:550px;
}
#nav
{

width:550px;

}

#nav2
{

/*position:relative;
left:35px;
*/
}
#pophead
{color:#333333;
background-color:#00CCFF;
font-size:30px;
padding:5px;}
#namepopup
{width:100%;
height:22px;}
#addBtn
{
	-webkit-box-shadow: rgba(0, 0, 0, 0.199219) 0px 1px 0px 0px;
	background: transparent url("../images/addtask.png") center left no-repeat;
	background-color: #999999;
	border-bottom-color:#333;
	border:0;
	box-shadow: rgba(0, 0, 0, 0.199219) 0px 1px 0px 0px;
	color: #FFF;
	font-size: 12px;
	height: 35px;
	padding:5px;
	text-decoration:none;
	cursor:pointer;
	text-indent:28px;
	text-shadow: 0px 1px 2px #555;
	border-radius:2px;
}
	
</style>