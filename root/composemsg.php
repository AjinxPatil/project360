<?php
session_start();
//require '../includes/auth.inc.php';
require 'db.inc.php';
require 'functions.inc.php';
$user_id = $_SESSION['id'];
$group_id = get_group_id($db, $user_id);
/*	a message can be composed from 3 ways - NEW (creating a new msg), EDIT (editing a msg), REPLY (replying a topic)
	$post_id var is set differently for NEW, EDIT, REPLY
	for NEW, $post_id = ''
	for EDIT, $post_id = $_GET['msg']
	for REPLY, $post_id = $_GET['topicid']

	for EDIT, redirection is from "composemsg.php?...&action=editpost"
	$_GET['msg'] contains the msg_id of the message to be edited
*/
$edit_action = FALSE;
if ($_GET['action'] == 'editpost' && isset($_GET['topicid']) && isset($_GET['msgid'])) {
    $edit_action = TRUE; // for EDIT
	$post_id = $_GET['msgid'];
	$topic_id = $_GET['topicid'];
} else if (isset($_GET['topicid'])) { 
    $post_id = $topic_id = $_GET['topicid'];  // for REPLY
} else {
    $post_id = $topic_id = 0; // for NEW
} 

$subject = '';
$body = '';
$author_id = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
if ($edit_action && $_SESSION['id'] != $author_id) { 
	/* for EDIT with wrong author. The condition is already checked in showtopic.php (EDIT button is hidden)
	   But, this rewritten condition prevents the user to access this page and edit a message by manually entering URL parameters
    */
	echo '<p><strong>You are not authorized to edit this message. Please contact your project manager.</strong></p>';
} else {
    if ($edit_action) {
		// for EDIT with correct author
        $sql = 'SELECT msg_id, author_id, subject, body 
				FROM msg_posts 
				WHERE msg_id = ' . $post_id;
        $result = mysql_query($sql, $db) or die(mysql_error($db));
        $row = mysql_fetch_assoc($result);
		$author_id = $row['author_id'];
        $subject = $row['subject'];
        $body = $row['body'];
		$submitname = 'Save Changes';
    } else {
		// for NEW or REPLY
        if ($post_id == 0) {
			// for NEW
            $topicname = 'New Message';
			$submitname = 'Post New Message';
        } else {
			// for REPLY
			$topicname = 'Reply'; 
			$submitname = 'Post Reply';
		}
	}
}
?>
<!-- default code START -->
<html>
<head>
<link rel="stylesheet" href="design.css" type="text/css" />
<script type="text/javascript" src="../scripts/jquery.js"></script>
</head>
<body>
<div id="container">
<div id="topLinks"></div>
<div id="hBar">
<div id="hSiteLogo"><a href="emp_profile.php?id=<?php echo $userid; ?>"><img src="../images/logo.png" width="240" height="90" align="middle" /></a></div>
<div id="hContent">
  <div id="hProjectBar"><h2 class="hProjectDetail">&nbsp;&nbsp;&nbsp;My Project</h2></div>
  <ul id="navList">
	<li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=ta">Overview</a></li>
    <li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=tib">Inbox</a></li>
    <li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=tdcs">Discussions</a></li>
    <li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=tt">Tasks</a></li>
    <li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=tcld">Calendar</a></li>
    <li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=tf">Files</a></li>
	<li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=ttt">Time Tracking</a></li>
    <li class="navBarItem"><a class="navBarLink" href="emp_profile.php?id=<?php echo $user_id; ?>&t=tc">Chat</a></li>
  </ul>
  </div>
</div>
</div>
<div id="leftContent"></div>
<div id="mainContent">
<!-- default code END -->
<h2><?php echo ($edit_action) ? ('Edit Message:' . $subject) : $topicname; ?></h2>
<form method="post" action="msg_transact.php">
<table width="40%">
 <tr>
  <td style="text-align: right;">Title:</td>
  <td><input type="text" name="subject" maxlength="255" size="78" value="<?php echo $subject; ?>"/></td>
 </tr>
 <tr>
  <td style="text-align: right;" valign="top">Message:</td>
  <td><textarea name="body" rows="10" cols="60"><?php echo $body; ?></textarea></td>
 </tr>
 <tr>
 <td align="left">
<?php
$sql = 'SELECT id, name FROM msg_categories
		WHERE group_id = ' . $group_id;
$result = mysql_query($sql, $db) or die(mysql_error($db));
$row_num = mysql_num_rows($result);
echo '<select name="category">';
echo '<option value="0" selected="selected">General</option><br />';
if ($row_num != 0) {
	while ($row = mysql_fetch_assoc($result)) {
		echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option><br />';
	}
echo '</select>';
}
?>
 </td>
 <td><span style="font-size:12px">Add Category:</span><input type="text" name="newCategory" /></td>
 </tr>
 <tr>
  <td colspan="2" align="right"><input type="submit" name="action" value="<?php echo $submitname; ?>" /></td>
 </tr>
</table>
 <input type="hidden" name="msg_id" value="<?php echo $post_id; ?>">
 <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
 <input type="hidden" name="author_id" value="<?php echo $author_id; ?>"></p>
</form>
<!-- default code START -->
</div>
</div>
</div>
</body>
</html>
<!-- default code END -->