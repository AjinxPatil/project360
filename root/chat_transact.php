<?php
session_start();
$user_id = $_SESSION['id'];
require './includes/db.inc.php';
require './includes/functions.inc.php';
$group_id = get_group_id($db, $user_id);

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 1: // For initializing the chat box
			$sql = 'SELECT *
					FROM ( SELECT c.im_id, c.i_msg, c.time, m.name, m.last_name, c.user_id
						   FROM instant_msg AS c, groupmembers AS m
						   WHERE c.user_id = m.id AND m.cid = ' . $group_id . '
						   ORDER BY c.time DESC LIMIT 50) AS chatbox
					ORDER BY time';
			$result = mysql_query($sql, $db) or die(mysql_error($db));
			$count = mysql_num_rows($result);
			$last_im_id = -1;
			$msg_item = '';
			if ($count != 0) {
				while ($row = mysql_fetch_assoc($result)) {
					$last_im_id = $row['im_id'];
					$msg = htmlentities(mysql_real_escape_string($row['i_msg']));
					$time = get_cool_date($row['time'], 'DATETIME_SHORT');
					$name = $row['name'] . ' ' . $row['last_name'];
					if ($row['user_id'] == $user_id) {
						$msg_item = $msg_item . '
						<div class="iMsg" style="background-color: #666; color: #e6e6e6">
						  <div class="iMTextArea" style="right: 70px;">
						    <div class="user" style="text-align: right; right: 0; top: 0;">' . $name . '</div>
							<div class="time" style="text-align: left; color: #ccc; left: 0; top: 0;">' . $time . '</div>
						    <div class="iMText" style="text-align: right; right: 0; top: 20px;">' . $msg . '</div>
						  </div>
						  <div class="profilePicSmall iMPic" style="right: 0;"></div>
						</div>
						';
					} else {
						$msg_item = $msg_item . '
						<div class="iMsg">
						  <div class="profilePicSmall iMPic" style="left: 0;"></div>
						  <div class="iMTextArea" style="left: 70px;">
						    <div class="user" style="left: 0; top: 0;">' . $name . '</div>
							<div class="time" style="right: 0; top: 0;">' . $time . '</div>
						    <div class="iMText" style="left: 0; top: 20px;">' . $msg . '</div>
						  </div>
						</div>
						';
					}
				}
			} else {
				$msg_item = '
				<div style="display: table; width: 400px; height: 400px;">
				<span style="display: table-cell; vertical-align: middle; text-align: center;">No chat history</span>
				</div>
				';
			}
			$json = array('cnt' => $count, 'txt' => $msg_item, 'lastIM' => $last_im_id);
			echo json_encode($json);
			exit();
		case 2: // for refreshing and updating instant messages
			$last_im_id = $_POST['lastIM'];
			$sql = 'SELECT c.im_id, c.i_msg, c.time, m.name, m.last_name, c.user_id
					FROM instant_msg AS c, groupmembers AS m
					WHERE c.im_id > ' . $last_im_id . ' AND m.cid = ' . $group_id . ' AND c.user_id = m.id
					ORDER BY c.time DESC LIMIT 50';
			$result = mysql_query($sql, $db) or die(mysql_error($db));
			$count = mysql_num_rows($result);
			$msg_item = '';
			$is_first_tuple = true;
			if ($count != 0) {
				while ($row = mysql_fetch_assoc($result)) {
					if ($is_first_tuple) {
						$last_im_id = $row['im_id'];
						$is_first_tuple = false;
					}
					$msg = htmlentities(mysql_real_escape_string($row['i_msg']));
					$time = get_cool_date($row['time'], 'DATETIME_SHORT');
					$name = $row['name'] . ' ' . $row['last_name'];
					if ($row['user_id'] == $user_id) {
						$msg_item = $msg_item . '
						<div class="iMsg" style="background-color: #666; color: #e6e6e6">
						  <div class="iMTextArea" style="right: 70px;">
						    <div class="user" style="text-align: right; right: 0; top: 0;">' . $name . '</div>
							<div class="time" style="text-align: left; color: #ccc; left: 0; top: 0;">' . $time . '</div>
						    <div class="iMText" style="text-align: right; right: 0; top: 20px;">' . $msg . '</div>
						  </div>
						  <div class="profilePicSmall iMPic" style="right: 0;"></div>
						</div>
						';
					} else {
						$msg_item = $msg_item . '
						<div class="iMsg">
						  <div class="profilePicSmall iMPic" style="left: 0;"></div>
						  <div class="iMTextArea" style="left: 70px;">
						    <div class="user" style="left: 0; top: 0;">' . $name . '</div>
							<div class="time" style="right: 0; top: 0;">' . $time . '</div>
						    <div class="iMText" style="left: 0; top: 20px;">' . $msg . '</div>
						  </div>
						</div>
						';
					}
				}
			}
			$json = array('cnt' => $count, 'txt' => $msg_item, 'lastIM' => $last_im_id);
			echo json_encode($json);
			exit();
		case 3: // for adding instant messages
			$msg = mysql_real_escape_string($_POST['iMsg']);
			$sql = 'INSERT INTO instant_msg (im_id, i_msg, user_id, time)
					VALUES (NULL, "' . $msg . '", ' . $user_id . ', NULL)';
			mysql_query($sql, $db) or die(mysql_error($db));
			exit();
			
	}
}
?>