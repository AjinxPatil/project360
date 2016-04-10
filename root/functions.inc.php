<?php
/*function bbcode($db, $data) {
    $sql = 'SELECT
            template, replacement
        FROM
            msg_bbcode';
    $result = mysql_query($sql, $db) or die(mysql_error($db));
	$row = mysql_fetch_assoc($result);
    if (mysql_num_rows($result) > 0) {
        while($row = mysql_fetch_assoc($result)) {
            $bbcode['tpl'][] = '/' . $row['template'] . '/i';
            $bbcode['rep'][] = $row['replacement'];
        }
        $data1 = preg_replace($bbcode['tpl'], $bbcode['rep'], $data);
        $count = 1;
        while (($data1 != $data) and ($count < 4)) {
            $count++;
            $data = $data1;
            $data1 = preg_replace($bbcode['tpl'], $bbcode['rep'], $data);
        }
    }
   	return $data;
}*/
function get_group_id($db, $user_id) {
	$sql = 'SELECT cid
			FROM groupmembers
			WHERE id = ' . $user_id;
	$result = mysql_query($sql, $db) or die(mysql_error($db));
	$row = mysql_fetch_assoc($result);
	// Here, a check can be added to verify that $result can never be NULL i.e. it can return zero rows 
	return $row['cid'];
}
function get_cool_date($mysqlDateTime) {
	$timestamp = strtotime($mysqlDateTime);
	$coolDateTime = date('jS F Y \a\t h:i A', $timestamp);
	return $coolDateTime;
}
?>