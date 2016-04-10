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
<title>Project360 - Calendar</title>
<link href="design.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="./scripts/navtab.js"></script>
<script type="text/javascript">
$(init);
function init() {
	$('#mainContent').css('visibility', 'hidden');
	$('#headband').load('headband.php', function() {
		$('#mainContent').css('visibility', 'visible');
		var tabId = 'tabcld';
		colorNavTab(tabId);
		});
	$('#footer').load('footer.php');
	calTransact(1, 'CURRENT_MONTH');
}
var FINAL_PREV_YEAR = 2011;
var FINAL_NEXT_YEAR = 2015;
window.month = 1;
window.year = 2012;
function calTransact(action, mode) {
	switch(action) {
		case 1: var month, year;
						mode = mode.toUpperCase();
						switch (mode) {
							case 'CURRENT_MONTH': month = 0;
																		year = 0;
																		break;
							case 'SELECT_MONTH': 	month = $('#selectMon :selected').val();
																	 	year = $('#selectYr :selected').val();
																	 	window.month = month;
																	 	window.year = year;
																	 	break;
							case 'NEXT_MONTH': 		month = ++window.month;
																 		if (month > 12) {
																	 		month = 1;
																			window.month = 1;
																	 		year = ++window.year;
																 		}
																 		year = (year > FINAL_NEXT_YEAR) ? FINAL_NEXT_YEAR : window.year;
																		window.year = year; 
																 		break;
							case 'PREV_MONTH': 		month = --window.month;
																 		if (month < 1) {
																	 		month = 12;
																			window.month = 12;
																	 		year = --window.year;
																 		}
																 		year = (year < FINAL_PREV_YEAR) ? FINAL_PREV_YEAR : window.year;
																		window.year = year;
																 		break;
						}
						$.post('cal_transact.php', { action : action, month : month, year : year }, function(responseTxt) {
							$('#cal-box').html(responseTxt.calendar);
							$('.calRow-days').css('height', responseTxt.cellHeight);
							$('#month').html(responseTxt.monthName);
							window.month = responseTxt.month;
							window.year = responseTxt.year;
							$('#year').html(responseTxt.year);
							$('#d' + responseTxt.today).css('background-color', '#666');
							$('#d' + responseTxt.today + ' .calCell-date').css('color', '#fff');
							}, 'json');
	}
}
</script>
<style type="text/css">
table {
	border: 0;
	border-spacing: 0;
}
#calRow-weekdays {
	width: 768px;
	height: 28px;
	border: 1px solid #666;
}
#calRow-weekdays td {
	width: 110px;
	height: 25px;
	text-align: center;
	vertical-align: middle;
}
.calRow-days {
	height: 82px;
}
.calRow-days td {
	width: 108px;
	height: 100%;
	border: 1px solid #666;
	position: relative; /* position: relative on td may now work with Firefox. TODO: Check */
}
.calCell-event {
	box-sizing: border-box;
	width: 100%;
	height: 50%;
	padding: 5px;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #069;
	position: absolute;
	top: 0;
	left: 0;
}
.calCell-date {
	width: 100%;
	height: 50%;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 25px;
	color: #666;
	position: absolute;
	bottom: 0;
	left: 0;
}
.calCell-date span {
	position: absolute;
	right: 5px;
	bottom: 2px;
}
#boxHeaderLeft {
	height: 39px;
	text-align: left;
	position: absolute;
	left: 0;
}
#boxHeaderRight {
	width: 250px;
	height: 30px;
	margin: 0 10px 9px 0;
	background-color: rgba(204, 204, 204, 0.2);
	text-align: right;
	position: absolute;
	right: 0;
}
#boxTitle {
	height: 39px;
	padding-left: 30px;
	font-size: 26px;
}
#calendar {
	width: 770px;
	height: 480px;
	margin: 10px auto;
	border: solid #666;
	border-width: 1px 1px 0 1px;
}
#cal-box {
	border: solid #666;
	border-width: 0 0 1px 0;
}
#cal-header {
	width: 770px;
	height: 40px;
	background-color: #666;
	font-size: 15px;
	font-weight: bold;
	line-height: 40px;
	text-align: center;
	text-shadow: 0 0 2px #333;
	color: #ccc;
	position: relative;
}
#prevMon {
	width: 60px;
	font-size: 25px;
	position: absolute;
	left: 0;
	cursor: pointer;
}
#nextMon {
	width: 60px;
	position: absolute;
	font-size: 25px;
	right: 0;
	cursor: pointer;
}
#MonYr {
	width: 650px;
	position: absolute;
	left: 60px;
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
      <div id="boxTitle">Calendar</div>
    </div>
    <div id="boxHeaderRight">
      <div style="margin: 0 auto; padding: 1px; overflow: hidden;">
        <select id="selectMon" style="margin: 4px 4px 0 0; position: absolute; left: 25px;" >
          <option value="1">January</option>
          <option value="2">February</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">August</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
        <select id="selectYr" style="margin: 4px 4px 0 0; position: absolute; left: 124px;">
          <option value="2011">2011</option>
          <option value="2012">2012</option>
          <option value="2013">2013</option>
          <option value="2014">2014</option>
          <option value="2015">2015</option>
        </select>
        <a href="#" style="margin: 4px 4px 0 0; position: absolute; left: 185px;"><button type="button" class="redBtn" style="height: 20px; font-size: 11px; line-height: 0;" onClick="calTransact(1, 'SELECT_MONTH')">View</button></a>
      </div>
    </div>
    <div id="boxLine"></div>
  </div>
  <div id="calendar">
    <div id="cal-header">
    	<div id="prevMon" onClick="calTransact(1, 'PREV_MONTH')">&lt;</div>
    	<div id="MonYr"><span id="month"></span>&nbsp;<span id="year"></span></div>
    	<div id="nextMon" onClick="calTransact(1, 'NEXT_MONTH')">&gt;</div>
    </div>
    <div id="calRow-weekdays">
      <table style="height: 30px;">
        <tr>
          <td>MON</td>
          <td>TUE</td>
          <td>WED</td>
          <td>THU</td>
          <td>FRI</td>
          <td>SAT</td>
          <td>SUN</td>
        </tr>
      </table>
    </div>
    <div id="cal-box"></div>
  </div>
</div>
</div>
<div id="footer"></div>
</div>
</body>
</html>