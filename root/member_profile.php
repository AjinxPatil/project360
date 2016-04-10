<?php
session_start(); // Must start session first thing
/* 
Created By Adam Khoury @ www.flashbuilding.com 
-----------------------June 20, 2008----------------------- 
*/
// See if they are a logged in member by checking Session data
$toplinks = "";
if (isset($_SESSION['id'])) {
	// Put stored session variables into local php variable
    $userid = $_SESSION['id'];
    $username = $_SESSION['username'];
	$toplinks = '<a href="member_profile.php?id=' . $userid . '">' . $username . '</a> &bull; 
	<a href="member_account.php">Account</a> &bull; 
	<a href="memberadd.php?id=' . $userid . '">Add members</a> &bull;
	<a href="logout.php">Log Out</a>';
} else {
	$toplinks = '<a href="join_form.php">Register</a> &bull; <a href="login.php">Login</a>';
}
?>
<?php
// Use the URL 'id' variable to set who we want to query info about
$id = ereg_replace("[^0-9]", "", $_GET['id']); // filter everything but numbers for security
if ($id == "") {
	echo "Missing Data to Run";
	exit();
}
//Connect to the database through our include 
include_once "connect_to_mysql.php";
// Query member data from the database and ready it for display
$sql = mysql_query("SELECT * FROM members WHERE id='$id' LIMIT 1");
$MemberDisplayList = '<table border="0" align="center" cellpadding="3">
              <tr>  ';
$count = mysql_num_rows($sql);
if ($count > 1) {
	echo "There is no user with that id here.";
	exit();	
}
while($row = mysql_fetch_array($sql)){
$country = $row["country"];
$state = $row["state"];
$city = $row["city"];
$accounttype = $row["accounttype"];
$bio = $row["bio"];
$cid = $row["cid"];
// Convert the sign up date to be more readable by humans
$signupdate = strftime("%b %d, %Y", strtotime($row['signupdate']));
}
$sql = mysql_query("SELECT id, name FROM groupmembers WHERE cid='$cid' ");



while($rw = mysql_fetch_array($sql)){
	

	$id = $rw["id"];
	$name = $rw["name"];
		$MemberDisplayList .= '<td><div style=" height:64px; overflow:hidden;"><a href="http://www.project360.in/emp_profile.php?id=' . $id . '">' . $name . '</a></div></td>';
	
	
}
$MemberDisplayList .= '              </tr>
            </table>  ';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Member Profile</title>
<style type="text/css">
<!--
body {margin: 0px}
-->
</style></head>
<body>
<table style="background-color: #CCC" width="100%" border="0" cellpadding="12">
  <tr>
    <td width="78%"><h1>My Logo Image</h1></td>
    <td width="22%"><?php echo $toplinks; ?></td>
  </tr>
</table>
<table width="90%" align="center" cellpadding="5" cellspacing="5" style="line-height:1.5em;">
  <tr>
    <td width="31%" rowspan="2" valign="top">
    <!-- See the more advanced member system tutorial to see how to place default placeholder pic until member uploads one -->
    <div align="center"><img src="memberFiles/<?php echo "$id"; ?>/pic1.jpg" alt="Ad" width="250" /></div></td>
    <td width="20%" rowspan="2" valign="top">Name: <?php echo $_SESSION['username']; ?><br />
      Country: <?php echo "$country"; ?> <br />
      State: <?php echo "$state"; ?><br />
      City: <?php echo "$city"; ?><br />
    </td>
    <td width="49%" valign="top">Bio</td>
  </tr>
  <tr>
    <td valign="top"><?php echo "$bio"; ?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top">Sign up date: <?php echo "$signupdate"; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="880" border="0" align="center" cellpadding="0">
  <tr>

    <td height="80" valign="top">
  
    <div style="width:880px; background-color:#EFEFEF; border:#999 thin solid; font-family: 'MS Serif', 'New York', serif;">    
      <p>Group Members</p>
      <?php  print "$MemberDisplayList"; ?></div>

    <?php 
	$location = $city;
?>      
    </td>
  </tr>

</table>
<p>&nbsp;</p>
<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $location ; ?>&amp;aq=&amp;&amp;&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo $location ; ?>&amp;t=h&amp;z=10&amp;&amp;output=embed"></iframe>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>