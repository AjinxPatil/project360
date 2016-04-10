<?php
function get_group_id($db, $user_id) {
	$sql = 'SELECT cid
			FROM groupmembers
			WHERE id = ' . $user_id;
	$result = mysql_query($sql, $db) or die(mysql_error($db));
	$row = mysql_fetch_assoc($result);
	// Here, a check can be added to verify that $result can never be NULL i.e. it can return zero rows 
	return $row['cid'];
}
function get_cool_date($mysqlDateTime, $type) {
	$timestamp = strtotime($mysqlDateTime);
	switch (strtoupper($type)) {
		case 'DATETIME' : $coolDateTime = date('jS F Y \a\t h:i A', $timestamp);
						  return $coolDateTime;
		case 'DATE' : $timestamp = strtotime($mysqlDateTime);
					  $coolDate = date('M j, Y', $timestamp);
					  return $coolDate;
		case 'DATETIME_SHORT' : $coolDateTime = date('G:i, M j', $timestamp);
						  		return $coolDateTime;
	}
}
function get_access_lvl($db, $user_id) {
	$sql = 'SELECT cid, access_lvl FROM groupmembers WHERE id = ' . $user_id;
	$result = mysql_query($sql, $db) or die(mysql_error($db));
	$row = mysql_fetch_assoc($result);
	return $row['access_lvl'];
}
function get_members($db, $user_id) {
	$sql = 'SELECT id, name, last_name FROM groupmembers
			WHERE id != ' . $user_id . ' AND cid = (
				SELECT cid FROM groupmembers
				WHERE id = ' . $user_id . '
				)';
	$result = mysql_query($sql, $db) or die(mysql_error($db));
	$members = array();
	while ($row = mysql_fetch_assoc($result)) {
		$members['i' . $row['id']] =  $row['name'] . ' ' . $row['last_name'];
	}
	return $members;
}
?>