<?php
require 'db.inc.php';
// Set error message as blank upon arrival to page
$errorMsg = "";
// First we check to see if the form has been submitted 
if (isset($_POST['submit'])){
	// Filter the posted variables
	$firstname = ereg_replace("[^A-Za-z0-9]", "", $_POST['firstname']); // filter everything but numbers and letters
	$lastname = ereg_replace("[^A-Za-z0-9]", "", $_POST['lastname']); // filter everything but numbers and letters
	$country = ereg_replace("[^A-Z a-z0-9]", "", $_POST['country']); // filter everything but spaces, numbers, and letters
	$state = ereg_replace("[^A-Z a-z0-9]", "", $_POST['state']); // filter everything but spaces, numbers, and letters
	$city = ereg_replace("[^A-Z a-z0-9]", "", $_POST['city']); // filter everything but spaces, numbers, and letters
	$number = ereg_replace("[^A-Z a-z0-9]", "", $_POST['number']); // filter everything but spaces, numbers, and letters
	$address = $_POST['address'];
	$address = mysql_real_escape_string($address, $db);
	$email = stripslashes($_POST['email']);
	$email = strip_tags($email);
	$email = mysql_real_escape_string($email, $db);
	$password = ereg_replace("[^A-Za-z0-9]", "", $_POST['password']); // filter everything but numbers and letters
	$cid=rand();
	if((!$firstname) || (!$lastname) || (!$country) || (!$state) || (!$city) || (!$email) || (!$password)){
		
		$errorMsg = "You did not submit the following required information!<br />";
		if(!$firstname){
			$errorMsg .= "&middot; First Name";
		} else if(!$lastname){
			$errorMsg .= "&middot; Last Name";
		} else if(!$country){
			$errorMsg .= "&middot; Country"; 
		} else if(!$state){ 
		    $errorMsg .= "&middot; State"; 
	   } else if(!$city){ 
	       $errorMsg .= "&middot; City"; 
	   } else if(!$email){ 
	       $errorMsg .= "&middot; Email"; 
	   } else if(!$password){ 
	       $errorMsg .= "&middot; Password"; 
	   } 
	} else {
		// Database duplicate Fields Check
		$sql_email_check = mysql_query("SELECT id FROM groupmembers WHERE email='$email' LIMIT 1");
		$email_check = mysql_num_rows($sql_email_check); 
		if ($email_check > 0){ 
			$errorMsg = 'That email address is already in our system. Try another to register.';
		} else {
			// Add MD5 Hash to the password variable
       		$hashedPass = $password; 
			// Add user info into the database table, claim your fields then values 
			$sql = mysql_query("INSERT INTO groupmembers (name,last_name,country, state, city, email, password, cid,address,access_lvl,number,designation) 
			VALUES('$firstname','$lastname','$country','$state','$city','$email','$hashedPass', '$cid','$address','0','$number','manager')") or die (mysql_error());
			// Get the inserted ID here to use in the activation email
			$id = mysql_insert_id();
			// Create directory(folder) to hold each user files(pics, MP3s, etc.) 
			mkdir("memberFiles/$id", 0755); 
			// Start assembly of Email Member the activation link
			$to = "$email";
			// Change this to your site admin email
			$from = "admin@project360.in";
			$subject = "Complete your registration";
			//Begin HTML Email Message where you need to change the activation URL inside
			$message = '<html>
			<body>
			Hi ' . $firstname . $lastname . ',
			<br /><br />
			We are glad that you wanted to register at Project360. Please click on the following link to activate now &gt;&gt;
			<a href="http://www.project360.in/activation.php?id=' . $id . '">
			ACTIVATE NOW</a>
			<br /><br />
			Your login data is as follows: 
			<br /><br />
			Registration Email Address: ' . $email . ' <br />
			Password: ' . $password . ' <br />
			Group ID: ' . $cid . '  
			<br /><br /> 
			Thanks! 
			</body>
			</html>';
			// end of message
			$headers = "From: $from\r\n";
			$headers .= "Content-type: text/html\r\n";
			$to = "$to";
			// Finally send the activation email to the member
			mail($to, $subject, $message, $headers);
			// Then print a message to the browser for the joiner 
			echo '<div class="defaultFont" style="text-align:center;padding:15px;border-style:solid;border-width:1px;border-color:#CCCCCC;margin:auto;background-color:#E0FFFF;">';
			echo '<span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
			echo 'Alright, <strong>' . $firstname. '</strong>! One last step to verify your email address.<br />
			We just sent you an activation link to: <strong>' . $email . '</strong><br />Check your email inbox in a moment. Click on the activation link. Thats it!<br /></div>';
			exit(); // Exit so the form and page does not display, just this success message
		} // Close else after database duplicate field value checks
  	} // Close else after missing vars check
} //Close if $_POST
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="design.css" type="text/css" />
<title>Project360: Registration</title>
<style type="text/css">
body {
	background-color: #fff;
}
#startCentreContent { /* area between header and footer in pages like login, index */
	margin:20px 15% 20px 15%;
	padding:15px;
	height:468 px;
	border-style:solid;
	border-width:1px;
	border-color:#CCCCCC;
	background-color:#E0FFFF;
	overflow:auto;
}
#startCentreContent #register {
	float:left;
	height:448px;
	width:299px;
	padding:10px;
	border-style:solid;
	border-width:0 1px 0 0;
	border-color:#CCCCCC;
}
#startCentreContent #sCDetail {
	text-align:right;
	margin:0 0 0 320px;
	padding:10px;
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
<div id="register">
<table align="left" width="100%" cellspacing="0" cellpadding="5">
	<tr><td align="left"><span style="font-size:24px">Register</span></td></tr>
  	<form action="join_form.php" method="post" enctype="multipart/form-data">
    <tr>
      <td colspan="2"><span style="font-size:12px;color:#990000"><?php echo "$errorMsg"; ?></span></td>
    </tr>
    <tr>
      <td align="left">First Name:</td>
      <td align="right"><input name="firstname" type="text" size="25" value="<?php echo "$firstname"; ?>" /></td>
    </tr>
    <tr>
      <td align="left">Last Name:</td>
      <td align="right"><input name="lastname" type="text" size="25" value="<?php echo "$lastname"; ?>" /></td>
    </tr>
    <tr>
      <td align="left">Address:</td>
      <td align="right"><textarea name="address" textarea rows="3" cols="20"><?php echo "$address"; ?></textarea></td>
    </tr>
     <tr>
      <td align="left">Number:</td>
      <td align="right"><input name="number" type="text" size="25" value="<?php echo "$number"; ?>" /></td>
    </tr>
    <tr>
      <td align="left">City:</td>
      <td align="right"><input name="city" type="text" size="25" value="<?php echo "$city"; ?>" />
      </td>
    </tr>
    <tr>
      <td align="left">State:</td>
      <td align="right"><input name="state" type="text" size="25" value="<?php echo "$state"; ?>" /></td>
    </tr>
    <tr>
      <td align="left">Country:</td>
      <td align="right"><select size="1" name="country">
      <option value="<?php echo "$country"; ?>"><?php echo "$country"; ?></option>
      <option selected="selected" value="India">India</option>
      </select></td>
    </tr>
    <tr>
      <td align="left">Email:</td>
      <td align="right"><input name="email" type="text" size="25" value="<?php echo "$email"; ?>" /></td>
    </tr>
    <tr>
      <td align="left">Password:</td>
      <td align="right"><input name="password" type="password" size="25" value="<?php echo "$password"; ?>" /></td>
    <tr><td colspan="2" align="right" valign="top"><span style="font-size:10px;color:#666666;">Alphanumeric only</span></td></tr>
    </tr>
   <!-- <tr>
      <td><div align="left"> Captcha: </div></td>
      <td>Add Captcha Here for security</td>
    </tr>-->    
    <tr>
      <td colspan="2" align="right" height="50" valign="bottom"><button type="submit" name="submit" value="register" class="blueBtn">Register</button></td>
    </tr>
  </form>
</table>
</div>
<div id="sCDetail">
<span style="font-size:28px;color:#0099FF;">Project360</span><br/><br />
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
<div id="footer">Created by Ajinkya Patil, Ankit Nair, Parth Mody - 2012</div>
</div>
</body>
</html>