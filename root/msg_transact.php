<?php
session_start();
$user_id = $_SESSION['id'];
require 'db.inc.php';
require 'functions.inc.php';
if (isset($_REQUEST['action'])) {
    switch (strtoupper($_REQUEST['action'])) {
    	case 'POST NEW MESSAGE':			
        	if (isset($_POST['subject']) && isset($_POST['body']) && isset($user_id)) {
				$group_id = get_group_id($db, $user_id);
				$subject = mysql_real_escape_string($_POST['subject']);
				$body = mysql_real_escape_string($_POST['body']);
				$datetime = date('Y-m-d H:i:s');
				if ($_POST['newCategory'] != "") {
					$category_name = $_POST['newCategory'];
					$sql = 'INSERT INTO msg_categories (id, name, group_id)
							VALUES (NULL,"' . $category_name . '", ' . $group_id . ')';	
	            	mysql_query($sql, $db) or die(mysql_error($db));
					$category_id = mysql_insert_id();
				} else {
					$category_id = $_POST['category'];
				}
				$sql = 'INSERT INTO msg_posts (topic_id, group_id, author_id, date_posted, subject, body, last_update, category_id)
		                VALUES (0,' . $group_id . ', ' . $user_id . ', "' . $datetime . '", "' .
						$subject . '", "' . $body . '", "' . $datetime . '",' . $category_id . ')';
	            mysql_query($sql, $db) or die(mysql_error($db));
				$msg_id = mysql_insert_id();
			}
			if (isset($msg_id)) {
				$sql = 'SELECT name, last_name FROM  groupmembers WHERE id = ' . $user_id;
				$result = mysql_query($sql, $db) or die(mysql_error($db));
				$row = mysql_fetch_assoc($result);
				$name = $row['name'] . ' ' . $row['last_name'];
				$sql = 'INSERT INTO feeds (id, Title, nameofuploader, type, feeddate, cid)
		                VALUES (NULL, "' . $subject . '", "' . $name . '", "message", now(), ' . $group_id . ')';
	            mysql_query($sql, $db) or die(mysql_error($db));
				echo '<script type="text/javascript">';
				echo 'window.location.replace("showtopic.php?f=' . $msg_id . '");';
				echo '</script>'; 
			} else {
				echo '<script type="text/javascript">';
				echo 'window.location.replace("messages.php");';
				echo '</script>'; 
			}
			exit();
			break;
	    case 'SAVE CHANGES':
	        if (isset($_POST['subject']) && isset($_POST['body']) && isset($user_id)) {
				$datetime = date('Y-m-d H:i:s');
	            $sql = 'UPDATE msg_posts SET subject = "' . $_POST['subject'] . '",
	                    body = "' . $_POST['body'] . '",
	                    date_updated = "' . $datetime . '",
						last_update = "' . $datetime . '"
		                WHERE
	                    msg_id = ' . $_POST['msg_id'];
	            mysql_query($sql, $db) or die(mysql_error($db));
	        }
			echo '<script type="text/javascript">';
			echo 'window.location.replace("showtopic.php?f=' . $_POST['topic_id'] . '");';
			echo '</script>'; 
			exit();
	        break;
		case 'COMMENT':
			if (isset($_POST['body']) && isset($user_id)) {
				$group_id = get_group_id($db, $user_id);
				$topic_id = $_POST['topicid'];
				$body = mysql_real_escape_string($_POST['body']);
				$datetime = date('Y-m-d H:i:s');
				$sql = 'INSERT INTO msg_posts (msg_id, topic_id, group_id, author_id, date_posted, date_updated, body, last_update)
		                VALUES (NULL, ' . $topic_id . ', ' . $group_id . ', ' . $user_id . ', "' . $datetime . 
						'", NULL, "' . $body . '", NULL)';
	            mysql_query($sql, $db) or die(mysql_error($db));
				$sql = 'UPDATE msg_posts SET last_update = "' . $datetime . '"
						WHERE msg_id = ' . $topic_id; 
				mysql_query($sql, $db) or die(mysql_error($db));
				$msg_id = mysql_insert_id();
				$cooldate = get_cool_date(date('Y-m-d H:i:s'));
				$data = array('msgid' => $msg_id, 'date' => $cooldate, 'comment' =>  mysql_real_escape_string($_POST['body']));
				header('Content-Type: application/json');
				echo json_encode($data);
			}
			exit();
			break;
		case 'DELETEPOST':
			$msg_id = $_POST['msgid'];
			$topic_id = $_POST['topicid'];
			$sql = 'DELETE FROM msg_posts WHERE msg_id = ' . $msg_id;
            mysql_query($sql, $db) or die(mysql_error($db));
			exit();
        	break;
    }
} else {
	echo '<script type="text/javascript">';
	echo 'window.location.replace("messages.php");';
	echo '</script>'; 
}
?>