<?php
session_start();
$user_id = $_SESSION['id'];
require './includes/db.inc.php';
require './includes/functions.inc.php';
$group_id = get_group_id($db, $user_id);
$members = get_members($db, $user_id);

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 1: // For displaying task lists and tasks
			$sql = 'SELECT l.list_id, t.task_id, l.name AS list_name, l.detail, t.name AS task_name, t.due_date, t.is_done, t.priority, l.is_ghost, l.date, m.name, m.last_name
					FROM (task_list AS l LEFT JOIN tasks AS t ON (t.list_id = l.list_id))
						LEFT JOIN groupmembers AS m ON (m.id = t.assign_to)
					WHERE l.group_id = ' . $group_id . '
					ORDER BY l.date DESC';
			$result = mysql_query($sql, $db) or die(mysql_error($db));
			$list_check = NULL;
			while ($row = mysql_fetch_assoc($result)) {
				$list_id = $row['list_id'];
				$task_id = $row['task_id'];
				$list_name = $row['list_name'];
				$list_detail = $row['detail'];
				$task_name = $row['task_name'];
				$task_assign_to = $row['name'] . ' ' . $row['last_name'];
				$due = $row['due_date'];
				if ($due != "0000-00-00") {
					$is_due = TRUE;
					$task_due = get_cool_date($due, 'DATE');
				}
				$task_done = $row['is_done'];
				$task_priority = $row['priority'];
				$list_ghost = $row['is_ghost'];
				/* The $result table contains tasks and task_list tables combined. Each tuple has task list and task data.
				   A task list can have multiple tasks. To display tasks inside a task list, first display the task list, then
				   display the tasks. To ensure that same task list details are not displayed (while displaying its tasks), 
				   $list_check var is used. It holds the value of current $list_id in iteration.
				   
				   "ghost task list": When a user adds a stand-alone task, a secret or ghost list is created in task_list table that
				   associates with the created task. This list is not shown to the user since the task is stand-alone.
				   Stand-alone tasks are displayed in same indentation as task list.
				*/
				if ($list_check != $list_id && $list_ghost == '0') {
					$list_check = $list_id;
					echo '
					<div class="taskList">
					<div class="listBubble"></div>
					<div class="listName">' . $list_name . '
					<span>-</span>
					<span onClick="popUp(3, { \'listId\' : ' . $list_id . ', \'listName\' : \'' . $list_name . '\' })">Add Task</span>
					<span onClick="popUp(4, { \'listId\' : ' . $list_id . ', ' . 
											 '\'listName\' : \'' . $list_name . '\', ' .
											 '\'listDetail\' : \'' . $list_detail . '\' })">Edit</span> 
					<span onClick="taskTransact(7, ' . $list_id . ')">Remove</span></div>
					<div class="listDetail">' . $list_detail . '</div>
					</div>
					';
				} else if ($list_ghost == '1') {
					switch ($task_priority) {
						case '0': $bubble_color = '#999'; break; // Priority: None
						case '1': $bubble_color = '#09f'; break; // Priority: Low
						case '2': $bubble_color = '#c00'; break; // Priority: High
					}
					if ($task_done == '1') {
						$box_color = '#66c266';
						$text_color = '#999';
					} else { 
						$box_color = '#f66';
						$text_color = '#333';
					}
					echo '
					<div class="taskList">
					<div style="
								float: left;
								width: 4px;
								height: 25px;
								background-color: ' . $bubble_color . ';
							   "></div>
					<div class="taskCheck" id="task' . $task_id . '" onclick="taskCheck(' . $task_id . ', \'' . $task_done . '\')" ' .
						'style="background-color: ' . $box_color . ';"></div>
					<div class="listName" style="color: ' . $text_color . '; padding: 0;">' . $task_name . '
					<span>-</span>
					<span onClick="popUp(5, { \'taskId\' : ' . $task_id . ', ' . 
											 '\'taskName\' : \'' . $task_name . '\', ' .
											 '\'priority\' : \'' . $task_priority . '\', ' .
											 '\'assignTo\' : \'' . $task_assign_to . '\', ' .
											 '\'due\' : \'' . $due . '\' })">Edit</span>
					<span onClick="taskTransact(8, ' . $task_id . ')">Remove</span></div>
					<div class="taskInfo" style="color: ' . $text_color . ';">
					Assigned to: <b>' . $task_assign_to . '</b>&nbsp;&nbsp;&nbsp;&nbsp;';
					if ($is_due) {
						echo 'Due: <b>' . $task_due . '</b>';
					}
					echo '
					</div>
					</div>
					';
				}
				if ($task_id != NULL && $list_ghost == "0") {
					switch ($task_priority) {
						case '0': $bubble_color = '#999'; break; // Priority: None
						case '1': $bubble_color = '#09f'; break; // Priority: Low
						case '2': $bubble_color = '#c00'; break; // Priority: High
					}
					if ($task_done == '1') {
						$box_color = '#66c266';
						$text_color = '#999';
					} else { 
						$box_color = '#f66';
						$text_color = '#333';
					}
					echo '
					<div class="task">
					<div style="
								float: left;
								width: 4px;
								height: 25px;
								background-color: ' . $bubble_color . ';
							   "></div>
					<div class="taskCheck" id="task' . $task_id . '" onclick="taskCheck(' . $task_id . ', \'' . $task_done . '\')" ' .
						'style="background-color: ' . $box_color . ';"></div>
					<div class="taskName" style="color: ' . $text_color . ';">' . $task_name . '
					<span>-</span>
					<span onClick="popUp(5, { \'taskId\' : ' . $task_id . ', ' . 
											 '\'taskName\' : \'' . $task_name . '\', ' .
											 '\'priority\' : \'' . $task_priority . '\', ' .
											 '\'assignTo\' : \'' . $task_assign_to . '\', ' .
											 '\'due\' : \'' . $due . '\' })">Edit</span>
					<span onClick="taskTransact(8, ' . $task_id . ')">Remove</span></div>
					<div class="taskInfo" style="color: ' . $text_color . ';">
					Assigned to: <b>' . $task_assign_to . '</b>&nbsp;&nbsp;&nbsp;&nbsp;';
					if ($is_due) {
						echo 'Due: <b>' . $task_due . '</b>';
					}
					echo '
					</div>
					</div>
					';
				}
				
			}
			exit();
		case 2: // For adding a new task list
			$task_list = mysql_real_escape_string($_POST['taskList']);
			$detail = mysql_real_escape_string($_POST['detail']);
			$sql = 'INSERT INTO task_list (list_id, name, detail, group_id, date, is_ghost)
					VALUES (NULL, "' . $task_list . '", "' . $detail . '", ' . $group_id . ', NULL, "0")';
			mysql_query($sql, $db) or die(mysql_error($db));
			header('Location:/tasks.php');
			exit();
		case 3: // For adding new task
			$task_name = mysql_real_escape_string($_POST['task']);
			$priority = $_POST['priority'];
			$assign_to = (int) substr($_POST['assignTo'], 1);
			$due_date = $_POST['dueDate'];
			$list_id = $_POST['type'];
			if ($list_id == 'NULL') { // In case, task is free of any list
				$sql = 'INSERT INTO task_list (list_id, name, detail, group_id, date, is_ghost)
						VALUES (NULL, "TASK", NULL, ' . $group_id . ', NULL, "1")';
				mysql_query($sql, $db) or die(mysql_error($db));
				$list_id = mysql_insert_id($db);
			}
			$sql = 'INSERT INTO tasks (task_id, name, assign_to, priority, due_date, is_done, list_id, date)
					VALUES (NULL, "' . $task_name . '", ' . $assign_to . ', "' . $priority . '", "' . $due_date . '", "0", ' . $list_id .
					', NULL)';
			mysql_query($sql, $db) or die(mysql_error($db));
			header('Location:/tasks.php');
			exit();
		case 4: // Editing task list
			$task_list = mysql_real_escape_string($_POST['taskList']);
			$detail = mysql_real_escape_string($_POST['detail']);
			$list_id = $_POST['type'];
			$sql = 'UPDATE task_list
					SET `name` = "' . $task_list . '", `detail` = "' . $detail . '"
					WHERE list_id = ' . $list_id;
			mysql_query($sql, $db) or die(mysql_error($db));
			header('Location:/tasks.php');
			exit();
		case 5: // Editing task
			$task_name = mysql_real_escape_string($_POST['task']);
			$priority = $_POST['priority'];
			$assign_to = (int) substr($_POST['assignTo'], 1);
			$due_date = $_POST['dueDate'];
			$task_id = $_POST['type'];
			$sql = 'UPDATE tasks
					SET name = "' . $task_name . '",
					    assign_to = ' . $assign_to . ',
						priority = "' . $priority . '",
						due_date = "' . $due_date . '"
					WHERE task_id = ' . $task_id;
			mysql_query($sql, $db) or die(mysql_error($db));
			header('Location:/tasks.php');
			exit();
		case 6: // Checking/unchecking tasks
			$task_id = $_POST['taskId'];
			$task_done = $_POST['isDone'];
			$sql = 'UPDATE tasks
					SET is_done = "' . $task_done . '"
					WHERE task_id = ' . $task_id;
			mysql_query($sql, $db) or die(mysql_error($db));
			exit();
		case 7: // Removing task list
			$list_id = $_POST['data'];
			$sql = 'DELETE FROM tasks
					WHERE list_id = ' . $list_id;
			mysql_query($sql, $db) or die(mysql_error($db));
			$sql = 'DELETE FROM task_list
					WHERE list_id = ' . $list_id;
			mysql_query($sql, $db) or die(mysql_error($db));
			exit();
		case 8: // Removing task
			$task_id = $_POST['data'];
			$sql = 'SELECT is_ghost, t.list_id FROM task_list AS l, tasks AS t
					WHERE t.list_id = l.list_id AND t.task_id = ' . $task_id;
			$result = mysql_query($sql, $db) or die(mysql_error($db));
			$row = mysql_fetch_assoc($result);
			$sql = 'DELETE FROM tasks
					WHERE task_id = ' . $task_id;
			mysql_query($sql, $db) or die(mysql_error($db));
			if ($row['is_ghost'] == '1') {
				$ghost_list_id = $row['list_id'];
				$sql = 'DELETE FROM task_list
						WHERE list_id = ' . $ghost_list_id;
				mysql_query($sql, $db) or die(mysql_error($db));
			}
	}
}

?>