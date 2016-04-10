<?php
session_start();
$user_id = $_SESSION['id'];
require './includes/auth.inc.php';
require './includes/db.inc.php';
require './includes/functions.inc.php';
$access_lvl = get_access_lvl($db, $user_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Project360 - Chat</title>
<link href="design.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="./scripts/navtab.js"></script>
<script type="text/javascript">
$(init);
function init() {
	$('#mainContent').css('visibility', 'hidden');
	$('#headband').load('headband.php', function() {
		$('#mainContent').css('visibility', 'visible');
		var tabId = 'tabc';
		colorNavTab(tabId);
		});
	$('#footer').load('footer.php');
	window.iMCnt = 0;
	chatTransact(1);
	window.timeInterval = window.setInterval(function() {chatTransact(2);}, 1000);
}
function chatTransact(action) {
	switch (action) {
		case 2: $.post('chat_transact.php', { action : 2, lastIM : window.lastIM }, function(response) {
					window.clearInterval(window.timeInterval);
					$('#chatBoxWrap').append(response.txt);
					var initCnt = window.iMCnt;
					var newCnt = response.cnt;
					var i = initCnt + newCnt - 50;
					// TODO: add a loader here
					if (i > 150) {
						while (i > 150) {
							$('#chatBoxWrap .iMsg:first-child').remove();
							i--;
						}
						window.iMCnt = i;
					}
					window.lastIM = response.lastIM;
					window.timeInterval = window.setInterval(function() {chatTransact(2);}, 1000);
					}, 'json');
				break;
		case 1: $.post('chat_transact.php', { action : 1 }, function(response) {
					$('#chatBoxWrap').prepend(response.txt);
					$('#chatBox').scrollTop($('#chatBoxWrap').height());
					window.iMCnt = response.cnt;
					window.lastIM = response.lastIM;
					}, 'json');
				break;
		case 3: var iMsg = $('#iMsg').val();
				$.post('chat_transact.php', { action : 3, iMsg : iMsg });
				window.setTimeout(function() {$('#chatBox').scrollTop($('#chatBoxWrap').height())}, 1000);
				$('#iMsg').val('');
				break;
	}
}
</script>
<style type="text/css">
#chatBox {
	width: 400px;
	height: 400px;
	margin: 10px 0 5px;
	border: 1px solid #999;
	background-color: #fff;
	overflow-y: scroll;
	overflow-x: hidden;
}
#sendBox {
	width: 400px;
	height: 80px;
	margin-bottom: 20px;
	border: 1px solid #999;
	background-color: #fff;
}
.iMsg {
	width: 375px;
	height: 70px;
	margin: 5px 15px 5px 5px;
	background-color: #e6e6e6;
	position: relative;
	overflow: hidden;
}
.iMPic {
	width: 50px;
	height: 50px;
	margin: 9px;
	border: 1px solid #999;
	position: absolute;
}
.iMTextArea {
	width: 297px;
	height: 62px;
	padding: 4px;
	font-size: 12px;
	position: absolute;
}
.iMTextArea .user {
	width: 190px;
	height: 20px;
	padding: 0 5px;
	font-weight: bold;
	line-height: 20px;
	position: absolute;
}
.iMTextArea .time {
	width: 77px;
	height: 20px;
	padding: 0 5px;
	font-size: 10px;
	color: #666;
	text-align: right;
	line-height: 20px;
	position: absolute;
}
.iMTextArea .iMText {
	width: 290px;
	height: 45px;
	padding: 0 6px 5px 6px;
	overflow: hidden;
	position: absolute;
}
</style>
</head>
<body>
<div id="container">
<div id="headband"></div>
<div id="mainContent">
  <div style="width: 420px; margin: auto;">
    <div id="chatBox">
    <div id="chatBoxWrap"></div>
    </div>
    <div id="sendBox">
      <div id="sendIMForm" style="position: relative;">
      <textarea id="iMsg" style="width: 288px; height: 60px; margin: 10px 0 10px 10px; position: absolute; left: 0;"></textarea>
      <div style="width: 80px; height: 60px; margin: 10px; position: absolute; left: 300px;">
        <a href="#" style="position: absolute; left: 18px; top: 18px;">
        <button type="button" onClick="chatTransact(3)" class="redBtn">Send</button>
        </a>
      </div>
      </div>
    </div>
  </div>
</div>
<div id="footer"></div>
</div>
</body>
</html>