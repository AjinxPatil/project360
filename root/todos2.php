<?php
session_start();
include_once "connect_to_mysql.php";
$nameoflist = $_GET['nameoflist'];
$assign = $_GET['assign'];
$uuid = $_SESSION['id'];
$tab = 'tt';
if (isset($_GET['t'])) {
	$tab = $_GET['t'];
}
$sql = mysql_query('SELECT cid, access_lvl FROM groupmembers WHERE id = ' . $uuid);
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


$sql5 = mysql_query("SELECT name, last_name FROM groupmembers WHERE id='$uuid'");
$row = mysql_fetch_array($sql5);
$name3 = $row["name"] . ' ' . $row['last_name'];
$last_name = $row["last_name"];
mysql_query("INSERT INTO feeds (nameoflist,assign,nameofuploader,type,feeddate,cid) 
     VALUES('$nameoflist','$assign','$name3','todo',now(),'". $_SESSION['cid'] ."')") 
?>
<html>
<head>
<link rel="stylesheet" href="design.css" type="text/css" />
<title>Project360: Adding Tasks</title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript">
function ajax_post(){
    
    var hr = new XMLHttpRequest();
	
	var assign = '<?php echo $assign; ?>';
	var name = '<?php echo $nameoflist; ?>';
    var url = "my_parse_file.php";
    var fn = document.getElementById("taskname").value;
	  
     var vars = "todo="+fn+"&name="+name+"&assign="+assign;
    hr.open("POST", url, true);
   
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    hr.send(vars); // Actually execute the request
  
}
$(document).ready(function() {
	//var defaultPage = $("#" + " echo $tab ").attr('href');
	$(".navBarLink").css({"background-color":"#00B8E6","color":"#FFF"});
	$("#" + "<?php echo $tab ?>").css({"background-color":"#FFF","color":"#00B8E6"});
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
<div id="sidebar"></div>
<div id="featContent">
<a href="emp_profile.php?id=<?php echo $id; ?>&t=tt"><button style="color:#FFFFFF" class="greyBtn">Back</button></a><br/>
<strong><?php echo $nameoflist; ?></strong><br />
<div id="status"></div><br /><br />
<input id="taskname" name="taskname" type="text" /> 
<button class="addBtn" name="addTask" type="submit" onClick="javascript:ajax_post();">Add Item</button>
</div>
</div>
<div id="footer"><span>Created by Parth Mody, Ajinkya Patil, Ankit Nair - DMCE, Navi Mumbai - 2012</span></div>
</div>
</body>
</html>