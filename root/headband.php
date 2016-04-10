<div id="topLinks">
<a href="logout.php">Log out</a>
<?php
if ($access_lvl == 0) {
	echo '<a href="memberadd.php">Add Members</a>';
}
?>
<a href="edit_info.php">Edit Profile</a>
<a href="edit_pic.php">Change Profile Image</a>
</div>
<div id="hBar">
<div id="hSiteLogo"><img src="/images/logo.png" width="240" height="100" /></div>
<div id="hContent">
  <div id="hProjectBar">
  	<!-- --START-- Project & Group information -->
    <h2 class="hProjectDetail"></h2></div>
    <!-- --END-- Project & Group information -->
  <ul id="navList">
	<li class="navBarItem"><a class="tabdb navBarLink" href="dashboard.php">Dashboard</a></li>
	<li class="navBarItem"><a class="tabmsg navBarLink" href="messages.php">Messages</a></li>
    <li class="navBarItem"><a class="tabdcs navBarLink" href="discussions.php" onClick="alert('Under development')">Discussions</a></li>
	<li class="navBarItem"><a class=" tabt navBarLink" href="tasks.php">Tasks</a></li>
    <li class="navBarItem"><a class="tabcld navBarLink" href="calendar.php">Calendar</a></li>
	<li class="navBarItem"><a class="tabf navBarLink" href="#" onClick="alert('Under development')">Files</a></li>
	<li class="navBarItem"><a class="tabttk navBarLink" href="#" onClick="alert('Under development')">Time Tracking</a></li>
	<li class="navBarItem"><a class="tabc navBarLink" href="chat.php">Chat</a></li>
  </ul>
  </div>
<div id="navLine">
	<ul id="navLineList">
      <li style="float: left;
      			 width: 250px;
                 height: 10px;
                "></li>
      <li class="tabdb navLineBlock"></li>
      <li class="tabmsg navLineBlock"></li>
      <li class="tabdcs navLineBlock"></li>
      <li class="tabt navLineBlock"></li>
      <li class="tabcld navLineBlock"></li>
      <li class="tabf navLineBlock"></li>
      <li class="tabttk navLineBlock"></li>
      <li class="tabc navLineBlock"></li>
    </ul>	
</div>
</div>