<?php
session_start();
$user_id = $_SESSION['id'];
require './includes/auth.inc.php';
require './includes/db.inc.php';
require './includes/functions.inc.php';
$access_lvl = get_access_lvl($db, $user_id);
$members = json_encode(get_members($db, $user_id));
$varObj = '{
			"userId" : ' . $user_id . ',
			"accessLvl" : ' . $access_lvl . ',
			"members" : ' . $members .
		  '}';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Project360 - Tasks</title>
<link href="design.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="./scripts/navtab.js"></script>
<script type="text/javascript">
var varObj = new Object();
varObj = <?php echo $varObj ?>; // Global Variable Object
$(init);
function init() {
	$('#mainContent').css('visibility', 'hidden');
	$('#headband').load('headband.php', function() {
		$('#mainContent').css('visibility', 'visible');
		var tabId = 'tabt';
		colorNavTab(tabId);
		});
	$('#footer').load('footer.php');
	taskTransact(1);
	// TODO: Add a loader here
	for (var i in varObj.members) {
		$('#taskForm select[name="assignTo"]').append('<option value="' + i + '">' + varObj.members[i] + 
			'</option>');
	}
}
function taskTransact(action, data) {
	if (action == 7 || action == 8) { // For removing task list or task
		$.post('task_transact.php', { action : action, data : data }, function() {
			taskTransact(1);
			});
	} else {
		$.post('task_transact.php', { action : action }, function(responseTxt) {
			$('#taskBox').html(responseTxt);
			});
	}
}
function popUp(action, data) {
	/* data is object and multiple arguments are passed to it in form object properties.
	   Each action var has a different corresponding data obj i.e. object with different properties
	*/
	switch (action) {
		case 1: // For adding a new task list
				$('#popUpOverlay').show();
				$('#taskListForm').show();
				$('#taskListForm button').html('Add');
				$('#taskForm').hide();
				$('#popUpTitle').html('Add Task List');
				$('#taskListForm input[name="action"]').val('2');
				break;
		case 2: // For adding a new free (list-less, ghost list) task
				$('#popUpOverlay').show();
				$('#taskListForm').hide();
				$('#taskForm').show();
				$('#taskForm button').html('Add');
				$('#popUpTitle').html('Add Task');
				$('#taskForm input[name="type"]').val('NULL');
				$('#taskForm input[name="action"]').val('3');
				break;
		case 3: // For adding a new task in an existing list
				$('#popUpOverlay').show();
				$('#taskListForm').hide();
				$('#taskForm').show();
				$('#taskForm button').html('Add');
				$('#popUpTitle').html('Add Task');
				$('#popUp #popUpHeader').css('height', '42px');
				$('#popUp #boxLine').before('<div id="listForTask">in the list <b>' + 
					data.listName + '</b></div>');
				$('#taskForm input[name="type"]').val(data.listId);
				$('#taskForm input[name="action"]').val('3');
				break;
		case 4: // For editing a task list
				$('#popUpOverlay').show();
				$('#taskListForm').show();
				$('#taskListForm button').html('Save');
				$('#taskForm').hide();
				$('#popUpTitle').html('Edit Task List');
				$('#taskListForm input[name="type"]').val(data.listId);
				$('#taskListForm input[name="taskList"]').val(data.listName);
				$('#taskListForm textarea[name="detail"]').val(data.listDetail);
				$('#taskListForm input[name="action"]').val('4');
				break;
		case 5: // For editing a task
				$('#popUpOverlay').show();
				$('#taskForm').show();
				$('#taskForm button').html('Save');
				$('#taskListForm').hide();
				$('#popUpTitle').html('Edit Task');
				$('#taskForm input[name="type"]').val(data.taskId);
				$('#taskForm input[name="task"]').val(data.taskName);
				$('#taskForm select[name="priority"]').val(data.priority);
				$('#taskForm select[name="assignTo"]').val(data.assignTo);
				$('#taskForm input[name="dueDate"]').val(data.due);
				$('#taskForm input[name="action"]').val('5');
				break;
		case 0: // For closing pop up
				$('#taskListForm input[name="type"]').val(null);
				$('#taskListForm input[name="taskList"]').val(null);
				$('#taskListForm textarea[name="detail"]').val(null);
				$('#taskForm input[name="type"]').val(null);
				$('#taskForm input[name="task"]').val(null);
				$('#taskForm select[name="priority"]').val('None');
				$('#taskForm select[name="assignTo"]').val(null);
				$('#taskForm input[name="dueDate"]').val(null);
				$('#listForTask').remove();
				$('#popUp #popUpHeader').css('height', '30px');
				$('#popUpOverlay').hide();
				break;
	}
}
function taskCheck(taskId, isDone) {
	(isDone == '0') ? isDone = '1' : isDone = '0';
	$.post('task_transact.php', { action : 6, taskId : taskId, isDone : isDone}, function() {
		taskTransact(1);
		});
}
</script>
<style type="text/css">
#boxHeaderLeft {
    height: 39px;
	font-size: 26px;
    text-align: left;
	position: absolute;
	left: 0;
}
#boxHeaderRight {
	width: 250px;
    height: 39px;
	text-align: right;
	position: absolute;
	right: 0;
}
#popUp {
	width: 600px;
	height: 300px;
	margin: -150px 0 0 -300px;
	padding: 10px;
	position: fixed;
	left: 50%;
	top: 50%;
	background-color: white;
}
#popUpHeader {
	height: 30px;
	position: relative;
}
#popUpContent {
	padding: 20px;
}
#popUpTitle {
	height: 25px;
	padding-left: 20px;
	font-size: 20px;
	text-align: left;
	position: absolute;
	left: 0;
}
#closePop {
	height: 15px;
	text-align: right;
    font-size: 12px;
    color: red;
    cursor: pointer;
    position: absolute;
	top: 0;
	right: 0;
}
#boxTitle {
	padding-left: 30px
}
.taskList {
	display: block;
	overflow: hidden;
	margin: 10px 20px 0;
	border: solid #ccc;
	border-width: 1px 0 0;
	padding-top: 10px; 
}
.taskList:first-child {
	border: 0;
}
.listBubble {
	float: left;
	width: 2px;
	height: 25px;
	border: solid #999;
	border-width: 1px;
}
.listName {
	float: left;
	padding: 0 10px;
	font-size: 16px;
}
.listName span,
.taskName span {
	margin-left: 20px;
	vertical-align: middle;
	font-size: 11px;
	color: #600;
	cursor: pointer;
}
.listName span:first-child,
.taskName span:first-child {
	cursor: default;
}
.listDetail {
	clear: left;
	width: 100%;
	margin-left: 4px;
	padding: 0 10px;
	font-size: 12px;
}
.task {
	display: block;
	overflow: hidden;
	margin-left: 50px;
	padding: 15px 15px 0;
}
.taskName {
	float: left;
	height: 25px;
	font-size: 16px;
}
.taskInfo {
	clear: left;
	width: 100%;
	margin: auto 0 auto 35px;
	font-size: 12px;
}
.taskCheck {
	float: left;
	width: 11px;
	height: 11px;
	margin: 7px 10px;
	cursor: pointer;
}
#listForTask {
	height: 15px;
	padding-left: 20px;
	font-size: 11px;
	position: absolute;
	top: 25px;
}
</style>
</head>
<body>
<div id="container">
<div id="headband"></div>
<div id="mainContent">
<div id="sidebar"></div>
<div id="featContent">
  <div style="height: 40px; position: relative;"> <!-- box header div -->
    <div id="boxHeaderLeft"> 
      <div id="boxTitle">Tasks</div>
    </div> 
    <div id="boxHeaderRight">
      <a href="#"><button type="button" class="redBtn" onClick="popUp(1)">Add Task List</button></a>&nbsp;&nbsp;or&nbsp;&nbsp; 
      <a href="#"><button type="button" class="redBtn" onClick="popUp(2)">Add a Task</button></a>
    </div>
    <div id="boxLine"></div>
  </div>
  <div id="popUpOverlay">
    <div id="popUp">
      <div id="popUpHeader">
        <div id="popUpTitle"></div>
        <div id="closePop" onClick="popUp(0)">Close</div>
        <div id="boxLine"></div>
      </div>
      <div id="popUpContent">
        <form id="taskListForm" action="task_transact.php" method="post">
        <input type="hidden" name="action" />
        <input type="hidden" name="type" />
        <label for="taskList">Name:</label><input type="text" name="taskList" /><br />
        <label for="detail">Details:</label><br /><textarea style="width: 100%; height: 50px;" name="detail"></textarea><br />
        <a href="#" style="float: right"><button type="submit" class="redBtn"></button></a>
        </form>
        <form id="taskForm" action="task_transact.php" method="post">
        <input type="hidden" name="action" />
        <input type="hidden" name="type" />
        <label for="task">Task:</label><input type="text" name="task" /><br />
        <div>
          <div style="width: 33%; float: left;">
            <label for="priority">Priority</label><br />
            <select name="priority">
            <option value="0">None</option>
            <option value="1">Low</option>
            <option value="2">High</option>
            </select>
          </div>
          <div style="width: 34%; float: left;">
            <label for="assignTo">Assign To</label><br />
            <select name="assignTo" >
            </select>
          </div>
          <div style="width: 33%; float: left;">
            <label for="dueDate">Due</label><br />
            <input type="text" name="dueDate" />
          </div>
        </div>
        <a href="#" style="float: right"><button type="submit" class="redBtn"></button></a>
        </form>
      </div>
    </div>
  </div>
  <div id="taskBox"></div>
</div>
</div>
<div id="footer"></div>
</div>
</body>
</html>