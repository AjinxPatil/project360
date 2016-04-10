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
<title>Project360 - Messages</title>
<link href="design.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="./scripts/navtab.js"></script>
<script type="text/javascript">
var boxType = "INBOX";
$(init);
function init() {
	$("#mainContent").css("visibility", "hidden");
	$("#headband").load("headband.php", function () {
		$("#mainContent").css("visibility", "visible");
		var tabId = 'tabmsg';
		colorNavTab(tabId);
		});
	$("#footer").load("footer.php");
	pmTransact(1);
}
function pmTransact(action) {
	if (action != 3) {
		$.post("pm_transact.php", { action: action }, function (responseTxt) {
			$("#mailBox").html(responseTxt);
			if (action == 1) {
				boxType = "INBOX";
				$("#boxTitle").html("Inbox");
				$(".navDrop").show();
			} else if (action == 2) {
				boxType = "SENT";
				$("#boxTitle").html("Sent Messages");
				$(".navDrop").show();
			} else if (action == 4) {
				$("#boxTitle").html("Compose Message");
				$(".navDrop").hide();
			}
			});
	} else {
		var checks = new Array();
		var i = 0;
		$(".msgcb").each(function () {
			if ($(this).attr("checked") == "checked") {
				checks[i] = $(this).val();
				i++;
			}
			});
		if (checks.length == 0) {
				return; // If no checkboxes are checked, pressing "Delete" button won't make a request to server
		}
		$.post("pm_transact.php", { action : 3, checks : checks, box_type : boxType }, function (responseTxt) {
			if (responseTxt) {
				for (i=0; i<checks.length; i++) {
						$(".msg_" + checks[i]).fadeOut();
				}
			} else {
				alert("Oops! Something went wrong. We're sorry. May be you should try again.");
				// display notification for server error
			}
			});
	}
}
/* START - CONCEPT: AJAX (asynchronous connection for dynamic page update) 
var httpRequest;
function pmTransact(action, param) {
	httpRequest = new XMLHttpRequest(); // create XMLHttpRequest object of DOM
	httpRequest.open("POST","pm_transact.php",true); // open(method, program-url, async)
	httpRequest.onreadystatechange = checkData; // event handler
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // for passing parameters via POST
	data = "action=" + action + "&param=" + param;
	httpRequest.send(data);
	document.getElementById("featContent").innerHTML = "<p>Wait. We\'re getting your messages...</p>";
}
function checkData() {
	if (httpRequest.readyState == 4 && httpRequest.status == 200) {
			document.getElementById("featContent").innerHTML = httpRequest.responseText;
	}
} 
END - CONCEPT: AJAX (asynchronous connection for dynamic page update) */
</script>
<style type="text/css">
.message {
	clear:both;
}
.msgItem {
	float:left;
}
#boxHeader {
	height:40px;
	position: relative;
}
#mailBox {
	padding:20px;
	overflow:hidden;
}
#boxLeft {
	font-size:26px;
    width:80%;
    height:39px;
    text-align:left;
	position: absolute;
	left: 0;
}
#boxRight {
	width:20%;
    height:39px;
	text-align:right;
	position: absolute;
	right: 0;
}
.navDrop ul {
	z-index:100;
}
</style>
</head>

<body>
<div id="container">
<div id="headband"></div>

<div id="mainContent">
<div id="sidebar">
<button class="textBtn" type="button" onClick="pmTransact(1)">Inbox</button><br />
<button class="textBtn" type="button" onClick="pmTransact(2)">Sent</button><br />
<button class="textBtn" type="button" onClick="pmTransact(4)">Compose</button><br />
</div>
<div id="featContent">
<div id="boxHeader">
  <div id="boxLeft">
    <div id="boxTitle" style="padding-left:30px"></div>
  </div> 
  <div id="boxRight">
  <ul class="navDrop">
  	<li><a>Options</a>
      <ul>
        <li><a href="#" onClick="pmTransact(3)">Delete Selected</a></li>
        <li><a href="#">Mark as Read</a></li>
      </ul>
    </li>
  </ul>
  </div>
  <div id="boxLine"></div>
</div>
<div id="mailBox"></div>
</div>
</div>
<div id="footer"></div>
</div>
</body>
</html>