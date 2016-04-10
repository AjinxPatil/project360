<?php
session_start();
require './includes/auth.inc.php';
require './includes/db.inc.php';
require './includes/functions.inc.php';
$user_id = $_SESSION['id'];

$sql = 'SELECT cid, access_lvl FROM groupmembers WHERE id = ' . $user_id;
$result = mysql_query($sql, $db) or die(mysql_error($db));
while($row = mysql_fetch_assoc($result)) {
	$access_lvl = $row['access_lvl'];
}
?>

<html>
<head>
<title>Project360 - Dashboard</title>
<link rel="stylesheet" href="design.css" type="text/css" />
</head>

<body>
<div id="container">
<!-- START Header & Main Menu -->
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
<div id="hSiteLogo"><img src="images/logo.png" width="240" height="100" align="middle" /></div>
<div id="hContent">
  <div id="hProjectBar">
  	<!-- --START-- Project & Group information -->
    <h2 class="hProjectDetail">&nbsp;&nbsp;&nbsp;My Project</h2></div>
    <!-- --END-- Project & Group information -->
  <ul id="navList">
	<li class="navBarItem"><a class="navBarLink" href="dashboard.php">Dashboard</a></li>
	<li class="navBarItem"><a class="navBarLink" href="messages.php">Messages</a></li>
    <li class="navBarItem"><a class="navBarLink" href="discussions.php" onClick="alert('Under development')">Discussions</a></li>
	<li class="navBarItem"><a class="navBarLink" href="tasks.php">Tasks</a></li>
    <li class="navBarItem"><a class="navBarLink" href="calendar.php">Calendar</a></li>
	<li class="navBarItem"><a class="navBarLink" href="#" onClick="alert('Under development')">Files</a></li>
	<li class="navBarItem"><a class="navBarLink" href="#" onClick="alert('Under development')">Time Tracking</a></li>
	<li class="navBarItem"><a class="navBarLink" href="chat.php">Chat</a></li>
  </ul>
  </div>
</div>
<!-- END Header & Main Menu -->
<div id="mainContent">
<div id="sidebar"></div>
<div id="featContent">
<?php
$file_img = '<img class="feedIndicator" src="./images/ifile.png" />';
$event_img = '<img class="feedIndicator" src="./images/ievent.png" />';
$task_img = '<img class="feedIndicator" src="./images/itask.png" />';
$msg_img = '<img class="feedIndicator" src="./images/imsg.png" />';
$group_id = get_group_id($db, $user_id);
$sql = "SELECT * FROM feeds WHERE cid='$group_id' ORDER BY feeddate DESC LIMIT 20";
$result = mysql_query($sql, $db) or die(mysql_error($db));
while ($row = mysql_fetch_assoc($result)) {
	$name = $row["name"];
	$user_id = $row["userid"];
	$ufeed = $row["feed"];
	$feeddate = get_cool_date($row["feeddate"], 'DATETIME');
	$type = $row["type"];
	$nameofuploader = $row["nameofuploader"];
	$sql = mysql_query("SELECT last_name FROM groupmembers WHERE name='$nameofuploader'");
	$nameoflist = $row["nameoflist"];
	$assign = $row["assign"];
	$title = $row["Title"];
	$location = $row["FileLocation"];
	if ($type == "file") {
		$feed .= '<table frame="below" width="100%" cellspacing="0">
        			<tr><br/><td width="7%" bgcolor="#FFFFFF">' . $file_img . '<br /></td>
					<td width="93%" class = "border" >' . $nameofuploader . '  added a file <a href="' . 
					$row['FileLocation'] . '" class = "filetext">       ' . $title .
					'</a><br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate .
					'</span></td></tr></table>';
	} else if ($type == "todo") {
		$feed .= '<table frame="below" width="100%" cellspacing="0">
			        <tr><br/><td width="7%" bgcolor="#FFFFFF">' . $task_img . '<br /></td>
					<td width="93%" class = "border" >' . $nameofuploader . ' assigned task list "' . $nameoflist .
					'" to ' . $assign . '<br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate .
					'</span></td></tr></table>';
	} else if ($type == "event") {
		$feed .= '<table frame="below" width="100%" cellspacing="0">
        			<tr><br/><td width="7%" bgcolor="#FFFFFF">' . $event_img . '<br /></td>
					<td width="93%" class = "border" >' . $name . ' added an event &nbsp;"' . $ufeed .
					'"<br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate .
					'</span></td></tr></table>';
	} else if ($type == "message") {
		$feed .= '<table frame="below" width="100%" cellspacing="0">
					<tr><br/><td width="7%" bgcolor="#FFFFFF">' . $msg_img . '<br /></td>
					<td width="93%" class = "border" >' . $nameofuploader . ' added a message &nbsp;"' . $title .
					'"<br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate .
					'</span></td></tr></table>';
	}
}
echo $feed;
?>
</div>
</div>
</div>
<?php include './includes/footer.inc.php'; ?>
</body>
</html>



