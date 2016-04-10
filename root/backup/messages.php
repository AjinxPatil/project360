<?php
session_start();

//require '../includes/auth.inc.php';
require 'db.inc.php';
require 'functions.inc.php';

$user_id = $_SESSION['id'];
$group_id = get_group_id($db, $user_id);
if (!isset($_GET['c'])) {
	$category_id = 0;
} else {
	$category_id = $_GET['c'];
}
$sql = 'SELECT id, name FROM msg_categories
		WHERE group_id = ' . $group_id;
$result_cat = mysql_query($sql, $db) or die(mysql_error($db));
$row_num = mysql_num_rows($result_cat);
$sql = 'SELECT msg_id, author_id, subject, name, last_name, date_posted, date_updated, last_update 
		FROM msg_posts AS p, groupmembers AS m 
		WHERE m.cid = p.group_id AND m.id = p.author_id AND p.topic_id = 0 AND p.group_id = ' . $group_id . ' 
		AND p.category_id = ' . $category_id . '
		ORDER BY last_update DESC';
$result = mysql_query($sql, $db) or die(mysql_error($db));
/*
-----
Write here, the code for displaying a message notification if there are no messages for a specific group
-----
*/ 
?>
<div id="sidebar">
<?php
echo '<h3 style="text-decoration:underline">Categories</h3><br />';
echo '<form name="category_form" method="post" aciton="emp_profile.php?id=' . $user_id . '&t=tdcs">';
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
<table cellspacing="0" width="100%" cellpadding="5">
 <tr>
  <td style="border-bottom:1px solid #0066CC"><span class="featTitle">Messages</span></td>
  <td style="text-align: right;border-bottom:1px solid #0066CC"><a id="newMsgLink" href="composemsg.php"><button class="addBtn" type="button">New Message</button></a></td>
 </tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
	echo '<tr>';
    echo '<td colspan="2"><a class="topicLinks" href="showtopic.php?f=' . 
			$row['msg_id'] . '">' . $row['subject'] . '</a></td></tr>';
	echo '<tr>';
	echo '<td style="border-bottom:1px solid #333"><span style="font-size:14">By ' . $row['name'] . '&nbsp;' . $row['last_name'];
	echo '</span></td><td style="border-bottom:1px solid #333;text-align: right"><span style="font-size:14">&nbsp;&nbsp;&nbsp;';
	if ($row['date_posted'] == $row['last_update']) {
		$date_posted = get_cool_date($row['date_posted']);
		echo 'Posted on ' . $date_posted;
	} else {
		$date_updated = get_cool_date($row['last_update']);
		echo 'Updated on ' . $date_updated;
	}
	echo '</span></td></tr>';
}
?>
</table>
</div>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript">
$(".topicLinks").click(function() {
	var page = $(this).attr('href');
	$("#mainContent").load(page);
});
$("#newMsgLink").click(function() {
	var page = $(this).attr('href');
	$("#mainContent").load(page);
});
</script>