<?php
session_start();
include 'db.inc.php';
$userid = $_SESSION['id'];
if (isset($_GET['name'])) {
	$name = $_GET['name'];
} else { /* else condition */ }
$sql = mysql_query("SELECT assign FROM todo WHERE name='$name' LIMIT 1 ");
$row = mysql_fetch_array($sql); 
$assign = $row["assign"];	
$tab = 'ta';
if (isset($_GET['t'])) {
	$tab = $_GET['t'];
}
$sql = mysql_query('SELECT cid, access_lvl FROM groupmembers WHERE id = ' . $userid);
while($row = mysql_fetch_assoc($sql)) {
	$access_lvl = $row['access_lvl'];
}
// --START-- For discussion system (this can be used for other features if categorization is coded)
if (isset($_POST['category'])) {
	$category_id = $_POST['category'];
} else {
	$category_id = 0;
}
// --END-- For dicussion system

?>
<html>
<head>
<link rel="stylesheet" href="design.css" type="text/css" />

<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js"></script>
<script type="text/javascript">
function ajax_post(x){
     var nm = '<?php echo $name; ?>';
	 var assign = '<?php echo $assign; ?>';
	
    var hr = new XMLHttpRequest();
    
    var url = "my_parse_file2.php";
    var fn = document.getElementById("first_name").value;
	  

     var vars = "todo="+fn+"&name="+nm+"&assign="+assign;
    hr.open("POST", url, true);
   
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    hr.send(vars); 
}
$(document).ready(function() {
	//var defaultPage = $("#" + "<?php echo $tab ?>").attr('href');
	$(".navBarLink").css({"background-color":"#00B8E6","color":"#FFF"});
	$("#tt").css({"background-color":"#FFF","color":"#00B8E6"});
	//$("#mainContent").load(defaultPage);
	$(".navBarLink").click(function() {
		$(".navBarLink").css({"background-color":"#00B8E6","color":"#FFF"});
		$(this).css({"background-color":"#FFF","color":"#00B8E6"});
		var page = $(this).attr('href');
		$("#featContent").html('<img style="display:block;margin:auto;" src="images/ajax-loader.gif" />').show().fadeOut(2000);;
		$("#mainContent").load(page);
		return false;
	});
	
});
</script>

</head>

<body>
<div id="container">
<div id="topLinks">
<a href="logout.php">Log out</a>
<?php
if ($access_lvl == 0) {
	echo '<a href="memberadd.php">Add Members</a>';
}
?>
</div>
<div id="hBar">
<div id="hSiteLogo"><img src="../images/logo.png" width="240" height="100" align="middle" /></div>
<div id="hContent">
  <div id="hProjectBar">
    <h2 class="hProjectDetail">&nbsp;&nbsp;&nbsp;My Project</h2></div>
  <ul id="navList">
	<li class="navBarItem"><a id="ta" class="navBarLink" href="feeds.php?id=<?php echo $userid; ?>">Overview</a></li>
	<li class="navBarItem"><a id="tib" class="navBarLink" href="inbox.php">Inbox</a></li>
    <li class="navBarItem"><a id="tdcs" class="navBarLink" href="messages.php?c=<?php echo $category_id; ?>">Discussions</a></li>
	<li class="navBarItem"><a id="tt" class="navBarLink" href="tododisp.php?id=<?php echo $userid; ?>">Tasks</a></li>
    <li class="navBarItem"><a id="tcld" class="navBarLink" href="calm.php?id=<?php echo $userid; ?>">Calendar</a></li>
	<li class="navBarItem"><a id="tf" class="navBarLink" href="upload.php?id=<?php echo $userid; ?>">Files</a></li>
	<li class="navBarItem"><a id="ttt" class="navBarLink" href="todos22.php?id=<?php echo $userid; ?>">Time Tracking</a></li>
	<li class="navBarItem"><a id="tc" class="navBarLink" href="chat.php?id=<?php echo $userid; ?>">Chat</a></li>
  </ul>
  </div>
</div> 
<div id="mainContent">
<div id="sidebar">
Name of List: <?php echo $name;?><br />
Assigned To: <?php echo $assign;?><br />
</div>
<div id="featContent">
Name of item: <input id="first_name" name="first_name" type="text" /> <br />
<div id="status"></div>
<br />
<button name="myBtn" type="submit" value="Add Item" class="addBtn" onClick="javascript:ajax_post();">Add Item</button>
</div>

</div>
<div id="footer"><span>Created by Parth Mody, Ajinkya Patil, Ankit Nair - DMCE, Navi Mumbai - 2012</span></div>
</div>
</body>
</html>




