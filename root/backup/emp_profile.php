<?php
session_start();
include 'db.inc.php';
$userid = $_SESSION['id'];
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
$(document).ready(function() {
	var defaultPage = $("#" + "<?php echo $tab ?>").attr('href');
	$(".navBarLink").css({"background-color":"#00B8E6","color":"#FFF"});
	$("#" + "<?php echo $tab ?>").css({"background-color":"#FFF","color":"#00B8E6"});
	$("#mainContent").load(defaultPage);
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
<a href="edit_info.php">Edit Profile</a>
<a href="edit_pic.php">Change Profile Image</a>
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
<div id="mainContent"></div>
</div>
<?php include './includes/footer.inc.php'; ?>

</body>
</html>



