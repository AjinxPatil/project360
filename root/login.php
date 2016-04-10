<?php
session_start();

require './includes/db.inc.php';
// filter incoming values
$email = mysql_real_escape_string($_POST['email'], $db);
$password = mysql_real_escape_string($_POST['password'], $db); // Add md5 hashing for password
$email = isset($_POST['email']) ? trim($email) : '';
$password = isset($_POST['password']) ? $password : ''; 
$redirect = isset($_REQUEST['redirect']) ? $_REQUEST['redirect'] : 'dashboard.php';

if (isset($_POST['submit'])) {
	$sql = 'SELECT * FROM groupmembers WHERE email = "' . $email . '" AND password = "' . $password . '" LIMIT 1';
	$result = mysql_query($sql, $db) or die(mysql_error($db));
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_assoc($result);
		$ac_status = $row['emailactivated'];
		$access_lvl = $row['access_lvl'];
		if ($access_lvl == 0) { 
			// For manager
			if ($ac_status == 1) {
				$user_id = $row['id'];
				$_SESSION['id'] = $user_id; // create manager id session var
				$name = $row['name'];
				$_SESSION['name'] = $name; // create manager name session var
				$group_id = $row['cid'];
				$_SESSION['cid'] = $group_id; // create group id session var
				$_SESSION['logged'] = 2012;
				header('Refresh:5; URL=' . $redirect);
				echo '<div style="text-align:center" class="defaultFont"><span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
				echo '<span>You\'re successfully logged in. You\'ll be redirected in few seconds.';
				echo '<br />If the browser does not redirect you properly, ';
				echo '<a href="' . $redirect . '">click here</a>.</span></div>';
			} else {
				// Print in case the manager logins before activating via email
				echo '<div class="defaultFont" style="text-align:center"><span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
				echo '<span style="color:#990000;">Sorry! You\'ve not activated your account. Please check your email inbox for the activation link.</span></div>';
			}
		} else {
			// For member
			$user_id = $row['id'];
			$_SESSION['id'] = $user_id; // create member id session var
			$name = $row['name'];
			$_SESSION['name'] = $name; // create member name session var
			$group_id = $row['cid'];
			$_SESSION['cid'] = $group_id; // create group id session var
			$_SESSION['logged'] = 2012;
			/*if (!is_dir('employees/' . $user_id)) {
				mkdir('employees/' . $user_id);
			}*/
			header('Refresh:5; URL=' . $redirect);
			echo '<div class="defaultFont" style="text-align:center"><span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
			echo '<span>You\'re successfully logged in. You\'ll be redirected in few seconds.';
			echo '<br />If the browser does not redirect you properly, ';
			echo '<a href="' . $redirect . '">click here</a>.</span></div>';
		}
	} else {
		// Print login failure message to the user and link them back to your login page
		echo '<div class="defaultFont" style="text-align:center"><span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
		echo '<span style="color:#990000;">Sorry! Either you entered wrong information or you haven\'t registered yet.</span><br />';
		echo '<span>Click <a href="login.php">here</a> to try again.</span></div>';
	}
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="design.css" type="text/css" />
<title>Login: Project360</title>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript">
$(init);
function init() {
	$("#footer").load("footer.php");
}
function validateForm() {
	valid = true;
	var e = document.forms["login"]["email"].value;
	var p = document.forms["login"]["password"].value;
	if (e == null || p == null || e == "" || p == "") {
		alert("Fields are empty!");
		valid = false;
	}
	var at = e.indexOf("@");
	var dot = e.lastIndexOf(".");
	if (at<1 || dot<at+2 || dot+2>=e.length) {
		alert("Invalid Email Address!");
		valid = false;
	}
	return valid;
}
</script>
<style type="text/css">
html {
	border: 0;
	height: 100%;
	background-color: white;
}
#hBar {
	background: url(/images/header-texture.png) repeat;
	box-shadow: 0 2px 10px 1px #999;
}
#startCentreContent { /* area between header and footer in pages like login, index */
	margin:20px 15% 20px 15%;
	padding:15px;
	height:350px;
	border-style:solid;
	border-width:1px;
	border-color:#CCC;
	background-color:#eee;
}
#startCentreContent #login {
	float:right;
	height:330px;
	width:259px;
	padding:10px;
	border-style:solid;
	border-width:0 0 0 1px;
	border-color:#CCCCCC;
}
#startCentreContent #sCDetail {
	margin:0 280px 0 0;
	padding:10px;
}
#register {
	position:absolute;
	top:25px;
	right:120px;
}
#footer {
	position:absolute;
	bottom:0;
	width:100%;
	height:29px;
	padding:0;
	border-style:solid;
	border-width:1px 0 0 0;
	border-color:#D4D4D4;
	clear:both;
	text-align:center;
	font-size:11px;
	color:#333333;
	background-color:#ECECEC;
}
</style>
</head>

<body>
<div id="container">
<div id="hBar">
<div id="hSiteLogo"><img src="../images/logo.png" width="240" height="100" align="middle" /></div>
<div id="hContent">
<div id="register"><span style="color:#333;font-size:12px;">New to Project360?&nbsp;&nbsp;&nbsp;</span><a href="join_form.php"><button class="redBtn" type="button">Register</button></a>&nbsp;&nbsp;&nbsp;<a href="mailto:ajinkya_patil@outlook.com" target="_blank"><button class="greyBtn" type="button">Contact</button></a></div>
</div>
</div>
<div id="startCentreContent">
<div id="login">
<form name="login" action="login.php" onsubmit="validateForm()" method="post">
    <table cellspacing="10">
    	<tr><td align="left"><span style="font-size:24px">Login</span></td></tr>
        <tr><td height="60"></td><td height="60"></td></tr>
    	<tr>
        	<td align="left"><strong>Email:</strong></td>
            <td align="left"><input type="text" name="email" maxlength="30" value="<?php echo $email ?>" /></td>
        </tr>
        <tr>
        	<td align="left"><strong>Password:</strong></td>
            <td align="left"><input type="password" name="password" maxlength="20" value="<?php echo $password ?>" /></td>
    	</tr>
        <tr>
        	<td align="left" height="50" valign="bottom"><button type="submit" name="submit" value="Login" class="blueBtn">Login</button></td>
        </tr>
    </table>
    <input type="hidden" name="redirect" value="<?php echo $redirect ?>" />
</form>
</div>
<div id="sCDetail">
<span style="font-size:18px;">An intuitive tool for managing your projects and collaborating with your team</span><br />
<br /><br /><br /><br /><br /><br />
<span style="font-size:16px;">
<table cellpadding="10" cellspacing="0" width="100%">
<tr>
<td align="center" valign="middle" style="border-style:solid;border-width:0 1px 0 0;border-color:#CCCCCC;">Assign Tasks</td>
<td align="center" valign="middle" style="border-style:solid;border-width:0 1px 0 1px;border-color:#CCCCCC;">Collaborate with team members</td>
<td align="center" valign="middle" style="border-style:solid;border-width:0 0 0 1px;border-color:#CCCCCC;">Manage events and files</td>
</tr>
</table>
</span>
</div>
</div>
</div>
<div id="footer"></div>
</body>
</html>