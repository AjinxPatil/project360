<?php
session_start();
require 'db.inc.php';
require 'functions.inc.php';
$user_id = $_SESSION['id'];
$group_id = get_group_id($db, $user_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="design.css" type="text/css" />
<title>Project360: Add Members</title>
<style type="text/css">
#startCentreContent { /* area between header and footer in pages like login, index */
	margin:20px 15% 20px 15%;
	padding:15px;
	height:350px;
	border-style:solid;
	border-width:1px;
	border-color:#CCCCCC;
	background-color:#E0FFFF;
}
#startCentreContent #addMember {
	float:right;
	height:330px;
	width:279px;
	padding:10px;
	border-style:solid;
	border-width:0 0 0 1px;
	border-color:#CCCCCC;
}
#startCentreContent #sCDetail {
	margin:0 300px 0 0;
	padding:10px;
	text-align:center;
}
</style>
</head>
<body>
<div id="container">
<div id="hBar">
<div id="hSiteLogo"><img src="../images/logo.png" width="240" height="100" align="middle" /></div>
<div id="hContent"></div>
</div>
<div id="startCentreContent">
<div id="addMember">
<table align="left" width="100%" cellspacing="0" cellpadding="5">
	<tr><td align="left"><span style="font-size:24px">Add Member</span></td></tr>
  	<form name="form1" method="post" action="">
    <tr>
      <td colspan="2"><span style="font-size:12px;color:#990000"><?php echo "$errorMsg"; ?></span></td>
    </tr>
    <tr>
      <td align="left">First Name:</td>
      <td align="right"><input name="firstname" type="text" size="25" /></td>
    </tr>
    <tr>
      <td align="left">Last Name:</td>
      <td align="right"><input name="lastname" type="text" size="25" /></td>
    </tr>
    <tr>
      <td align="left">Designation:</td>
      <td align="right"><input name="designation" type="text" size="25" /></td>
    </tr>
    <tr>
      <td align="left">Email:</td>
      <td align="right"><input name="email" type="text" size="25" /></td>
    </tr>
    <tr>
      <td colspan="2" align="right" height="50" valign="bottom"><button type="submit" name="submit" value="addmem" class="blueBtn">Add Member</button></td>
    </tr>
  	</form>
</table>
<!--<form name="form1" method="post" action="">
  <label for="name">Name: </label>
  <input type="text" name="name" id="name">
  <label for="email">Email</label>
  <input type="text" name="email" id="email">
  <label for="company">Company</label>
  <input type="text" name="company" id="company" />
  Company-id
  <input type="text" name="cid" id="cid" />
  <label for="designation">Designation</label>
  <input type="text" name="designation" id="designation">
  <input type="submit" name="add" id="add" value="add">
</form>-->
</div>
<div id="sCDetail">
<span style="font-size:24px;color:#0099FF;">Add people to your group</span><br/><br />
<span style="font-size:18px;">Projects are effective when you've the right people for the tasks,<br />More Collaboration. Faster Work.</span><br />
<br /><br /><br /><br /><br /><br />
</div>
</div>
<div id="footer">Created by Parth Mody, Ajinkya Patil, Ankit Nair - DMCE, Navi Mumbai - 2012</div>
</div>
</body>
</html>
<?php
	$access_lvl = 1;
 	$token = strval(rand(1,9999999999));
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
    $email = $_POST['email'];
	$designation = $_POST['designation'];
	
	if (isset($_POST['submit'])) {
		$sql = mysql_query("INSERT INTO groupmembers (name, last_name, email,designation,password,cid,access_lvl) 
     			VALUES('$firstname','$lastname', '$email','$designation','$token','$group_id','$access_lvl')") or die (mysql_error());
		$sql = 'SELECT name, last_name FROM groupmembers
				WHERE cid = ' . $group_id . ' AND access_lvl = \'0\'';
		$result = mysql_query($sql, $db) or die(mysql_error($db));
		$id = mysql_insert_id();
		$row = mysql_fetch_assoc($result);
		$manager = $row['name'] . ' ' . $row['last_name'];
	  	mkdir("employees/$id", 0755); 
	  
	  	$to = "$email";
		$from = "admin@project360.in";
    	$subject = "Project360: You are part of a project group";
    
		//Begin HTML Email Message
	
	
    	$message = 'Hi ' . $firstname . ',
		You\'ve been added to a project group at Project360 by ' . $manager . '
		Your email address: ' . $email . '
		Password: ' . $token . '
		
		See you there!';
   //end of message
	$headers  = "From: $from\r\n";
    $headers .= "Content-type: text\r\n";

    mail($to, $subject, $message, $headers);}
    
?>