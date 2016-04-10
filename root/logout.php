<?php
session_start();
session_destroy(); 
if (!session_is_registered('id')) { 
	header('Refresh:5; URL=index.php');
	echo '<html style="background-color: white;"><head><title>Project360: Log Out</title><link rel="stylesheet" href="design.css" type="text/css" /></head>';
	echo '<div style="text-align:center">';
	echo '<span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
	echo '<span>You successfully logged out. Have a nice day!</span></div></html>'; 
} else {
	header('Refresh:6; URL=index.php');
	echo '<html style="background-color: white;"><head><title>Project360: Log Out</title><link rel="stylesheet" href="design.css" type="text/css" /></head>';
	echo '<div style="text-align:center">';
	echo '<span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
	echo '<span style="color:#990000;">Sorry! We couldn\'t log you out due to some problem. You can try again or close this browser to end your session.</span></div></html>';
} 
?>