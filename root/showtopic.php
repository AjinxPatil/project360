<?php
session_start();
require 'db.inc.php';
require 'functions.inc.php';
$user_id = $_SESSION['id'];
$tab = 'tdcs';
$group_id = get_group_id($db, $user_id);
if (isset($_GET['t'])) {
	$tab = $_GET['t'];
}
$sql = mysql_query('SELECT cid, access_lvl FROM groupmembers WHERE id = ' . $user_id);
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
if (!isset($_GET['f'])) {
    header('Location: emp_profile.php');
}
$sql = 'SELECT id, name FROM msg_categories
		WHERE group_id = ' . $group_id;
$result_cat = mysql_query($sql, $db) or die(mysql_error($db));
$row_num = mysql_num_rows($result_cat);
?>
<!-- default code START -->
<html>
<head>
<link rel="stylesheet" href="design.css" type="text/css" />
<style type="text/css">
.topic {
	background-color:#E0F5FF;
}
</style>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<!-- default code END -->
<script type="text/javascript">
$(document).ready(function() {
	//var defaultPage = $("#" + "<?php echo $tab ?>").attr('href');
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
function pipeDelete(topicid, msgid, action) {
	istopic = false;
	if (topicid == 0) {
		var ans = confirm("If you delete this message, all comments for the message will also be deleted as well. Are you sure you want to delete this message?");
		var istopic = true;
	} else {
		var ans = confirm("Are you sure you want to delete this comment?");
	}
	if (ans && !istopic) {
		var dest = 'msg_transact.php';
		$.post(dest, {topicid:topicid, msgid:msgid, action:action}, function() {
			$(".id" + msgid).fadeOut("slow");
		});
	} else if (ans & istopic) {
		var dest = 'msg_transact.php';
		$.post(dest, {topicid:topicid, msgid:msgid, action:action}, function() {
			window.location.replace("emp_profile.php?id=<?php echo $user_id; ?>&t=tdcs");
		});
	}
}
function pipeInsert(topicid,action) {
	var dest = 'msg_transact.php';
	<!--var subject = document.getElementById("subject").value;-->
	var msg = document.getElementById("msg").value;
		$.post(dest, {topicid:topicid, action:action, body:msg}, function(data) {
			$("#endoftopic").before('<table cellspacing="0" width="100%" cellpadding="5"><tr class="id' + data.msgid + ' new_row"><td rowspan="3" width="66" style="border-style:solid;border-width:0 0 1px 0;border-color:#000;"><div class="profilepic"></div></td><td><table cellspacing="0" width="100%"><tr class="id' + data.msgid + ' new_row"><td><span style="font-size:12px">You</span></td><td style="text-align: right"><span style="font-size:12">&nbsp;&nbsp;&nbsp;Posted on ' + data.date + '</span></td></tr></table></td></tr><tr class="id' + data.msgid + ' new_row"><td><p>' + data.comment + '</p></tr><tr class="id' + data.msgid + ' new_row"><td style="text-align: right;border-style:solid;border-width:0 0 1px 0;border-color:#000;">&nbsp;&nbsp;&nbsp;<a href="composemsg.php?topicid=' + topicid + '&msgid=' + data.msgid + '&action=editpost">Edit</a>&nbsp;&nbsp;&nbsp;<a href="#" onclick="pipeDelete(\'' + topicid + '\', \'' + data.msgid + '\', \'deletepost\'); return false;">Delete</a></td></tr></table>');
		}, 'json');
	//document.getElementById("subject").value = "";
	document.getElementById("msg").value = "";
}
</script>
<!-- default code START -->
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
	<li class="navBarItem"><a id="ta" class="navBarLink" href="feeds.php?id=<?php echo $user_id; ?>">Overview</a></li>
	<li class="navBarItem"><a id="tib" class="navBarLink" href="inbox.php">Inbox</a></li>
    <li class="navBarItem"><a id="tdcs" class="navBarLink" href="messages.php?c=<?php echo $category_id; ?>">Discussions</a></li>
	<li class="navBarItem"><a id="tt" class="navBarLink" href="tododisp.php?id=<?php echo $user_id; ?>">Tasks</a></li>
    <li class="navBarItem"><a id="tcld" class="navBarLink" href="calm.php?id=<?php echo $user_id; ?>">Calendar</a></li>
	<li class="navBarItem"><a id="tf" class="navBarLink" href="upload.php?id=<?php echo $user_id; ?>">Files</a></li>
	<li class="navBarItem"><a id="ttt" class="navBarLink" href="todos22.php?id=<?php echo $user_id; ?>">Time Tracking</a></li>
	<li class="navBarItem"><a id="tc" class="navBarLink" href="chat.php?id=<?php echo $user_id; ?>">Chat</a></li>
  </ul>
  </div>
</div> 
<div id="mainContent">
<div id="sidebar">
<?php
echo '<div style="background-color:#00B8E6;color:#FFF;text-align:center;padding:8px;font-weight:bold;cursor:default;">Categories</div>';
echo '<form name="category_form" method="post" action="emp_profile.php?id=' . $user_id . '&t=tdcs">';
echo '<input type="radio" name="category" value="0" id="cat_General" />General<br />';
if ($row_num != 0) {
	while ($row = mysql_fetch_assoc($result_cat)) {
		echo '<input type="radio" name="category" value="' . $row['id'] . '" id="cat_' . $row['name'] . 
		'" />' . $row['name'] . '<br />';
	}
}
echo '<br /><input type="submit" class="blueBtn" value="View" />';
echo '</form>';
?>
</div>
<div id="featContent">
<!-- default code END -->
<?php
$topic_id = $_GET['f'];
$user_id = $_SESSION['id'];
$group_id = get_group_id($db, $user_id);
// In this SQL query, one extra check can be added to verify the group_id
$sql = 'SELECT msg_id, topic_id, author_id, subject, name, last_name, date_posted, date_updated, body 
		FROM msg_posts AS p, groupmembers AS m
		WHERE author_id = m.id AND (topic_id = ' . $topic_id . ' OR msg_id = ' . $topic_id . ') AND p.group_id = ' . $group_id .
		' ORDER BY date_posted';
$result = mysql_query($sql,$db) or die(mysql_error($db));
$replylink = '<a href="#" onclick="pipeInsert(\'' . $topic_id . '\', \'comment\'); return false;"><button class="blueBtn">Comment</button></a>';
echo '<table cellspacing="0" width="100%" cellpadding="5">';

while ($row = mysql_fetch_assoc($result)) {
	//Here, $topic_id and $row['topic_id'] are not same. $topic_id var can never be zero
	
	$body = $row['body'];
	$editlink = '&nbsp;&nbsp;&nbsp;<a style="text-decoration:none;font-size:14px;" href="composemsg.php?topicid=' . $topic_id . '&msgid=' . $row['msg_id'] .
				'&action=editpost">Edit</a>';
	$deletelink = '&nbsp;&nbsp;&nbsp;<a style="text-decoration:none;font-size:14px;" href="#" onclick="pipeDelete(\'' . $row['topic_id'] . '\', \'' . 
				  $row['msg_id'] . '\', \'deletepost\'); return false;">Delete</a>';	
	if ($row['topic_id'] == 0) {
		echo '<tr class="id' . $row['msg_id'] . ' topic">';
	} else {
		echo '<tr class="id' . $row['msg_id'] . '">';
	}
	$memberpic = '<img align="middle" src="../memberFiles/' . $row['author_id'] . '/pic1.jpg" width="60px" height="60px" />'; 
	echo '<td rowspan="3" width="66" style="border-style:solid;border-width:0 0 1px 0;border-color:#000;"><div class="profilepic">' . $memberpic . '</div></td>';
	echo '<td><table cellspacing="0" width="100%">';
	if (isset($row['subject']) && $row['topic_id'] == 0) {
			echo ' <strong>' . $row['subject'] . '</strong>';
	}
	echo '<tr class="id' . $row['msg_id'] . '">';
	if ($row['author_id'] == $user_id) {
		echo '<td><span style="font-size:12px">You';
	} else {
		echo '<td><span style="font-size:12px">' . $row['name'] . '&nbsp;' . $row['last_name'];
	}
	echo '</span></td><td style="text-align:right"><span style="font-size:12px">&nbsp;&nbsp;&nbsp;';
	$date_updated = $row['date_updated'];
	if (!isset($date_updated)) {
		$date_posted = get_cool_date($row['date_posted']);
		echo 'Posted on ' . $date_posted;
	} else {
		$date_updated = get_cool_date($row['date_updated']);
		echo 'Updated on ' . $date_updated;
	}
	echo '</span></td></tr></table></td></tr>';
	if ($row['topic_id'] == 0) {
		echo '<tr class="id' . $row['msg_id'] . ' topic">';
	} else {
		echo '<tr class="id' . $row['msg_id'] . '">';
	}
	echo '<td>';
	echo '<p>' . $body . '</p>';
	//echo '<p>' . bbcode($db, nl2br(htmlspecialchars($body))) . '</p>';
	echo '</td></tr>';
	if ($row['topic_id'] == 0) {
		echo '<tr class="id' . $row['msg_id'] . ' topic">';
	} else {
		echo '<tr class="id' . $row['msg_id'] . '">';
	}
	echo '<td style="text-align: right;border-style:solid;border-width:0 0 1px 0;border-color:#000;">';
	if ($user_id == $row['author_id']) {
		//echo $editlink;
	}
	if ($user_id == $row['author_id'] || $access_lvl == '0') {
		//echo $deletelink;

	}
	echo '</td></tr>';
}
echo '</table><br />';
echo '<div id="endoftopic"></div>';
echo '<textarea id="msg" rows="3" cols="120"></textarea>';
echo '<div style="width:100%;text-align:left;margin:10px 0 0 0;">' . $replylink . '</div><br />';
echo '<div style="text-align:left;"><a href="emp_profile.php?id='. $user_id . '&t=tdcs"><button class="redBtn">&lt; All Messages</button></a></div>';

mysql_free_result($result);          
?>
<!-- default code START -->
</div>
</div>
</div>
</div>
</body>
</html>
<!-- default code END -->
