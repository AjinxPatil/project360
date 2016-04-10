<?php
session_start();

require 'db.inc.php';
require 'functions.inc.php';

$user_id = $_SESSION['id'];
$group_id = get_group_id($db, $user_id);

echo '<h3 style="text-decoration:underline">Categories</h3><br />';
echo '<form name="category" action="messages.php" method="post">';
echo '<input type="radio" name="category" value="0" id="cat_General"/>General<br />';

$sql = 'SELECT id, name FROM msg_categories
		WHERE group_id = ' . $group_id;
$result = mysql_query($sql, $db) or die(mysql_error($db));
$row_num = mysql_num_rows($result);
if ($row_num != 0) {
	while ($row = mysql_fetch_assoc($result)) {
		echo '<input type="radio" name="category" value="' . $row['id'] . '" id="cat_' . $row['name'] . 
		'" />' . $row['name'] . '<br />';
	}
}
echo '<button class=".blueBtn" type="button" onclick="showCategory();">View</button>';
echo '</form>';
?>
<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js"></script>
<script type="text/javascript">
function showCategory()