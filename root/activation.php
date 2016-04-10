<html>
<head>
<title>Project360: Activation</title>
<link rel="stylesheet" href="design.css" type="text/css" />
</head>
<body>
<? 
//Connect to the database through our include 
include_once "connect_to_mysql.php";
// Get the member id from the URL variable
echo '<div style="text-align:center" class="defaultFont"><span style="font-size:24px;color:#0099FF;">Project360</span><br /><br />';
$id = $_REQUEST['id'];
$id = ereg_replace("[^0-9]", "", $id); // filter everything but numbers for security
if (!$id) {
	echo "Sorry! You are probably not logged in. Please log in again.";
	exit();	
}
// Update the database field named 'email_activated' to 1
$sql = mysql_query("UPDATE groupmembers SET emailactivated='1' WHERE id='$id'"); 
// Check the database to see if all is right now 
$sql_doublecheck = mysql_query("SELECT * FROM groupmembers WHERE id='$id' AND emailactivated='1'"); 
$doublecheck = mysql_num_rows($sql_doublecheck); 
if($doublecheck == 0){ 
// Print message to the browser saying we could not activate them
echo '<span style="color:#990000;">Sorry! You account could not be activated.</span></div>'; 
} elseif ($doublecheck > 0) {
// Print a success message to the browser cuz all is good 
// And supply the user with a link to your log in page, please alter that link line 
echo '<span>Congratulations! Your account has now been activated.<br />Click <a href=http://www.project360.in/login.php>here</a> to log in now.</span></div>'; 
} 
?>
</body>
</html>