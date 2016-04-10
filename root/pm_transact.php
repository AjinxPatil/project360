<?php
session_start();
$user_id = $_SESSION['id'];
require './includes/db.inc.php';
require './includes/functions.inc.php';

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 1:	
			$sql = 'SELECT p.msg_id, p.from_user, p.to_user, p.subject, p.content, p.is_read, p.date, m.name, m.last_name
					FROM groupmembers AS m, priv_msg AS p
					WHERE p.to_user = ' . $user_id . ' AND p.from_user = m.id AND p.rec_del = "0"';
			$result = mysql_query($sql, $db);
			if (mysql_num_rows($result) != 0) {
				while ($row = mysql_fetch_assoc($result)) {
					$msg_id = $row['msg_id'];
					$sender = $row['name'] . ' ' . $row['last_name'];
					$subject = $row['subject'];
					$content = $row['content'];
					$datetime = get_cool_date($row['date'], 'DATETIME');
					$mark_read = $row['is_read'];
					echo '
					<div class="message msg_' . $msg_id . '">
					<div class="msgItem"><input type="checkbox" name="msgcb" class="msgcb" value="' . $msg_id . '"/></div>
					<div class="msgItem" style="min-width:180px">' . $sender . '</div>
					<div class="msgItem" style="min-width:650px">' . $subject . '</div>
					<div class="msgItem" style="float:right">' . $datetime . '</div>
					</div><div class="msg_' . $msg_id . '" style="clear:both; border-bottom-style:solid; border-bottom-width:1px; border-bottom-color:#999999;">
					</div>
					';
				}
			} else {
				echo '<p>You have no messages</p>';
			}
			exit();
		case 2:
			$sql = 'SELECT p.msg_id, p.from_user, p.to_user, p.subject, p.content, p.is_read, p.date, m.name, m.last_name
					FROM groupmembers AS m, priv_msg AS p
					WHERE p.from_user = ' . $user_id . ' AND p.to_user = m.id AND sent_del = "0"';
			$result = mysql_query($sql, $db);
			if (mysql_num_rows($result) != 0) {
				while ($row = mysql_fetch_assoc($result)) {
					$msg_id = $row['msg_id'];
					$receiver = $row['name'] . ' ' . $row['last_name'];
					$subject = $row['subject'];
					$content = $row['content'];
					$datetime = get_cool_date($row['date'], 'DATETIME');
					$mark_read = $row['is_read'];
					echo '
					<div class="message msg_' . $msg_id . '">
					<div class="msgItem"><input type="checkbox" name="msgcb" class="msgcb" value="' . $msg_id . '"/></div>
					<div class="msgItem" style="min-width:180px">' . $receiver . '</div>
					<div class="msgItem" style="min-width:650px">' . $subject . '</div>
					<div class="msgItem" style="float:right">' . $datetime . '</div>
					</div><div class="msg_' . $msg_id . '" style="clear:both; border-bottom-style:solid; border-bottom-width:1px; border-bottom-color:#999999;">
					</div>
					';
				}
			} else {
				echo '<p>You have not sent any messages</p>';
			}
			exit();
		case 3:
			if (isset($_POST['checks']) && isset($_POST['box_type'])) {
				$chkArr = $_POST['checks'];
				$box_type = $_POST['box_type'];
				$status = true;
				if ($box_type == 'INBOX') {
					$col = 'rec_del';
				} else if ($box_type == 'SENT') {
					$col = 'sent_del';
				} else {
					echo false;
					exit();
				}
				foreach ($chkArr as $msg) {
					$sql_1 = 'UPDATE priv_msg
								SET `' . $col . '` = "1"
								WHERE msg_id = ' . $msg;
					$sql_2 = 'DELETE FROM priv_msg
								WHERE msg_id = ' . $msg . ' AND rec_del = "1" AND sent_del = "1"';
					$result = mysql_query($sql_1, $db);
					mysql_query($sql_2, $db) or die(mysql_error($db));
					if (!$result) {
						$status = false;
					}
				}
				echo $status;
			}
			exit();
		case 4:
			$members = get_members($db, $user_id);
			echo '
			<form method="post" action="pm_transact.php">
			<input type="hidden" name="action" value="5" />
			<label for="toUser">To: </label><select name="toUser" id="toUser">';
			foreach ($members as $id => $name) {
				$id = (int)substr($id, 1);
				echo '<option value="' . $id . '">' . $name . '</option>'; 
			}
			unset($members);
			echo '</select><br /><br />
			<div style="background-color:#FFFFDB;padding:20px;">
			Message
			<br /><br />
			<input style="display:block;width:90%;" type="text" name="subject" id="subject" />
			<textarea style="width:90%;height:200px;" name="content"></textarea>
			</div><br />
			<div style="text-align:right"><button type="submit" class="redBtn">Send</button></div>
			</form>
			';
			exit();
		case 5:
			$to_user = mysql_real_escape_string($_POST['toUser']);
			$subject = mysql_real_escape_string($_POST['subject']);
			$content = mysql_real_escape_string($_POST['content']);
			$datetime = date('Y-m-d H:i:s');
			$sql = 'INSERT INTO priv_msg (msg_id, to_user, from_user, subject, content, date)
					VALUES (NULL, "' . $to_user . '", "' . $user_id . '", "' . $subject . '", "' . $content .
					'", "' . $datetime . '")';
			$result = mysql_query($sql, $db) or die(mysql_error($db));
			exit();
	}		
}
?>