<?php
/* auth.inc.php is used to check whether an user is logged in to view a particular page.
   It must be included in all files of the website where logging in is required. */
session_start();
if (!isset($_SESSION['logged']) && $_SESSION['logged'] != 2012) {
	/* redirect variable is used to store and pass the name of the page the user visited without logging in.
	   After the user logs in, with redirect he'll be sent to the page he was trying to access previously. */
	header('Refresh: 5; URL=/login.php?redirect=' . $_SERVER['PHP_SELF']);
	echo '<p>You are not signed in. You\'ll be redirected to login page in 5 seconds</p>';
	echo '<br /><p>If your browser doesn\'t redirect you automatically, please <a href="login.php?redirect=';
	echo $_SERVER['PHP_SELF'] . '">click here</a>.</p>';
	die();
}
?>
